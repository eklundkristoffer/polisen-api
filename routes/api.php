<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events', function (Request $request) {
    $events = \App\Event::limit(
        $request->limit ? $request->limit : 100
    )->orderBy('id', 'desc');

    if ($request->filled('location_name')) {
        $events->whereIn('location_name', $request->location_name);
    }

    if ($request->filled('selected_types')) {
        $events->whereIn('type', $request->selected_types);
    }

    return $events->get();
});

Route::get('/locations', function () {
    return \App\Event::pluck('location_name')->unique()->values();
});

Route::get('/types', function () {
    return \App\Event::pluck('type')->unique()->values();
});
