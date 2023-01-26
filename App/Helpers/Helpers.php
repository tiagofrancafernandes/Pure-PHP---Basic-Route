<?php

namespace App\Helpers;

use Utils\View;

class Helpers
{
    /**
     * function view
     *
     * @param string $view
     * @param array $data
     * @return string
     */
    public static function view(string $view, array $data = []): string
    {
        $view = new View(
            __DIR__ . '/../../Resources/views/'
        );
        return $view->renderView('pages.index', $data);
    }
}
