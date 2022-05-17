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


class AnyStores
{

    /**
     * Wrap the different geo APIs
     *
     * @param string $strAddress The search string
     * @param string $strCountry country code like DE
     * @return array|bool return the latlon array or false
     */
    public static function getLonLat($strAddress, $strCountry = null)
    {
        // fallback if no API is set
        $strClassName = \Config::get('anystores_geoApi') ? \Config::get('anystores_geoApi') : 'GoogleMaps';

        if ( class_exists($strClassName) )
        {
            $arrCoordinates = $strClassName::getLonLat($strAddress, $strCountry);

            // set licence hint
            $GLOBALS['ANYSTORES_GEODATA_LICENCE_HINT'] = $arrCoordinates['licence'] ?? '';

            return $arrCoordinates;
        }

        return false;
    }


    /**
     * Return the store model if available
     *
     * @since 1.7.2
     * @return object AnyStoresModel | null
     */
    public static function getStoreFromUrl()
    {
        $strAlias = \Input::get('auto_item') ? \Input::get('auto_item') : \Input::get('store');

        return AnyStoresModel::findByAlias($strAlias);
    }

}
