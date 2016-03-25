<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class ModuleAnyStoresMap extends \Module
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
        $GLOBALS['TL_JAVASCRIPT']['anystores']       = 'system/modules/anyStores/assets/js/anystores.js';
        $GLOBALS['TL_JAVASCRIPT']['markerclusterer'] = 'system/modules/anyStores/assets/js/markerclusterer/markerclusterer_compiled.js';

        // map height
        $this->Template->mapHeight = deserialize($this->anystores_mapheight);
    }

}
