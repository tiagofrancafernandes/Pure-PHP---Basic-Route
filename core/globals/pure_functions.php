<?php

// class-less functions

if (!function_exists('__only')) {
    /**
     * function __only
     *
     * @param array $arraySource
     * @param array $arrayFilter
     * @param ?callable $aditionalCallable
     * @param ?int $mode ARRAY_FILTER_USE_BOTH | ARRAY_FILTER_USE_KEY
     *
     * @return array
     */
    function __only(
        array $arraySource,
        array $arrayFilter,
        ?callable $aditionalCallable = null,
        ?int $mode = ARRAY_FILTER_USE_BOTH
    ): array {
        $data = array_filter(
            $arraySource,
            fn ($item) => in_array($item, array_values($arrayFilter), true),
            array_is_list($arraySource) ? ARRAY_FILTER_USE_BOTH : ARRAY_FILTER_USE_KEY
        );

        if (!$aditionalCallable) {
            return $data;
        }

        $mode = in_array(
            $mode,
            [ARRAY_FILTER_USE_BOTH, ARRAY_FILTER_USE_KEY],
            true
        )
            ? $mode : ARRAY_FILTER_USE_BOTH;

        return array_filter($data, $aditionalCallable, $mode);
    }
}

if (!function_exists('getValidString')) {
    /**
     * function validString
     *
     * @param mixed $item
     * @param ?callable $customValidation
     *
     * @return string
     */
    function validString(mixed $item, ?callable $customValidation = null): string
    {
        if (!$item || !\is_string($item) || !trim($item) || empty($item)) {
            return '';
        }

        if (!$customValidation) {
            return trim($item);
        }

        return !$customValidation($item) ? '' : trim($item);
    }
}

if (!function_exists('explodeAndMerge')) {
    /**
     * function explodeAndMerge
     *
     * @param array $current
     * @param ?string $stringValue
     * @param ?string $separator
     * @param ?bool $stringOnly To use 'string' values only or to merge? If false|null, will merge (use both)
     *
     * @return array
     */
    function explodeAndMerge(
        array $current,
        ?string $stringValue,
        ?string $separator = ',',
        ?bool $stringOnly = false
    ): array {
        $separator = $separator ?: ',';

        $valuesToWork = !$stringOnly ? array_merge(
            $current,
            explode($separator, (string) $stringValue)
        ) : explode($separator, (string) $stringValue);

        return array_unique(
            array_values(
                array_map(
                    'trim',
                    array_filter(
                        $valuesToWork,
                        'trim'
                    )
                )
            )
        );
    }
}

if (!function_exists('arrGetByDot')) {
    /**
     * function arrGetByDot
     * Like \Arr::get on Laravel
     * @param array $sourceData
     * @param string $dotKey
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    function arrGetByDot(array $sourceData, string $dotKey, mixed $defaultValue = null): mixed
    {
        if (!$dotKey || !trim($dotKey)) {
            return $defaultValue ?? null;
        }
        foreach (explode('.', $dotKey) as $key) {
            if (!array_key_exists($key, $sourceData)) {
                return $defaultValue ?? null;
            }

            $sourceData = $sourceData[$key] ?? $defaultValue ?? null;
        }

        return $sourceData ?? $defaultValue ?? null;
    }
}

if (!function_exists('filterUsingDot')) {
    /**
     * function filterUsingDot
     *
     * @param array $sourceData
     * @param array $dotKeys
     *
     * @return mixed
     */
    function filterUsingDot(array $sourceData, array $dotKeys): mixed
    {
        if (!array_is_list($dotKeys)) {
            return null;
        }

        foreach ($dotKeys as $key) {
            if (!$key || !is_string($key)) {
                continue;
            }

            if ($tmp = arrGetByDot($sourceData, $key)) {
                $filtered[$key] = $tmp;
            }
        }

        return $filtered ?? null;
    }
}
