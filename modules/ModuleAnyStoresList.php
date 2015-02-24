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


class ModuleAnyStoresList extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_anystores_list';


    /**
     * Localized parameters
     */
    protected $strSearchKey;
    protected $strSearchValue;
    protected $strCountryKey;
    protected $strCountryValue;


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if( TL_MODE == 'BE' )
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['anystores_list'][0]).' ###';
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
        // hide list when details shown
        //@todo make optinonal in module
        if ( strlen(\Input::get('auto_item')) || strlen(\Input::get('store')) )
        {
            return;
        }

        // localized url parameter
        //@todo use $GLOBALS['TL_URL_PARAMS']...
        $this->strSearchKey    = $GLOBALS['TL_LANG']['anystores']['parameter']['search'];
        $this->strSearchValue  = \Input::get($this->strSearchKey);
        $this->strCountryKey   = $GLOBALS['TL_LANG']['anystores']['parameter']['country'];
        $this->strCountryValue = \Input::get($this->strCountryKey);

        // if no empty search is allowed
        if ( !$this->anystores_allowEmptySearch && !$this->strSearchValue && $this->strCountryValue )
        {
            $this->Template->error = $GLOBALS['TL_LANG']['anystores']['noResults'];
            return;
        }

        if ( !$this->strSearchValue )
        {
            $objStore = \AnyStoresModel::findPublishedByCategoryAndCountry(
                deserialize($this->anystores_categories),
                $this->anystores_defaultCountry,
                array('order'=>'postal')
            );
        }
        else
        {
            $objStore = $this->getStoresFromSearch();
        }

        if ( !$objStore )
        {
            $this->Template->error = $GLOBALS['TL_LANG']['anystores']['noResults'];
            return;
        }

        while( $objStore->next() )
        {
            $objTemplate = new \Contao\FrontendTemplate($this->anystores_detailTpl);

            // generate jump to
            if ( $this->jumpTo )
            {
                if ( ($objLocation = \PageModel::findByPk($this->jumpTo)) !== null )
                {
                    //@todo language parameter
                    $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                    $strStoreValue = $objStore->alias;

                    $objStore->href = \Controller::generateFrontendUrl(
                        $objLocation->row(),
                        $strStoreKey.$strStoreValue
                    );
                }
            }

            $objTemplate->setData($objStore->current()->loadDetails()->row());

            $arrStores[] = $objTemplate->parse();
        }

        $this->Template->stores = $arrStores;
    }


    /**
     * @todo maybe put in model class function($this) return null|0|Collection
     * @return \Model\Collection
     */
    protected function getStoresFromSearch()
    {
        $this->strCategories = implode(',', deserialize($this->anystores_categories));

        // get coordninates from search value
        $arrCoordinates = AnyStores::getLonLat($this->strSearchValue, $this->strCountryValue);

        // return if no coordinates
        if ( !$arrCoordinates )
        {
            $this->Template->error = $GLOBALS['TL_LANG']['anystores']['noCoods'];
            return;
        }

        // get licence from api
        $this->Template->licence = $arrCoordinates['licence'];

        //@todo module config kilometers or miles
        $objResult = \Database::getInstance()
            ->prepare("
                SELECT
                    *,
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance
                FROM
                    tl_anystores
                WHERE
                    pid IN ($this->strCategories)
                ".(($this->anystores_limitDistance) ? "HAVING distance < {$this->anystores_maxDistance} ": '')."
                    AND country = ? AND
                    ((start='' OR start<UNIX_TIMESTAMP()) AND (stop='' OR stop>UNIX_TIMESTAMP()) AND published=1)
                ORDER BY
                    distance
            ")
            ->limit($this->anystores_listLimit)
            ->execute(
                $arrCoordinates['latitude'],
                $arrCoordinates['longitude'],
                $arrCoordinates['latitude'],
                $this->strCountryValue
            );

        // return if no stores found
        if ( !$objResult->numRows )
        {
            $this->Template->error = $GLOBALS['TL_LANG']['anystores']['noResults'];
            return;
        }

        // Create store models from database result
        while ( $objResult->next() )
        {
            $arrModels[] = new AnyStoresModel($objResult);
        }

        // Return model collection
        return new \Model\Collection($arrModels, 'tl_anystores');
    }

}
