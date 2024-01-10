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

use Tastaturberuf\AnyStoresCategoryModel;

$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{anystores_legend},anystores_sitemap';


/**
 * Selector
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'anystores_sitemap';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['anystores_sitemap'] = 'anystores_detailPage,anystores_categories';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_replace_recursive($GLOBALS['TL_DCA']['tl_page']['fields'] ?? [], array
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
                return [];
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
