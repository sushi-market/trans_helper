<?php

use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (!function_exists('___')) {

    /**
     * @description Extract a key from localization in json object file delimiter "."
     *
     * @param string|null $key
     * @param array       $replace
     * @param string|null $locale
     *
     * @return null|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function ___(?string $key = null, array $replace = [], string $locale = null) : ?string
    {
        if (is_null($key))
            return null;

        $key_list = explode('.', $key);

        if(!is_array($key_list) || !count($key_list))
            return trans($key, $replace, $locale);

        $first_key = $key_list[0];
        array_shift($key_list);

        $translate = app('translator')->get($first_key);

        if (empty($translate) || $translate == $first_key)
            return $key;

        if(is_array($translate)){
            foreach ($key_list as $key_each){
                if (!isset($translate[$key_each])) return $key;

                if(is_string($translate[$key_each])){
                    $translate = &$translate[$key_each];
                    break;
                }
                $translate = &$translate[$key_each];
            }
        }

        if(!is_string($translate))
            return null;

        $shouldReplace = [];

        foreach ($replace as $key => $value) {
            //Для локализаций переменных вида :home
            $shouldReplace[':'.Str::ucfirst($key)] = Str::ucfirst($value);
            $shouldReplace[':'.Str::upper($key)] = Str::upper($value);
            $shouldReplace[':'.$key] = $value;

            //Для локализаций переменных вида {city}
            $shouldReplace['{'.Str::ucfirst($key).'}'] = Str::ucfirst($value);
            $shouldReplace['{'.Str::upper($key).'}'] = Str::upper($value);
            $shouldReplace['{'.$key.'}'] = $value;
        }

        return strtr($translate, $shouldReplace);
    }

}
