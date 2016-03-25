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


class AnyStoresRunonce
{

    public function run()
    {
        $this->changeMapHeight();
    }


    /**
     * Change the map height unit from integer to serialized array for inputUnit widget
     *
     * @since 1.8.0
     */
    protected function changeMapHeight()
    {
        $objModules = \ModuleModel::findAll();

        if ( !objModules )
        {
            return;
        }

        while ( $objModules->next() )
        {
            if ( is_numeric($objModules->anystores_mapheight) )
            {
                $objModules->anystores_mapheight = serialize(array(
                    'unit'  => 'px',
                    'value' => $objModules->anystores_mapheight
                ));
                $objModules->save();
            }
        }
    }

}
