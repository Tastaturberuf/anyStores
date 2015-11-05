<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              (c) 2013, 2014 CLICKPRESS Internetagentur <www.clickpress.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Stefan Schulz-Lauterbach <ssl@clickpress.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class ModuleAnyStoresMap extends \Module // extends ModuleStoreLocatorList
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_anystores_map';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if( TL_MODE == 'BE' )
        {

            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['anystores_map'][0]).' ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        $GLOBALS['TL_JAVASCRIPT']['googleapis-maps'] = 'https://maps.googleapis.com/maps/api/js?language='.$GLOBALS['TL_LANGUAGE'];
        $GLOBALS['TL_JAVASCRIPT']['markerclusterer'] = 'system/modules/anyStores/assets/js/markerclusterer.js';

        // get published stores from categories
        $objStores = AnyStoresModel::findPublishedByCategory(deserialize($this->anystores_categories));

        // return if no stores found
        if ( !$objStores )
        {
            return;
        }

        // generate entries
        while ( $objStores->next() )
        {
            // generate jump to
            //@todo copy do AnyStoresModule and extends from it
            if ( $this->jumpTo )
            {
                if ( ($objLocation = \PageModel::findByPk($this->jumpTo)) !== null )
                {
                    //@todo language parameter
                    $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                    $strStoreValue = $objStores->alias;

                    $objStores->href = \Controller::generateFrontendUrl(
                        $objLocation->row(),
                        $strStoreKey.$strStoreValue
                    );
                }
            }

            // unset logo because json_encode drops error:
            // Malformed UTF-8 characters, possibly incorrectly encoded
            //@todo maybe ->loadDetails() fix it
            $objStores->logo = null;

            // encode email
            $objStores->email = \String::encodeEmail($objStores->email);
        }

        // get all stores
        $arrStores = $objStores->fetchAll();

        $this->Template->entries = $arrStores;

        if ( !$strJson = json_encode($arrStores) )
        {
            $this->log(json_last_error_msg(), __METHOD__, TL_ERROR);
            //@todo stop display the broken module
            return;
        }

        // Temporär
        $this->Template->json = $strJson;


        //@todo cleanup
        $path = 'system/modules/anyStores/html/' . $this->id . '-locations.json';
        $this->Template->path = $path;

        //JSON schreiben
        //@todo: Muss noch in tl_storelocator_map zum save_callback verschoben werden!!!
        #$file   =   new \File($path);
        #$file->write($strJson);
        //@todo language
        #$this->log('Neue JSON-Datei erstellt', __METHOD__, TL_FILES);
    }

}
