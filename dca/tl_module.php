<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Add palettes to tl_module
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['palettes'], 1337, array
(
    'anystores_search' => '
        {title_legend},name,headline,type;
        {config_legend},jumpTo,anystores_allowEmptySearch;
        {template_legend:hide},customTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_list' => '
        {title_legend},name,headline,type;
        {config_legend},anystores_categories,jumpTo,anystores_defaultCountry,anystores_listLimit,anystores_allowEmptySearch,anystores_limitDistance;
        {template_legend:hide},customTpl,anystores_detailTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_details' => '
        {title_legend},name,headline,type;
        {template_legend:hide},customTpl,anystores_detailTpl,anystores_mapTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_map' => '
        {title_legend},name,headline,type;
        {config_legend},anystores_categories,jumpTo;
        {map_legend},anystores_latitude,anystores_longitude,anystores_mapheight,anystores_defaultMarker;
        {map_api_legend},anystores_mapsApi;
        {template_legend:hide},customTpl,anystores_detailTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_searchmap' => '
        {title_legend},name,headline,type;
        {config_legend},anystores_categories,jumpTo,anystores_defaultCountry,anystores_listLimit,anystores_allowEmptySearch,anystores_limitDistance;
        {map_legend},anystores_latitude,anystores_longitude,anystores_mapheight,anystores_defaultMarker;
        {map_api_legend},anystores_mapsApi;
        {template_legend:hide},customTpl,anystores_detailTpl;
        {expert_legend:hide},guests,cssID,space
    '
));


/**
 * Selector
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'anystores_mapsApi';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'anystores_limitDistance';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'anystores_allowEmptySearch';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_mapsApi_GoogleMaps'] = 'anystores_zoom,anystores_maptype,anystores_streetview,anystores_signedIn';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_allowEmptySearch']   = 'anystores_sortingOrder';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_limitDistance']      = 'anystores_maxDistance';


/**
 * Add fields to tl_module
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['fields'], 0, array
(
    'anystores_defaultCountry' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_defaultCountry'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => System::getCountries(),
        'eval'      => array
        (
            'includeBlankOption' => true,
            'chosen'             => true,
            'tl_class'           => 'w50'
        ),
        'sql' => "varchar(2) NOT NULL default ''"
    ),
    'anystores_categories' => array
    (
        'label'      => &$GLOBALS['TL_LANG']['tl_module']['anystores_categories'],
        'exclude'    => true,
        'inputType'  => 'checkbox',
        'foreignKey' => 'tl_anystores_category.title',
        'eval'       => array
        (
            'mandatory' => true,
            'multiple'  => true
        ),
        'sql' => "text NULL"
    ),
    'anystores_listLimit' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_listLimit'],
        'exclude'   => true,
        'inputType' => 'text',
        'default'   => '10',
        'eval'      => array
        (
            'mandatory' => true,
            'maxlength' => 4,
            'rgxp'      => 'digit',
            'tl_class'  => 'w50'
        ),
        'sql' => "smallint(4) unsigned NOT NULL default '10'"
    ),
    // hasEmptySearch?
    'anystores_allowEmptySearch' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_allowEmptySearch'],
        'exclude'   => true,    
        'inputType' => 'checkbox', 
        'default'   => true, 
        'eval'      => array
        (
            'submitOnChange' => true,
            'tl_class'       => 'w50 m12',
        ),
        'sql' => "char(1) NOT NULL default ''"
    ),
    'anystores_sortingOrder' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_sortingOrder'],
        'exclude'   => true,
        'inputType' => 'text',
        'default'   => 'postal',
        'eval'      => array
        (
            'maxlength' => 64,
            'tl_class'  => 'w50'
        ),
        'sql' => "varchar(64) NOT NULL default ''"
    ),
    // hasDistanceLimit
    'anystores_limitDistance' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_limitDistance'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => array
        (
            'submitOnChange' => true,
            'tl_class'       => 'w50 m12 clr'
        ),
        'sql' => "char(1) NOT NULL default ''"
    ),
    'anystores_maxDistance' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_maxDistance'],
        'exclude'   => true,
        'inputType' => 'text',
        'default'   => '10',
        'eval'      => array
        (
            'mandatory' => true,
            'maxlength' => 5,
            'rgxp'      => 'digit',
            'tl_class'  => 'w50'
        ),
        'sql' => "smallint(5) unsigned NOT NULL default '10'"
    ),
    'anystores_detailTpl' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailTpl'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => Controller::getTemplateGroup('anystores_'),
        'eval'      => array
        (
            'includeBlankOption' => true,
            'chosen'             => true,
            'tl_class'           => 'w50'
        ),
        'sql' => "varchar(64) NOT NULL default ''"
    ),
    'anystores_mapTpl' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_mapTpl'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => Controller::getTemplateGroup('map_'),
        'eval'      => array
        (
            'includeBlankOption' => true,
            'chosen'             => true,
            'tl_class'           => 'w50'
        ),
        'sql' => "varchar(64) NOT NULL default ''"
    ),
    'anystores_latitude' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_latitude'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => array
        (
            'mandatory' => true,
            'default'   => 0,
            'maxlength' => 64,
            'tl_class'  => 'w50'
        ),
        'sql' => "float(10,6) NOT NULL"
    ),
    'anystores_longitude' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_longitude'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => array
        (
            'mandatory' => true,
            'default'   => 0,
            'maxlength' => 64,
            'tl_class'  => 'w50'
        ),
        'sql' => "float(10,6) NOT NULL"
    ),
    'anystores_zoom' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_zoom'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => range(1,18),
        'eval'      => array
        (
            'default'   => 6,
            'tl_class'  => 'clr w50'
        ),
        'sql' => "tinyint(2) unsigned NOT NULL default '6'"
    ),
    'anystores_streetview' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_streetview'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => array
        (
            'tl_class'  => 'w50 m12'
        ),
        'sql' => "char(1) NOT NULL default ''"
    ),
    'anystores_maptype' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_maptype'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => array
        (
            'roadmap',
            'satellite',
            'hybrid',
            'terrain'
        ),
        'eval'      => array
        (
            'tl_class'  => 'w50'
        ),
        'sql' => "varchar(9) NOT NULL default 'roadmap'"
    ),
    'anystores_mapheight' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_mapheight'],
        'exclude'   => true,
        'inputType' => 'inputUnit',
        'options'   => $GLOBALS['TL_CSS_UNITS'],
        'eval'      => array
        (
            'default'   => 500,
            'maxlength' => 3,
            'rgxp'      => 'digit',
            'tl_class'  => 'w50'
        ),
        'sql' => "varchar(255) NOT NULL default ''"
    ),
    'anystores_defaultMarker' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_defaultMarker'],
        'exclude'   => true,
        'inputType' => 'fileTree',
        'eval'      => array
        (
            'files'      => true,
            'fieldType'  => 'radio',
            'extensions' => Config::get('validImageTypes'),
            'tl_class'   => 'w50'
        ),
        'sql' => "binary(16) NULL"
    ),
    'anystores_mapsApi' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_mapsApi'],
        'inputType' => 'select',
        'options'   => array
        (
            'GoogleMaps' => 'Google Maps',
        ),
        'eval' => array
        (
            'submitOnChange' => true,
            'tl_class'       => 'w50'
        ),
        'sql' => "varchar(32) NOT NULL default 'GoogleMaps'"
    ),
    'anystores_signedIn' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_signedIn'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => array
        (
            'tl_class' => 'w50 m12'
        ),
        'sql' => "char(1) NOT NULL default ''"
    )

));
