<?php

namespace iboxs\swoole\rpc\client;

use Closure;
use Swoole\Coroutine\Client;
use iboxs\File;
use iboxs\helper\Arr;
use iboxs\swoole\concerns\InteractsWithRpcConnector;
use iboxs\swoole\contract\rpc\ParserInterface;
use iboxs\swoole\exception\RpcClientException;
use iboxs\swoole\exception\RpcResponseException;
use iboxs\swoole\rpc\Error;
use iboxs\swoole\rpc\Packer;
use iboxs\swoole\rpc\Protocol;
use iboxs\swoole\rpc\Sendfile;

class Gateway
{
    use Sendfile;

    /** @var Connector */
    protected $connector;

    /** @var ParserInterface */
    protected $parser;

    protected $tries;

    /**
     * Gateway constructor.
     * @param Connector|array $connector
     * @param ParserInterface $parser
     */
    public function __construct($connector, ParserInterface $parser, $tries = 2)
    {
        if (is_array($connector)) {
            $connector = $this->createDefaultConnector($connector);
        }
        $this->connector = $connector;
        $this->parser    = $parser;
        $this->tries     = $tries;
    }

    protected function encodeData(Protocol $protocol)
    {
        $params = $protocol->getParams();

        //有文件,先传输
        foreach ($params as $index => $param) {
            if ($param instanceof File) {
                yield from $this->fread($param);
                $params[$index] = Protocol::FILE;
            }
        }

        $protocol->setParams($params);

        $data = $this->parser->encode($protocol);

        yield Packer::pack($data);
    }

    protected function decodeResponse($response)
    {
        $result = $this->parser->decodeResponse($response);

        if ($result instanceof Error) {
            throw new RpcResponseException($result);
        }

        return $result;
    }

    protected function sendAndRecv($data)
    {
        return $this->connector->sendAndRecv($data, Closure::fromCallable([$this, 'decodeResponse']));
    }

    public function call(Protocol $protocol)
    {
        if ($this->tries > 1) {
            $result = backoff(function () use ($protocol) {
                try {
                    return $this->sendAndRecv($this->encodeData($protocol));
                } catch (RpcResponseException $e) {
                    return $e;
                }
            }, $this->tries);

            if ($result instanceof RpcResponseException) {
                throw $result;
            }

            return $result;
        } else {
            return $this->sendAndRecv($this->encodeData($protocol));
        }
    }

    public function getServices()
    {
        return $this->sendAndRecv(Packer::pack(Protocol::ACTION_INTERFACE));
    }

    protected function createDefaultConnector($config)
    {
        return new class($config) implements Connector {

            use InteractsWithRpcConnector;

            /** @var Client */
            protected $client;
            protected $config;

            /**
             *  constructor.
             * @param [] $config
             */
            public function __construct($config)
            {
                $this->config = $config;
            }

            protected function isConnected(): bool
            {
                return $this->client && $this->client->isConnected() && $this->client->peek() !== '';
            }

            protected function getClient()
            {
                if (!$this->isConnected()) {
                    $client = new Client(SWOOLE_SOCK_TCP);

                    $config = $this->config;

                    $host    = Arr::pull($config, 'host');
                    $port    = Arr::pull($config, 'port');
                    $timeout = Arr::pull($config, 'timeout', 5);

                    $client->set($config);

                    if (!$client->connect($host, $port, $timeout)) {
                        throw new RpcClientException(
                            sprintf('Connect failed host=%s port=%d', $host, $port)
                        );
                    }

                    $this->client = $client;
                }
                return $this->client;
            }

            protected function runWithClient($callback)
            {
                return $callback($this->getClient());
            }
        };
    }
}
