<?php

use Illuminate\Support\Facades\Route;

/**
 * Cek apakah route aktif untuk nav link.
 */
// aktif untuk child
function activeClass($routes, $class = 'active')
{
    return in_array(Route::currentRouteName(), (array) $routes) ? $class : '';
}

// open untuk parent
function menuOpen($routes, $class = 'menu-open')
{
    return in_array(Route::currentRouteName(), (array) $routes) ? $class : '';
}