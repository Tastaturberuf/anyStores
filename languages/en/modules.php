<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              (c) 2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Back end modules
 */
$GLOBALS['TL_LANG']['MOD']['anystores_locations'] = array('Locations', 'Manage locations and search them using geodata.');
$GLOBALS['TL_LANG']['MOD']['anystores_settings']  = array('Settings', 'Manage settings for anyStores.');


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_LANG']['FMD'], 0, array
(
    'anystores'           => 'AnyStores',
    'anystores_search'    => array('anyStores Search',  'Searchform for locations.'),
    'anystores_list'      => array('anyStores List',    'Searchresult list or standard list of locations.'),
    'anystores_details'   => array('anyStores Details', 'Show location details. Need to be redirected from list module.'),
    'anystores_map'       => array('anyStores Map',     'Map with all locations.'),
    'anystores_searchmap' => array('anyStores search result map', 'The Map shows search results.')
));


array_insert($GLOBALS['TL_LANG']['tl_module'], 0, array
(
    'map_legend'     => 'Map settings',
    'map_api_legend' => 'API settings',

    'anystores_defaultCountry'   => array('Default country', 'Which country should be used as default if user did not select any?'),
    'anystores_categories'       => array('Choose category', 'From which category should the stores be displayed?'),
    'anystores_listLimit'        => array('Number of results', 'How many results should be shown?'),
    'anystores_allowEmptySearch' => array('Allow empty search?', 'Should the user be able to submit an empty search to see all results?'),
    'anystores_limitDistance'    => array('Limit distance', 'Do not show stores which exceed the maximum distance.'),
    'anystores_maxDistance'      => array('Max distance', 'The maximum distance in km.'),
    'anystores_sortingOrder'     => array('Sorting order', 'Choose your individual sorting order. Default: postal'),
    'anystores_detailTpl'        => array('Details template', 'Choose which template should be used to show details of the store'),
    'anystores_mapTpl'           => array('Map template', 'Choose a template for the map.'),
    'anystores_latitude'         => array('Latitude', 'Default value for the map.'),
    'anystores_longitude'        => array('Longitude', 'Default value for the map.'),
    'anystores_zoom'             => array('Zoom level', 'Default zoom level for the map.'),
    'anystores_maptype'          => array('Maptype', 'Default maptype.'),
    'anystores_streetview'       => array('Enable StreetView', 'Switch StreetView on or off.'),
    'anystores_mapheight'        => array('Map height', 'In pixel. Add the style attribute to the template.'),
    'anystores_defaultMarker'    => array('Default marker', 'Can be overriden by category and location. Overrides global marker from settings.'),
    'anystores_signedIn'         => array('Signed in', 'Enable the login for the Google Map.'),
    'anystores_mapsApi'          => array('Choose an API', '')
));
