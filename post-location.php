<?php
/**
 * Plugin Name: Post Location
 * Description: Allows posts to be geotagged with a location displayed on a map in the post content.
 * Author:      Nathan Stryker
 * Version:     0.0.1
 *
 * @package PL
 */

defined('ABSPATH') || exit();

if (is_readable(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

spl_autoload_register(function ($name) {
    if (0 === strpos($name, 'PL\\')) {
        $fileparts = explode('\\', strtolower(preg_replace('#([a-zA-Z0-9])(?=[A-Z])#', '$1-', str_replace('PL\\', '', $name))));
        $filename  = sprintf('%s.php', end($fileparts));
        $filepath  = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array_merge($fileparts, [ $filename ]));

        if (file_exists($filepath)) {
            require_once $filepath;
        } else {
            throw new Exception(sprintf(__('Unable to load %1$s at %2$s.'), $name, $filepath));
        }
    }
}, true, true);

PL\Data\Geocode::init();
PL\Data\Location::init();
PL\Data\Settings::init();
PL\Service\Geocoder::init();
PL\Views\Map::init();
PL\Views\Location::init();
PL\Views\Settings::init();
