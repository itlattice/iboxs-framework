<?php

namespace iboxs\swoole;

use RuntimeException;
use Swoole\Http\Response;
use iboxs\Event;
use iboxs\swoole\websocket\Pusher;
use iboxs\swoole\websocket\Room;

/**
 * Class Websocket
 */
class Websocket
{
    /**
     * @var \iboxs\App
     */
    protected $app;

    /**
     * @var Room
     */
    protected $room;

    /**
     * Scoket sender's fd.
     *
     * @var string
     */
    protected $sender;

    /** @var Event */
    protected $event;

    /** @var Response */
    protected $client;

    protected $connected = true;

    /**
     * Websocket constructor.
     *
     * @param \iboxs\App $app
     * @param Room $room
     * @param Event $event
     */
    public function __construct(\iboxs\App $app, Room $room, Event $event)
    {
        $this->app   = $app;
        $this->room  = $room;
        $this->event = $event;
    }

    /**
     * @return Pusher
     */
    protected function makePusher()
    {
        return $this->app->invokeClass(Pusher::class);
    }

    public function to(...$values)
    {
        return $this->makePusher()->to(...$values);
    }

    public function push($data)
    {
        $this->makePusher()->to($this->getSender())->push($data);
    }

    public function emit(string $event, ...$data)
    {
        $this->makePusher()->to($this->getSender())->emit($event, ...$data);
    }

    /**
     * Join sender to multiple rooms.
     *
     * @param string|integer|array $rooms
     *
     * @return $this
     */
    public function join($rooms): self
    {
        $rooms = is_string($rooms) || is_int($rooms) ? func_get_args() : $rooms;

        $this->room->add($this->getSender(), $rooms);

        return $this;
    }

    /**
     * Make sender leave multiple rooms.
     *
     * @param array|string|integer $rooms
     *
     * @return $this
     */
    public function leave($rooms = []): self
    {
        $rooms = is_string($rooms) || is_int($rooms) ? func_get_args() : $rooms;

        $this->room->delete($this->getSender(), $rooms);

        return $this;
    }

    public function setConnected($connected)
    {
        $this->connected = $connected;
    }

    public function isEstablished()
    {
        return $this->connected;
    }

    /**
     * Close current connection.
     */
    public function close()
    {
        if ($this->client) {
            $this->client->close();
        }
    }

    /**
     * @param Response $response
     */
    public function setClient($response)
    {
        $this->client = $response;
    }

    /**
     * Set sender fd.
     *
     * @param string
     *
     * @return $this
     */
    public function setSender(string $fd)
    {
        $this->sender = $fd;
        return $this;
    }

    /**
     * Get current sender fd.
     */
    public function getSender()
    {
        if (empty($this->sender)) {
            throw new RuntimeException('Cannot use websocket as current client before handshake!');
        }
        return $this->sender;
    }
}
