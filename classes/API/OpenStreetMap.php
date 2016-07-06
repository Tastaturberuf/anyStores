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


class OpenStreetMap
{

    /**
     * Find the longitute and latitude from a location string
     *
     * @param string $strAddress
     * @param string $strCountry
     * @example http://wiki.openstreetmap.org/wiki/Nominatim#Examples
     * @return array|bool
     */
    public static function getLonLat($strAddress, $strCountry = null)
    {
        $strQuery = 'https://nominatim.openstreetmap.org/search?'
            .'q='.rawurlencode($strAddress)
            .'&format=json'
            .'&accept-language='.$GLOBALS['TL_LANGUAGE']
            .'&limit=1';

        if ( $strCountry )
        {
            $strQuery .= '&countrycodes='.$strCountry;
        }

        $objRequest = new \Request();
        $objRequest->send($strQuery);

        // Return on error
        if ( $objRequest->hasError() )
        {
            \System::log("Failed Request '{$strQuery}' with error '{$objRequest->error}'", __METHOD__, TL_ERROR);
            return false;
        }

        $arrResponse = json_decode($objRequest->response);

        // Return on empty response
        if ( !count($arrResponse) )
        {
            \System::log("Empty Request for address '$strAddress': '$strQuery'", __METHOD__, TL_ERROR);
            return false;
        }

        // Display copyright and licence in backend
        if ( TL_MODE == 'BE' )
        {
            \Message::addInfo($arrResponse[0]->licence);
        }

        return array
        (
            'licence'   => $arrResponse[0]->licence,
            'address'   => $arrResponse[0]->display_name,
            'latitude'  => $arrResponse[0]->lat,
            'longitude' => $arrResponse[0]->lon
        );
    }

}
