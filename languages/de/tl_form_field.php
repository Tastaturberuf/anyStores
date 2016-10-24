<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


array_insert($GLOBALS['TL_LANG']['FFL'], 0, array
(
    'stores' => array('anyStores Liste', '')
));

array_insert($GLOBALS['TL_LANG']['tl_form_field'], 0, array
(
    'anystores_idField'    => array('Spalte für den Value-Wert', ''),
    'anystores_categories' => array('Kategorien', '')
));
