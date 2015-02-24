<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
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
        {config_legend:hide},jumpTo,anystores_defaultCountry,anystores_allowEmptySearch;
        {template_legend:hide},customTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_list' => '
        {title_legend},name,headline,type;
        {config_legend:hide},anystores_categories,anystores_defaultCountry,anystores_listLimit,anystores_allowEmptySearch,anystores_limitDistance,jumpTo;
        {template_legend:hide},customTpl,anystores_detailTpl;
        {expert_legend:hide},guests,cssID,space
    ',
    'anystores_details' => '
        {title_legend},name,headline,type;
        {config_legend:hide},anystores_detailsMaptype;
        {template_legend:hide},customTpl,anystores_detailTpl;
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


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['anystores_limitDistance'] = 'anystores_maxDistance';


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
        'default'   => $GLOBALS['TL_LANGUAGE'],
        'eval'      => array
        (
            'mandatory' => true,
            'chosen'    => true,
            'tl_class'  => 'w50'
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
            'tl_class'  => 'w50 m12',
        ),
        'sql' => "char(1) NOT NULL default ''"
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
    'anystores_detailsMaptype' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailsMaptype'],
        'exclude'   => true,
        'inputType' => 'select',
        //@todo try with reference	&$GLOBALS['TL_LANG'] (string)
        'options'   => array
        (
            'static'  => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailsMaptypes'][0],
            'dynamic' => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailsMaptypes'][1]
        ),
        'sql' => "char(7) NOT NULL default 'static'"
    ),
    'anystores_detailTpl' => array
    (
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['anystores_detailsTpl'],
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
    )
));
