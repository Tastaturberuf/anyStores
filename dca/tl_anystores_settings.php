<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014 - 2016 Tastaturberuf <mail@tastaturberuf.de>
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
        'default' =>
        '
            {anystores_common_legend},anystores_defaultMarker;
            {anystores_api_legend},anystores_geoApi,anystores_apiKey,anystores_apiBrowserKey
        '
    ),

    // Fields
    'fields' => array
    (
        'anystores_defaultMarker' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores_settings']['anystores_defaultMarker'],
            'inputType' => 'fileTree',
            'eval'      => array
            (
                'files'      => true,
                'fieldType'  => 'radio',
                'extensions' => Config::get('validImageTypes'),
            )
        ),
        'anystores_geoApi' => array
        (
            'label'     => $GLOBALS['TL_LANG']['tl_anystores_settings']['anystores_geoApi'],
            'inputType' => 'select',
            //@todo get Classnames from API folder
            'options'   => array
            (
                'GoogleMaps'    => 'Google Maps Geolocation API',
                'OpenStreetMap' => 'OpenStreetMap Nominatim API'
            ),
            'eval' => array
            (
                'tl_class' => 'w50'
            )
        ),
        'anystores_apiKey' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores_settings']['anystores_apiKey'],
            'inputType' => 'text',
            'explanation' => 'anystores_apiKey',
            'eval'      => array
            (
                'helpwizard' => true,
                'tl_class'   => 'w50',
                'mandatory'   => true
            )
        ),
        'anystores_apiBrowserKey' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores_settings']['anystores_apiBrowserKey'],
            'inputType' => 'text',
            'eval'      => array
            (
                'helpwizard' => true,
                'tl_class'   => 'w50',
                'mandatory'   => true
            )
        )
    )

);
