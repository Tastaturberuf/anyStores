<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


array_insert($GLOBALS['TL_LANG']['FFL'], 0, array
(
    'stores' => array('anyStores list', '')
));

array_insert($GLOBALS['TL_LANG']['tl_form_field'], 0, array
(
    'anystores_idField'    => array('Column for the value', ''),
    'anystores_categories' => array('Categories', '')
));
