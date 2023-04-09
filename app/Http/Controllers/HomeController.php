<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class HomeController extends Controller
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
        return Inertia::render('Dashboard', $this->fillInResponse([
            'stats' => $this->redis->getStats(),
            'slowLog' => $this->redis->getSlowLog(),
        ]));
    }

    public function show(string $selectedConnection, string $key)
    {
        return Inertia::render('Show', $this->fillInResponse([
            'item' => $this->redis->get($key),
        ]));
    }

    public function destroy(string $selectedConnection, string $key)
    {
        try {
            $this->redis->destroy($key);
            $message = ['status' => true, 'text' => 'Item deleted.'];
        } catch (Throwable $e) {
            $message = ['status' => false, 'text' => $e->getMessage()];
        }

        return to_route('home')->with(['message' => $message]);
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
