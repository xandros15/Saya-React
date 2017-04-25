<?php
/**
 * Created by PhpStorm.
 * User: xandros15
 * Date: 2017-04-25
 * Time: 18:23
 */

namespace Xandros15\Saya;


use React\EventLoop\LoopInterface;
use React\Promise\ExtendedPromiseInterface;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

class Bot
{
    /** @var LoopInterface */
    private $loop;
    /** @var Connector */
    private $connector;

    /**  */

    public function __construct()
    {
        $this->loop = \React\EventLoop\Factory::create();
        $this->connector = new Connector($this->loop);
    }

    /**
     * @param $server
     *
     */
    public function run($server)
    {
        /** @var $promise ExtendedPromiseInterface */
        $promise = $this->connector->connect($server);
        $promise->then(function (ConnectionInterface $connection) {
            echo $response = 'USER Tokido-Saya exsubs.anidb.pl Tokido :Tokido-Saya' . "\r\n";
            $connection->write($response);
            echo $response = 'NICK Tokido' . "\r\n";
            $connection->write($response);
            $connection->on('data', function ($message) use ($connection) {
                if (strpos($message, 'PING') === 0) {
                    list(, $response) = explode(':', $message);
                    echo $response = 'PONG ' . $response . "\r\n";
                    $connection->write($response);
                }
                echo $message;
            });
        }, function (...$params) {
            dump($params);
        }, function (...$params) {
            dump($params);
        });

        $this->loop->run();
    }
}
