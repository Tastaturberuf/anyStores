<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class AnyStoresDcaHelper
{

    /**
     * Get all anyStores categories
     * 
     * @return array
     */
    public static function getCategories()
    {
        $objCategories = AnyStoresCategoryModel::findAll(array('order' => 'title'));

        if ( !$objCategories )
        {
            return array();
        }

        return $objCategories->fetchEach('title');
    }

}
