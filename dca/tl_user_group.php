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
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] .= ';{anystores_legend},anystores_categories,anystores_permissions';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields'] = array_replace_recursive($GLOBALS['TL_DCA']['tl_user_group']['fields'] ?? [], array
(
    'anystores_categories' => array
    (
        'label'      => &$GLOBALS['TL_LANG']['tl_user_group']['anystores_categories'],
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
        'label'     => &$GLOBALS['TL_LANG']['tl_user_group']['anystores_permissions'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'options'   => array
        (
            'create',
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
