<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class AnyStoresHooks
{

    public function generateBreadcrumb($arrItems, \Module $objModule)
    {
        $strAlias = \Input::get('auto_item') ?: \Input::get('store');

        $objLocation = AnyStoresModel::findPublishedByIdOrAlias($strAlias);

        if ( !$objLocation )
        {
            return $arrItems;
        }

        $intLastKey = (int) count($arrItems) - 1;
        $arrItems[$intLastKey] = array
        (
            'isActive' => 1,
            'title'    => $objLocation->name
        );

        return $arrItems;
    }

}
