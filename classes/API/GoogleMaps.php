<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */

namespace Tastaturberuf;


use Contao\Config;
use function http_build_query;

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
        $strUrl = 'https://maps.googleapis.com/maps/api/geocode/json';

        $arrParams = array
        (
            'address' => $strAddress
        );

        if ( \Config::get('anystores_apiKey') )
        {
            $arrParams['key'] = \Config::get('anystores_apiKey');
        }

        $strQuery = $strUrl.'?'.http_build_query($arrParams, '', '&');

        if ( $strCountry )
        {
            $strQuery .= '&components=country:'.strtoupper($strCountry);
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
                    \System::log("Google Maps API return error '{$objResponse->status}' for '{$strAddress}': {$objResponse->error_message}", __METHOD__, TL_ERROR);
                    return false;
            }
        }

        \System::log("Failed Request '{$strQuery}' with error '{$objRequest->error}'", __METHOD__, TL_ERROR);
        return false;
    }


    /**
     * Add Javascript library to HTML output.
     */
    public static function includeJs(array $params = []): void
    {
        $params['language'] ??= $GLOBALS['TL_LANGUAGE'];
        $params['key'] ??= Config::get('anystores_apiBrowserKey');
        $params['callback'] ??= 'Function.prototype';

        $GLOBALS['TL_JAVASCRIPT']['googleapis-maps'] = 'https://maps.googleapis.com/maps/api/js?' . http_build_query($params, '', '&') . '|defer';
    }

}
