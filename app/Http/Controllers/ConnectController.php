<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ConnectController extends Controller
{
    private RedisController $redis;

    public function __construct(Request $request)
    {
        $this->redis = new RedisController(
            $request->route()?->parameter('selectedConnection') ?? null
        );
    }

    public function index(?string $selectedConnection = null)
    {
        return Inertia::render('Dashboard', $this->fillInResponse());
    }

    public function show(string $selectedConnection, string $key)
    {
        return Inertia::render('Show', $this->fillInResponse([
            'item' => $this->redis->get($key),
        ]));
    }

    public function serverStats(?string $selectedConnection = null)
    {
        return Inertia::render('Dashboard', $this->fillInResponse([
            'stats' => $this->redis->getStats(),
            'slowLog' => $this->redis->getSlowLog(),
        ]));
    }

    private function fillInResponse(array $response = []): array
    {
        return array_merge($response, [
            'connections' => fn () => $this->redis->getConnections(),
            'selectedConnection' => fn () => $this->redis->getSelectedConnection(),
            'tree' => fn () => $this->redis->index(),
        ]);
    }
}
