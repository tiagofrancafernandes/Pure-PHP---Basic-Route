<?php

if (!function_exists('dump')) {
    /**
     * function dump
     *
     * @param ...$params
     * @return void
     */
    function dump(...$params): void
    {
        foreach ($params as $param) {
            echo "<pre>" . PHP_EOL;
            var_dump($param);
            echo "</pre>";
        }
    }
}

if (!function_exists('dd')) {
    /**
     * function dd
     *
     * @param ...$params
     * @return void
     */
    function dd(...$params): void
    {
        foreach ($params as $param) {
            echo "<pre>" . PHP_EOL;
            var_dump($param);
            echo "</pre>" . PHP_EOL;
        }
        die();
    }
}
