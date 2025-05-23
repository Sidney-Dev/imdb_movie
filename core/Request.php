<?php

namespace Core;

class Request {
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function input($key = null) {
        return $key ? ($_POST[$key] ?? null) : $_POST;
    }
}
