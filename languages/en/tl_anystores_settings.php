<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015, 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_LANG']['tl_anystores_settings'] = array
(

    // Legends
    'anystores_common_legend' => 'Common settings',
    'anystores_api_legend'    => 'API settings',

    // Fields
    'anystores_defaultMarker' => array('Default Marker for all locations', 'Can be overriden in a module, categoy or location.'),
    'anystores_geoApi'        => array('API provider', 'Choose an API provider from the list above.'),
    'anystores_apiKey'        => array('Google Maps Server API key', 'Will be used for server-side queries.'),
    'anystores_apiBrowserKey' => array('Google Maps Browser API key', 'Will be used to embed JS into the HTML.')

);
