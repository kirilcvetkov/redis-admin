<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Inertia\Inertia;

class ConnectController extends Controller
{
    public function connections(?string $selectedConnection = null)
    {
        $redisController = new RedisController($selectedConnection);

        return Inertia::render('Dashboard', [
            'connections' => $redisController->getConnections(),
            'selectedConnection' => $selectedConnection ?? key($redisController->getConnections()),
            'tree' => $redisController->index(),
        ]);
    }

    public function index(?string $selectedConnection = null)
    {
        $redisController = new RedisController($selectedConnection);

        return Inertia::render('Connections', [
            'connections' => $redisController->getConnections(),
            'selectedConnection' => $selectedConnection ?? key($redisController->getConnections()),
            'tree' => $redisController->index(),
        ]);
    }

    // public function connect(string $selectedConnection)
    // {
    //     return Inertia::render('Admin', [
    //         'tree' => (new RedisController($selectedConnection))->index(),
    //     ]);
    // }

    public function get(string $selectedConnection, string $key)
    {
        $redisController = new RedisController($selectedConnection);
// dd($redisController->show($key));
        return Inertia::render('Admin', [
            'connections' => $redisController->getConnections(),
            'selectedConnection' => $selectedConnection ?? key($redisController->getConnections()),
            'tree' => $redisController->index(),
            'item' => $redisController->show($key),
        ]);
    }
}
