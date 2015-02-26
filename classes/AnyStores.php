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
     * @deprecated
     */
    public static function loadStoreDetails(array $arrStore, $jumpTo = null)
    {
        //load country names
        //@todo load only once. not every time.
        $arrCountryNames = \System::getCountries();

        //full localized country name
        //@todo rename country to countrycode in database
        $arrStore['countrycode'] = $arrStore['country'];
        $arrStore['country']     = $arrCountryNames[$arrStore['countrycode']];

        // generate jump to
        if ( $jumpTo )
        {
            if ( ($objLocation = \PageModel::findByPk($jumpTo)) !== null )
            {
                //@todo language parameter
                $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                $strStoreValue = $arrStore['alias'];

                $arrStore['href'] = \Controller::generateFrontendUrl(
                    $objLocation->row(),
                    $strStoreKey.$strStoreValue
                );
            }
        }

        // opening times
        $arrStore['opening_times'] = deserialize($arrStore['opening_times']);

        // store logo
        //@todo change size and properties in module
        if ( $arrStore['logo'] )
        {
            if ( ($objLogo = \FilesModel::findByUuid($arrStore['logo'])) !== null )
            {
                $arrLogo = $objLogo->row();
                $arrMeta = deserialize($arrLogo['meta']);
                $arrLogo['meta'] = $arrMeta[$GLOBALS['TL_LANGUAGE']];

                $arrStore['logo'] = $arrLogo;
            }
            else
            {
                $arrStore['logo'] = null;
            }
        }

        return $arrStore;
    }


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
            $GLOBALS['ANYSTORES_GEODATA_LICENCE_HINT'] = $arrCoordinates['licence'];

            return $arrCoordinates;
        }

        return false;
    }

}
