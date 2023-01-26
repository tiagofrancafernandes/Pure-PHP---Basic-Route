<?php

namespace App\Helpers;

use Utils\View;

class Helpers
{
    /**
     * function getView
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    public static function getView(string $view, array $data = []): string
    {
        $viewRender = new View(
            __DIR__ . '/../../Resources/views/'
        );

        return $viewRender->renderView($view, $data);
    }

    /**
     * function view
     *
     * @param string $view
     * @param array $data
     *
     * @return void
     */
    public static function view(string $view, array $data = [])
    {
        print_r(static::getView($view, $data), true);
    }
}
