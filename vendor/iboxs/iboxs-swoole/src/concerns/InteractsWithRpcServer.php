<?php

namespace iboxs\swoole\concerns;

use Swoole\Coroutine\Server;
use Swoole\Coroutine\Server\Connection;
use iboxs\App;
use iboxs\swoole\contract\rpc\ParserInterface;
use iboxs\swoole\Pool;
use iboxs\swoole\rpc\Error;
use iboxs\swoole\rpc\File;
use iboxs\swoole\rpc\JsonParser;
use iboxs\swoole\rpc\Packer;
use iboxs\swoole\rpc\server\Dispatcher;
use Throwable;

/**
 * Trait InteractsWithRpc
 * @package iboxs\swoole\concerns
 * @property App $app
 * @property App $container
 * @method Pool getPools()
 */
trait InteractsWithRpcServer
{
    protected function createRpcServer()
    {
        $this->bindRpcParser();
        $this->bindRpcDispatcher();

        $host = $this->getConfig('rpc.server.host', '0.0.0.0');
        $port = $this->getConfig('rpc.server.port', 9000);

        $server = new Server($host, $port, false, true);

        $server->handle(function (Connection $conn) {

            $this->runInSandbox(function (App $app, Dispatcher $dispatcher) use ($conn) {
                $files = [];
                while (true) {
                    //接收数据
                    $data = $conn->recv();

                    if ($data === '' || $data === false) {
                        break;
                    }
                    begin:
                    if (!isset($handler)) {
                        try {
                            [$handler, $data] = Packer::unpack($data);
                        } catch (Throwable $e) {
                            //错误的包头
                            $result = Error::make(Dispatcher::INVALID_REQUEST, $e->getMessage());
                            $this->runWithBarrier(function () use ($dispatcher, $app, $conn, $result) {
                                $dispatcher->dispatch($app, $conn, $result);
                            });
                            break;
                        }
                    }

                    $result = $handler->write($data);

                    if (!empty($result)) {
                        $handler = null;
                        if ($result instanceof File) {
                            $files[] = $result;
                        } else {
                            $this->runWithBarrier(function () use ($dispatcher, $app, $conn, $result, $files) {
                                $dispatcher->dispatch($app, $conn, $result, $files);
                            });
                            $files = [];
                        }
                    }

                    if (!empty($data)) {
                        goto begin;
                    }
                }

                $conn->close();
            });
        });

        $server->start();
    }

    protected function prepareRpcServer()
    {
        if ($this->getConfig('rpc.server.enable', false)) {

            $workerNum = $this->getConfig('rpc.server.worker_num', swoole_cpu_num());

            $this->addBatchWorker($workerNum, [$this, 'createRpcServer'], 'rpc server');
        }
    }

    protected function bindRpcDispatcher()
    {
        $services   = $this->getConfig('rpc.server.services', []);
        $middleware = $this->getConfig('rpc.server.middleware', []);

        $this->app->make(Dispatcher::class, [$services, $middleware]);
    }

    protected function bindRpcParser()
    {
        $parserClass = $this->getConfig('rpc.server.parser', JsonParser::class);

        $this->app->bind(ParserInterface::class, $parserClass);
        $this->app->make(ParserInterface::class);
    }

}
