<?php

namespace Utils;

use App\Helpers\Helpers;

class Response
{
    public const TYPES = [
        'json' => [
            'header' => ['Content-Type', 'application/json; charset=UTF-8'],
            'callable' => 'json_encode',
        ],
        'html' => [
            'header' => ['Content-Type', 'text/html; charset=UTF-8'],
            'callable' => 'print',
        ],
        'plain' => [
            'header' => ['Content-Type', 'text/plain; charset=UTF-8'],
            'callable' => 'sprintf',
        ],
    ];

    /**
     * function asType
     *
     * @param string $type
     * @param mixed $data,
     * @param int $httpCode = 200,
     * @param array $headers = []
     *
     * @return void
     */
    public static function asType(
        string $type,
        $data,
        int $httpCode = 200,
        array $headers = []
    ): void
    {
        http_response_code($httpCode);

        foreach ($headers as $key => $value) {
            static::setHeader($key, $value);
        }

        $typeData = static::TYPES[$type] ?? static::TYPES['html'] ?? null;
        $key = $typeData['header'][0] ?? null;
        $value = $typeData['header'][1] ?? null;
        $callable = $typeData['callable'] ?? null;
        static::setHeader($key, $value);

        if (is_callable($callable)) {
            try {
                $result = call_user_func($callable, $data);
                die($result);
            } catch (\Throwable $th) {
                //throw $th;
                http_response_code(500);
            }
            die();
        }

        die();
    }

    /**
     * function json
     *
     * @param mixed $data,
     * @param int $httpCode = 200,
     * @param array $headers = []
     *
     * @return void
     */
    public static function json(
        $data,
        int $httpCode = 200,
        array $headers = []
    ): void
    {
        static::asType('json', $data, $httpCode, $headers);
        die();
    }

    /**
     * function html
     *
     * @param string $data,
     * @param int $httpCode = 200,
     * @param array $headers = []
     *
     * @return void
     */
    public static function html(
        string $data,
        int $httpCode = 200,
        array $headers = []
    ): void
    {
        static::asType('html', $data, $httpCode, $headers);
        die();
    }

    /**
     * function view
     *
     * @param string $view
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     *
     * @return string
     */
    public static function view(
        string $view,
        array $data = [],
        int $httpCode = 200,
        array $headers = []
    ) {
        static::html(
            Helpers::getView($view, $data),
            $httpCode,
            $headers
        );
        die();
    }

    /**
     * function setHeader
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public static function setHeader($key, $value): void
    {
        if (
            !$key || !$value ||
            !is_string($key) || !is_string($value) ||
            !trim($key) || !trim($value)
        ) {
            return;
        }

        $key = trim($key);
        $value = trim($value);

        header("{$key}: {$value}", true);
    }
}
