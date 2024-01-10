<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_LANG']['FFL'] = array_replace($GLOBALS['TL_LANG']['FFL'] ?? [], array
(
    'stores' => array('anyStores list', '')
));

$GLOBALS['TL_LANG']['tl_form_field'] = array_replace($GLOBALS['TL_LANG']['tl_form_field'] ?? [], array
(
    'anystores_idField'    => array('Column for the value', ''),
    'anystores_categories' => array('Categories', '')
));
