<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class ModuleAnyStoresDetails extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_anystores_details';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if ( TL_MODE == 'BE' )
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['anystores_details'][0]).' ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        // Fallback template
        $this->anystores_detailTpl = ($this->anystores_detailTpl) ?: 'anystores_details';

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        // Get ID
        $strAlias = \Input::get('auto_item') ? \Input::get('auto_item') : \Input::get('store');

        // Find published store from ID
        if ( ($objStore = AnyStoresModel::findPublishedByIdOrAlias($strAlias)) !== null )
        {
            // load all details
            $objStore->loadDetails();

            // Get referer for back button
            $objStore->referer = $this->getReferer();

            // generate google map if template and geodata is set
            if ( $this->anystores_mapTpl != '' && is_numeric($objStore->latitude) && is_numeric($objStore->longitude) )
            {
                $objMapTemplate = new \FrontendTemplate($this->anystores_mapTpl);
                $objMapTemplate->setData($objStore->row());

                $objStore->gMap = $objMapTemplate->parse();
            }

            // Template
            $objDetailTemplate = new \FrontendTemplate($this->anystores_detailTpl);
            $objDetailTemplate->setData($objStore->row());

            $this->Template->store = $objDetailTemplate->parse();
        }
        // store not found? throw 404
        //@todo make 404 sexy
        else
        {
            $this->_redirect404();
        }
    }


    /**
     * Redirect to 404 page if entry not found
     * @deprecated
     */
    private function _redirect404()
    {
        $obj404 = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE type='error_404' AND published=1 AND pid=?")->limit(1)->execute($this->getRootIdFromUrl());
        $arr404 = $obj404->fetchAssoc();

        if ( !empty($arr404) ) {

            $this->redirect( $this->generateFrontendUrl($arr404), 404);
            return;

        }
        else
        {
            // @todo make it sexy
            #header('HTTP/1.1 404 Not Found');
            #die('Page not found');
        }
    }
}
