<?php

namespace App\Http\Controllers;

use App\Models\RedisConnection;
use Illuminate\Http\Request;

class RedisConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RedisConnection::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request...

        $connection = new RedisConnection;

        $connection->name = $request->name;
        $connection->host = $request->host;
        $connection->port = $request->port;
        $connection->username = $request->username;
        $connection->password = $request->password;
        $connection->database = $request->database;

        return $connection->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
