<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


define('TL_MODE', 'FE');

require '../../../initialize.php';

$action     = \Input::post('action');
$categories = explode(',', \Input::post('categories'));

if ( $action === 'findPublishedByCategory' && count($categories) )
{
    $objStores = AnyStoresModel::findPublishedByCategory($categories);

    if ( $objStores )
    {
        echo json_encode($objStores->fetchAll());
    }
}
