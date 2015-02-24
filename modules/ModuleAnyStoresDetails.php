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

        // Detail template fallback
        if ( $this->anystores_detailTpl == '' )
        {
            $this->anystores_detailTpl = 'anystores_details';
        }

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
            // Get referer for back button
            $objStore->referer = $this->getReferer();

            // generate google map
            $objStore->gMap = $this->generateGMap($lon, $lat);

            // Template
            $objTemplate = new \FrontendTemplate($this->anystores_detailTpl);
            $objTemplate->setData($objStore->loadDetails()->row());

            $this->Template->store = $objTemplate->parse();
        }
        // store not found? throw 404
        //@todo make 404 sexy
        else
        {
            $this->_redirect404();
        }
    }

    /**
     *@todo!
     *
     * @param type $lon
     * @param type $lat
     */
    protected function generateGMap($lon, $lat)
    {
        if ( $arrStore['latitude'] != '' && $arrStore['longitude'] != '' )
        {
            // include css
            $GLOBALS['TL_CSS']['anystores'] = 'system/modules/anyStores/assets/css/style.css';

            // static map
            if ( $this->anystores_detailsMaptype == 'static' )
            {
                $arrStore['gMap'] = sprintf(
                    '<img class="store-map-static" src="http://maps.google.com/maps/api/staticmap?center=%s,%s&amp;zoom=15&amp;size=%sx%s&amp;maptype=roadmap&amp;markers=color:red|label:|%s,%s&amp;sensor=false" alt="Google Maps" />',
                    $arrStore['latitude'],
                    $arrStore['longitude'],
                    400,
                    220,
                    $arrStore['latitude'],
                    $arrStore['longitude']
                );
            }
            // dynamic map
            else
            {

                $GLOBALS['TL_JAVASCRIPT'][] = 'https://maps.google.com/maps/api/js?sensor=false';
                $arrStore['gMap'] = '<div id="map_canvas"></div>'."\n"
                    .'<script type="text/javascript">'."\n"
                    .'  function initSLGMap() {'."\n"
                    .'      var latlng = new google.maps.LatLng('.$arrStore['latitude'].', '.$arrStore['longitude'].');'."\n"
                    .'      var options = {'."\n"
                    .'          zoom: 15'."\n"
                    .'      ,   center: latlng'."\n"
                    .'      ,   mapTypeId: google.maps.MapTypeId.ROADMAP'."\n"
                    .'      };'."\n"
                    .'      var map = new google.maps.Map(document.getElementById("map_canvas"),options);'."\n"
                    .'      var marker = new google.maps.Marker({'."\n"
                    .'          position: latlng'."\n"
                    .'      ,   map: map'."\n"
                    .'      ,   title: "'.$arrStore['name'].'"'."\n"
                    .'      });'."\n"
                    .'  } '."\n"
                    .'  initSLGMap(); '."\n"
                    .'</script>'."\n";
            }
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
