<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Backend Modules
 */
$GLOBALS['BE_MOD']['content']['anystores'] = array
(
    'tables'       => array('tl_anystores_category', 'tl_anystores', 'tl_content'),
    'icon'         => 'system/modules/anyStores/assets/images/anystores.png',
    'stylesheet'   => 'system/modules/anyStores/assets/themes/default/backend.css',
    'importStores' => array( 'ModuleAnyStoresImporter', 'showImport' )
);


/**
 * Frontend Modules
 */
$GLOBALS['FE_MOD']['anystores'] = array
(
    'anystores_search'  => 'ModuleAnyStoresSearch',
    'anystores_list'    => 'ModuleAnyStoresList',
    'anystores_details' => 'ModuleAnyStoresDetails',
    'anystores_map'     => 'ModuleAnyStoresMap'
);


/**
 * Register Hooks
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][]  = array('AnyStoresHooks', 'replaceInsertTags');
$GLOBALS['TL_HOOKS']['generateBreadcrumb'][] = array('AnyStoresHooks', 'generateBreadcrumb');


/**
 * Models
 */
array_insert($GLOBALS['TL_MODELS'], 0, array
(
    'tl_anystores_category' => 'Tastaturberuf\AnyStoresCategoryModel',
    'tl_anystores'          => 'Tastaturberuf\AnyStoresModel'
));


/**
 * Auto item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'store';


/**
 * Add attribution info
 */
if ( Input::get('do') == 'anystores' )
{
    //@todo language
    //@todo in github and repository
    //Message::addInfo('anyStores icons under <a href="http://creativecommons.org/licenses/by/3.0/legalcode" target="_blank">Creative Commons Attribution 3.0 License</a> by <a href="http://p.yusukekamiyamane.com/" target="_blank">Yusuke Kamiyamane</a>.');
}
