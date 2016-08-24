<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


use Contao\String;

class ModuleAnyStoresSearchMap extends ModuleAnyStoresList
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_anystores_searchmap';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {

            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['anystores_searchmap'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        parent::compile();

        // load Google Maps JavaScript
        $arrParams = $this->anystores_signedIn ? array('signed_in' => 'true') : array();
        GoogleMaps::includeJs($arrParams);

        $GLOBALS['TL_JAVASCRIPT']['markerclusterer'] = 'system/modules/anyStores/assets/js/markerclusterer/src/markerclusterer_compiled.js';

        // map height
        $this->Template->mapHeight = deserialize($this->anystores_mapheight);

        $arrStores = array();

        if ( count($this->Template->rawstores) )
        {
            foreach ( $this->Template->rawstores as $key => $store )
            {
                $arrStores[$key]          = $store;

                // encode email
                $arrStores[$key]['email'] = String::encodeEmail($store['email']);

                // encode logo uuid
                /*
                if ( \Validator::isBinaryUuid($store['logo']['uuid']) )
                {
                    $arrStores[$key]['logo'] = $store['logo']['path'];
                }
                */

                // get marker
                $objMarker = null;

                // global
                if ( \Config::get('anystores_defaultMarker') )
                {
                    $objMarker = \FilesModel::findByPk(\Config::get('anystores_defaultMarker'));
                }

                // module
                if ( $this->anystores_defaultMarker )
                {
                    $objMarker = \FilesModel::findByPk($this->anystores_defaultMarker);
                }

                // category
                $objCategory = AnyStoresCategoryModel::findByPk($store['pid']);

                if ( $objCategory && $objCategory->defaultMarker )
                {
                    $objMarker = \FilesModel::findByPk($objCategory->defaultMarker);
                }

                // local
                if ( $store['marker'] )
                {
                    $objMarker = \FilesModel::findByPk($store['marker']);
                }

                if ( $objMarker )
                {
                    $arrStores[$key]['marker'] = $objMarker->path;
                }
                else
                {
                    $arrStores[$key]['marker'] = null;
                }
            }
        }

        //encode json
        $strJson = json_encode($arrStores, JSON_NUMERIC_CHECK | JSON_PARTIAL_OUTPUT_ON_ERROR);

        if ( !$strJson )
        {
            $this->log(json_last_error_msg(), __METHOD__, TL_ERROR);
            $this->Template->stores = json_encode(array());
        }
        else
        {
            $this->Template->stores = $strJson;
        }

        // center the map
        $arrCoordinates = AnyStores::getLonLat($this->strSearchValue, $this->strCountryValue);

        if ( $arrCoordinates )
        {
            $this->Template->anystores_latitude  = $arrCoordinates['latitude'];
            $this->Template->anystores_longitude = $arrCoordinates['longitude'];
        }
    }

}
