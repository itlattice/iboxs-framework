<?php

namespace iboxs\swoole\command;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Dumper;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpFile;
use iboxs\console\Command;
use iboxs\helper\Arr;
use iboxs\swoole\contract\rpc\ParserInterface;
use iboxs\swoole\rpc\client\Gateway;
use iboxs\swoole\rpc\client\Service;
use iboxs\swoole\rpc\JsonParser;
use function Swoole\Coroutine\run;

class RpcInterface extends Command
{
    public function configure()
    {
        $this->setName('rpc:interface')
            ->setDescription('Generate Rpc Service Interfaces');
    }

    public function handle()
    {
        run(function () {
            $file = new PhpFile;
            $file->addComment('This file is auto-generated.');
            $file->setStrictTypes();
            $services = [];

            $clients = $this->app->config->get('swoole.rpc.client', []);

            foreach ($clients as $name => $config) {

                $parserClass = Arr::get($config, 'parser', JsonParser::class);
                /** @var ParserInterface $parser */
                $parser = new $parserClass;

                $gateway = new Gateway($config, $parser, Arr::get($config, 'tries', 2));

                $result = $gateway->getServices();

                $namespace = $file->addNamespace("rpc\\contract\\{$name}");

                $namespace->addUse(Service::class);

                foreach ($result as $interface => $methods) {

                    $services[$name][] = $namespace->getName() . "\\{$interface}";

                    $class = $namespace->addInterface($interface);

                    $class->addExtend(Service::class);

                    foreach ($methods as $methodName => ['parameters' => $parameters, 'returnType' => $returnType, 'comment' => $comment]) {
                        $method = $class->addMethod($methodName)
                            ->setVisibility(ClassType::VISIBILITY_PUBLIC)
                            ->setComment(Helpers::unformatDocComment($comment))
                            ->setReturnType($returnType);

                        foreach ($parameters as $parameter) {
                            if ($parameter['type'] && (class_exists($parameter['type']) || interface_exists($parameter['type']))) {
                                $namespace->addUse($parameter['type']);
                            }
                            $param = $method->addParameter($parameter['name'])
                                ->setType($parameter['type']);

                            if (array_key_exists('default', $parameter)) {
                                $param->setDefaultValue($parameter['default']);
                            }

                            if (array_key_exists('nullable', $parameter)) {
                                $param->setNullable();
                            }
                        }
                    }
                }
            }

            $dumper = new Dumper();

            $services = 'return ' . $dumper->dump($services) . ';';

            file_put_contents($this->app->getBasePath() . 'rpc.php', $file . $services);

            $this->output->writeln('<info>Succeed!</info>');
        });
    }
}
