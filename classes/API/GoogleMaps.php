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


class GoogleMaps
{

    /**
     * Find the longitute and latitude from a location string
     * @param string $strAddress Optimal format: street (+number), postal, city [country]
     * @param string
     * @return array|bool  return an array with logitute, latitude and address or false if error or empty results
     * @example https://developers.google.com/maps/documentation/geocoding/?hl=de
     */
    public static function getLonLat($strAddress, $strCountry = null)
    {
        // Google Geocoding API v3
        $strQuery = 'https://maps.googleapis.com/maps/api/geocode/json?'
            .'address='.rawurlencode($strAddress)
            .'&sensor=false'
            .'&language='.$GLOBALS['TL_LANGUAGE'];

        if ( $strCountry )
        {
            $strQuery .= '&components=country:'.$strCountry;
        }

        $objRequest = new \Request();
        $objRequest->send($strQuery);

        if ( !$objRequest->hasError() )
        {
            $objResponse = json_decode($objRequest->response);

            // check the possible return status
            switch($objResponse->status)
            {
                case 'OK':
                    return array
                    (
                        'address'   => $objResponse->results[0]->formatted_address,
                        'longitude' => $objResponse->results[0]->geometry->location->lng,
                        'latitude'  => $objResponse->results[0]->geometry->location->lat
                    );
                case 'ZERO_RESULTS':
                case 'OVER_QUERY_LIMIT':
                case 'REQUEST_DENIED':
                case 'INVALID_REQUEST':
                default:
                    \System::log("Google Maps API return error '{$objResponse->status}' for '{$strAddress}'", __METHOD__, TL_ERROR);
                    return false;
            }
        }

        \System::log("Failed Request '{$strQuery}' with error '{$objRequest->error}'", __METHOD__, TL_ERROR);
        return false;
    }

}
