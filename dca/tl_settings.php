<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */

// Add palette
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .=
'
    ;{anystores_legend},anystores_geoApi
';


// Add field
array_insert($GLOBALS['TL_DCA']['tl_settings']['fields'], 0, array
(
    'anystores_geoApi' => array
    (
        'label' => $GLOBALS['TL_LANG']['tl_settings']['anystores_geoApi'],
        'inputType' => 'select',
        //@todo get Classnames from API folder
        'options' => array
        (
            'GoogleMaps'    => 'Google Maps Geolocation API',
            'OpenStreetMap' => 'OpenStreetMap Nominatim API (experimental)'
        )
    )
));
