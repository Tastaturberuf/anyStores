<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_LANG']['tl_user'] = array_replace($GLOBALS['TL_LANG']['tl_user'] ?? [], array
(

    'anystores_legend' => 'anyStores-Rechte',

    'anystores_categories'  => array('Erlaubte anyStores-Kategorien', 'Hier können Sie den Zugriff auf eine oder mehrere anyStores-Kategorien erlauben.'),
    'anystores_permissions' => array('anyStores-Rechte', 'Hier können Sie die anyStores-Rechte festlegen.')

));
