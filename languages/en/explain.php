<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 * @since       1.8.0
 */


$GLOBALS['TL_LANG']['XPL']['anystores_apiKey'] = array
(

    array
    (
        'colspan',
        'Please make sure you’re enable for the <b>server key</b> the following APIs.<br>'.
        'More informations: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>'
    ),
    array
    (
        'Google Maps Geolocation API',
        'Get the geo coordinates from locations.'
    ),
    array
    (
        'Google Static Maps API',
        'To render the static maps in backend.'
    )

);

$GLOBALS['TL_LANG']['XPL']['anystores_apiBrowserKey'] = array
(

    array
    (
        'colspan',
        'Please make sure you’re enable for the <b>browser key</b> the following APIs.<br>'.
        'More informations: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>'
    ),
    array
    (
        'Google Maps JavaScript API',
        'Get the geo coordinates from locations.'
    )

);
