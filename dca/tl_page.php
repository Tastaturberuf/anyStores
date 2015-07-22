<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace
(
    'createSitemap',
    'createSitemap,anystores_sitemap',
    $GLOBALS['TL_DCA']['tl_page']['palettes']['root']
);


/**
 * Selector
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'anystores_sitemap';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['anystores_sitemap'] .= 'anystores_detailPage,anystores_categories';


/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_page']['fields'], 0, array
(
    'anystores_sitemap' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_page']['anystores_sitemap'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => array
        (
            'submitOnChange' => true,
            'tl_class'       => 'clr m12'
        ),
        'sql' => "char(1) NOT NULL default ''"

    ),
    'anystores_detailPage' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_page']['anystores_detailPage'],
        'exclude'   => true,
        'inputType' => 'pageTree',
        'eval'      => array
        (
            'mandatory' => true,
            'fieldType' => 'radio',
        ),
        'sql' => "int(10) unsigned NOT NULL default '0'"
    ),
    'anystores_categories' => array
    (
        'label'            => &$GLOBALS['TL_LANG']['tl_page']['anystores_categories'],
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
    )
));
