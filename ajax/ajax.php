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

$intModuleId = (int) \Input::post('module');
$intModuleId = (int) \Input::get('module');

if ( $intModuleId )
{
    // Find module
    $objModule = \ModuleModel::findByPk($intModuleId);

    // Validate module
    if ( !$objModule || $objModule->type !== 'anystores_map' )
    {
        return;
    }

    // Hook to manipulate the module
    if (isset($GLOBALS['TL_HOOKS']['anystores_getAjaxModule']) && is_array($GLOBALS['TL_HOOKS']['anystores_getAjaxModule']))
    {
        foreach ($GLOBALS['TL_HOOKS']['anystores_getAjaxModule'] as $callback)
        {
            \System::importStatic($callback[0])->{$callback[1]}($objModule);
        }
    }

    // Find stores
    $objStores = AnyStoresModel::findPublishedByCategory(deserialize($objModule->anystores_categories));

    if ( !$objStores )
    {
        return;
    }

    while( $objStores->next() )
    {
        // generate jump to
        if ( $objModule->jumpTo )
        {
            if ( ($objLocation = \PageModel::findByPk($objModule->jumpTo)) !== null )
            {
                //@todo language parameter
                $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                $strStoreValue = $objStores->alias;

                $objStores->href = \Controller::generateFrontendUrl(
                    $objLocation->row(),
                    $strStoreKey.$strStoreValue
                );
            }
        }

        // Encode email
        $objStores->email = \String::encodeEmail($objStores->email);
    }

    $arrConfig = array
    (
        'module' => array
        (
            'latitude'   => (float)  $objModule->anystores_latitude,
            'longitude'  => (float)  $objModule->anystores_longitude,
            'zoom'       => (int)    $objModule->anystores_zoom,
            'streetview' => (bool)   $objModule->anystores_streetview,
            'maptype'    => (string) $objModule->anystores_maptype,
        ),
        'stores' => $objStores->fetchAll()
    );

    header('Content-Type: application/json');
    echo json_encode($arrConfig);
}
