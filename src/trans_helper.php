<?php

use Illuminate\Support\Str;

if (!function_exists('___')) {

    /** Extract a key from localization in json object file delimiter "." */
    function ___(string $key = null, array $replace = [], string $locale = null): string
    {
        if (is_null($key)) {
            return '';
        }

        $translate = trans($key, [], $locale);

        if (!empty($translate) && ($translate != $key)) {
            return ___r($translate, $replace);
        }

        $key_list = explode('.', $key);

        if (!is_array($key_list) || !count($key_list))
            return $key;

        $first_key = $key_list[0];
        array_shift($key_list);

        /** @noinspection PhpUnhandledExceptionInspection */
        $translate = app('translator')->get($first_key, [], $locale);

        if (empty($translate) || $translate == $first_key)
            return $key;

        if (is_array($translate)) {
            foreach ($key_list as $key_each) {
                if (!isset($translate[$key_each])) {
                    return $key;
                }

                if (is_string($translate[$key_each])) {
                    $translate = &$translate[$key_each];
                    break;
                }

                $translate = &$translate[$key_each];
            }
        }

        if (!is_string($translate)) {
            return $key;
        }

        return ___r($translate, $replace);
    }

    function ___r($string, $replace): string
    {
        $shouldReplace = [];
        foreach ($replace as $key => $value) {
            // Для локализаций переменных вида ":variable"
            $shouldReplace[':' . Str::ucfirst($key)] = Str::ucfirst($value);
            $shouldReplace[':' . Str::upper($key)] = Str::upper($value);
            $shouldReplace[':' . $key] = $value;

            // Для локализаций переменных вида "{variable}"
            $shouldReplace['{' . Str::ucfirst($key) . '}'] = Str::ucfirst($value);
            $shouldReplace['{' . Str::upper($key) . '}'] = Str::upper($value);
            $shouldReplace['{' . $key . '}'] = $value;
        }

        return strtr($string, $shouldReplace);
    }
}
