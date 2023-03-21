<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Inertia\Inertia;

class ConnectController extends Controller
{
    public function index()
    {
        $connections = config('database.redis');
        unset($connections['client'], $connections['options']);

        return Inertia::render('Connections', [
            'connections' => $connections,
            'selected' => key($connections),
        ]);
    }

    public function connect(string $name)
    {
        return Inertia::render('Admin', [
            'alphabet' => (new RedisController())->alphabet($name),
            // 'tree' => (new RedisController())->index($name),
        ]);
    }
}
