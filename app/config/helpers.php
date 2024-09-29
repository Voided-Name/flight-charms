<?php

Flight::map('create_full_url', function (string $route, array $params = []) {
    if (count($params) > 0) {
        return Flight::get('main_url') . Flight::getUrl($route, $params);
    } else {
        return Flight::get('main_url') . Flight::getUrl($route);
    }
});
