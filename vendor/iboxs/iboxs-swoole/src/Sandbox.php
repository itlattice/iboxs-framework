<?php

namespace iboxs\swoole;

use Closure;
use InvalidArgumentException;
use ReflectionObject;
use RuntimeException;
use iboxs\App;
use iboxs\Config;
use iboxs\Container;
use iboxs\Event;
use iboxs\exception\Handle;
use iboxs\swoole\App as SwooleApp;
use iboxs\swoole\concerns\ModifyProperty;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\coroutine\Context;
use iboxs\swoole\resetters\ClearInstances;
use iboxs\swoole\resetters\ResetConfig;
use iboxs\swoole\resetters\ResetEvent;
use iboxs\swoole\resetters\ResetModel;
use iboxs\swoole\resetters\ResetPaginator;
use iboxs\swoole\resetters\ResetService;
use Throwable;

class Sandbox
{
    use ModifyProperty;

    /**
     * The app containers in different coroutine environment.
     *
     * @var SwooleApp[]
     */
    protected $snapshots = [];

    /** @var SwooleApp */
    protected $app;

    /** @var Config */
    protected $config;

    /** @var Event */
    protected $event;

    /** @var ResetterInterface[] */
    protected $resetters = [];
    protected $services  = [];

    public function __construct(Container $app)
    {
        $this->setBaseApp($app);
        $this->initialize();
    }

    public function setBaseApp(Container $app)
    {
        $this->app = $app;

        return $this;
    }

    public function getBaseApp()
    {
        return $this->app;
    }

    protected function initialize()
    {
        Container::setInstance(function () {
            return $this->getApplication();
        });

        $this->setInitialConfig();
        $this->setInitialServices();
        $this->setInitialEvent();
        $this->setInitialResetters();

        return $this;
    }

    public function run(Closure $callable)
    {
        $this->init();
        $app = $this->getApplication();
        try {
            $app->invoke($callable, [$this]);
        } catch (Throwable $e) {
            $app->make(Handle::class)->report($e);
        } finally {
            $this->clear();
        }
    }

    public function init()
    {
        $app = $this->getApplication(true);
        $this->setInstance($app);
        $this->resetApp($app);
    }

    public function clear()
    {
        if ($app = $this->getSnapshot()) {
            $app->clearInstances();
            unset($this->snapshots[$this->getSnapshotId()]);
        }

        Context::clear();
        $this->setInstance($this->getBaseApp());
    }

    public function getApplication($init = false)
    {
        $snapshot = $this->getSnapshot($init);
        if ($snapshot instanceof Container) {
            return $snapshot;
        }

        if ($init) {
            $snapshot = clone $this->getBaseApp();
            $this->setSnapshot($snapshot);

            return $snapshot;
        }
        throw new InvalidArgumentException('The app object has not been initialized');
    }

    protected function getSnapshotId($init = false)
    {
        return Context::getRootId($init);
    }

    /**
     * Get current snapshot.
     * @return App|null
     */
    public function getSnapshot($init = false)
    {
        return $this->snapshots[$this->getSnapshotId($init)] ?? null;
    }

    public function setSnapshot(Container $snapshot)
    {
        $this->snapshots[$this->getSnapshotId()] = $snapshot;

        return $this;
    }

    public function setInstance(Container $app)
    {
        $app->instance('app', $app);
        $app->instance(Container::class, $app);

        $reflectObject   = new ReflectionObject($app);
        $reflectProperty = $reflectObject->getProperty('services');
        $reflectProperty->setAccessible(true);
        $services = $reflectProperty->getValue($app);

        foreach ($services as $service) {
            $this->modifyProperty($service, $app);
        }
    }

    /**
     * Set initial config.
     */
    protected function setInitialConfig()
    {
        $this->config = clone $this->getBaseApp()->config;
    }

    protected function setInitialEvent()
    {
        $this->event = clone $this->getBaseApp()->event;
    }

    /**
     * Get config snapshot.
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getServices()
    {
        return $this->services;
    }

    protected function setInitialServices()
    {
        $app = $this->getBaseApp();

        $services = $this->config->get('swoole.services', []);

        foreach ($services as $service) {
            if (class_exists($service) && !in_array($service, $this->services)) {
                $serviceObj               = new $service($app);
                $this->services[$service] = $serviceObj;
            }
        }
    }

    /**
     * Initialize resetters.
     */
    protected function setInitialResetters()
    {
        $app = $this->getBaseApp();

        $resetters = [
            ClearInstances::class,
            ResetConfig::class,
            ResetEvent::class,
            ResetService::class,
            ResetModel::class,
            ResetPaginator::class,
        ];

        $resetters = array_merge($resetters, $this->config->get('swoole.resetters', []));

        foreach ($resetters as $resetter) {
            $resetterClass = $app->make($resetter);
            if (!$resetterClass instanceof ResetterInterface) {
                throw new RuntimeException("{$resetter} must implement " . ResetterInterface::class);
            }
            $this->resetters[$resetter] = $resetterClass;
        }
    }

    /**
     * Reset Application.
     *
     * @param App $app
     */
    protected function resetApp(App $app)
    {
        foreach ($this->resetters as $resetter) {
            $resetter->handle($app, $this);
        }
    }

}
