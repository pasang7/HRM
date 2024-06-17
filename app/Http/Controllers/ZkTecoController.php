<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Rats\Zkteco\Lib\ZKTeco;

class ZkTecoController extends Controller
{
    //

    public function deviceInfo()
    {
        $zk = new ZKTeco('192.168.0.190');
        $zk->connect();
        $zk->enableDevice();
        dump($zk->getUser());
        dump($zk->getAttendance());
    }
}
