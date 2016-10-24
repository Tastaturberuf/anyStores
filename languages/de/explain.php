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
        'Bitte beachten Sie, dass Sie den <b>Server-Key</b> für folgende APIs freischalten müssen.<br>'.
        'Mehr Informationen finden Sie hier: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>'
    ),
    array
    (
        'Google Maps Geocoding API',
        'Zum Berechnen der Geokoordinaten aus einer Adresse.'
    ),
    array
    (
        'Google Static Maps API',
        'Zum Rendern der statischen Karte im Backend.'
    )

);


$GLOBALS['TL_LANG']['XPL']['anystores_apiBrowserKey'] = array
(

    array
    (
        'colspan',
        'Bitte beachten Sie, dass Sie den <b>Browser-Key</b> für folgende APIs freischalten müssen.<br>'.
        'Mehr Informationen finden Sie hier: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>'
    ),
    array
    (
        'Google Maps JavaScript API',
        'Zum Anzeigen der dynamischen Karte.'
    )

);
