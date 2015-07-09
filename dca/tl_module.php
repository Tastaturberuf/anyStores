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
 * Add palettes to tl_module
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['palettes'], 1337, array
(
    'anystores_search' => '
        {title_legend},name,headline,type;
        {config_legend:hide},jumpTo,anystores_allowEmptySearch;
        {template_legend:hide},customTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_list' => '
        {title_legend},name,headline,type;
        {config_legend:hide},anystores_categories,jumpTo,anystores_defaultCountry,anystores_listLimit,anystores_allowEmptySearch,anystores_limitDistance;
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
        {config_legend:hide},anystores_categories,jumpTo;
        {template_legend:hide},customTpl;
        {expert_legend:hide},guests,cssID,space
    '
));


/**
 * Selector
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'anystores_limitDistance';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'anystores_allowEmptySearch';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_allowEmptySearch'] = 'anystores_sortingOrder';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_limitDistance']    = 'anystores_maxDistance';


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
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['anystores_categories'],
        'exclude'          => true,
        'inputType'        => 'checkbox',
        'options_callback' => function()
        {
            $objCategories = AnyStoresCategoryModel::findAll(array('order' => 'title'));

            if ( $objCategories === null )
            {
                return;
            }

            return $objCategories->fetchEach('title');
        },
        'eval' => array
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
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailTpl'],
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function()
        {
            return \Controller::getTemplateGroup('anystores_');
        },
        'eval' => array
        (
            'includeBlankOption' => true,
            'chosen'             => true,
            'tl_class'           => 'w50'
        ),
        'sql' => "varchar(64) NOT NULL default ''"
    ),
    'anystores_mapTpl' => array
    (
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['anystores_mapTpl'],
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function()
        {
            return \Controller::getTemplateGroup('map_');
        },
        'eval' => array
        (
            'includeBlankOption' => true,
            'chosen'             => true,
            'tl_class'           => 'w50'
        ),
        'sql' => "varchar(64) NOT NULL default ''"
    )
));
