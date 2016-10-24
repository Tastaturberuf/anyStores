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

        // Fallback template
        $this->anystores_detailTpl = ($this->anystores_detailTpl) ?: 'anystores_details';

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
        $this->strSearchKey    = $GLOBALS['TL_LANG']['anystores']['url_params']['search'] ?: 'search';
        $this->strSearchValue  = \Input::get($this->strSearchKey);

        $this->strCountryKey   = $GLOBALS['TL_LANG']['anystores']['url_params']['country'] ?: 'country';
        $this->strCountryValue = (\Input::get($this->strCountryKey)) ?: $this->anystores_defaultCountry;

        // if no empty search is allowed
        if ( !$this->anystores_allowEmptySearch && !$this->strSearchValue && $this->strCountryValue )
        {
            $this->Template->error = $GLOBALS['TL_LANG']['anystores']['noResults'];
            return;
        }

        if ( !$this->strSearchValue )
        {
            // order
            $arrOptions =
            [
                'limit' => $this->anystores_listLimit
            ];

            if ( strlen($this->anystores_sortingOrder) )
            {
                $arrOptions['order'] = $this->anystores_sortingOrder;
            }

            $objStore = AnyStoresModel::findPublishedByCategoryAndCountry(
                deserialize($this->anystores_categories),
                $this->strCountryValue,
                $arrOptions
            );
        }
        else
        {
            $objStore = AnyStoresModel::findPublishedByAdressAndCountryAndCategory(
                $this->strSearchValue,
                $this->strCountryValue,
                deserialize($this->anystores_categories),
                $this->anystores_listLimit,
                ($this->anystores_limitDistance)?$this->anystores_maxDistance:null
            );
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

            $arrStore = $objStore->current()->loadDetails()->row();

            $objTemplate->setData($arrStore);

            $arrStores[]    = $objTemplate->parse();
            $arrRawStores[] = $arrStore;
        }

        $this->Template->stores    = $arrStores;
        $this->Template->rawstores = $arrRawStores;

        // set licence hint
        $this->Template->licence = $GLOBALS['ANYSTORES_GEODATA_LICENCE_HINT'];
    }

}
