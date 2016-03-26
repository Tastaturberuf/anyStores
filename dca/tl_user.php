<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] .= ';{anystores_legend},anystores_categories,anystores_permissions';
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] .= ';{anystores_legend},anystores_categories,anystores_permissions';


/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_user']['fields'], 0, array
(
    'anystores_categories' => array
    (
        'label'      => &$GLOBALS['TL_LANG']['tl_user']['anystores_categories'],
        'exclude'    => true,
        'inputType'  => 'checkbox',
        'foreignKey' => 'tl_anystores_category.title',
        'eval'       => array
        (
            'multiple' => true
        ),
        'sql' => "blob NULL"
    ),
    'anystores_permissions' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_user']['anystores_permissions'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'options'   => array
        (
            'create',
            'edit',
            'content',
            'delete'
        ),
        'reference' => &$GLOBALS['TL_LANG']['MSC'],
        'eval'      => array
        (
            'multiple' => true
        ),
        'sql' => "blob NULL"
    )
));
