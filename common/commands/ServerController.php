<?php
namespace daemons\commands;

use daemons\daemons\EchoServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = null)
    {
        $server = new EchoServer();
        if ($port) {
            $server->port = $port;
        }
        $server->start();
    }
}