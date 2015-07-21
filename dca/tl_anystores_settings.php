<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_DCA']['tl_anystores_settings'] = array
(

	// Config
	'config' => array
	(
		'dataContainer' => 'File',
		'closed'        => true
	),

	// Palettes
	'palettes' => array
	(
		'default' => '{anystores_api_legend},anystores_geoApi'
	),

	// Fields
	'fields' => array
	(
		'anystores_geoApi' => array
        (
            'label' => $GLOBALS['TL_LANG']['tl_anystores_settings']['anystores_geoApi'],
            'inputType' => 'select',
            //@todo get Classnames from API folder
            'options' => array
            (
                'GoogleMaps'    => 'Google Maps Geolocation API',
                'OpenStreetMap' => 'OpenStreetMap Nominatim API'
            )
        )
	)
);
