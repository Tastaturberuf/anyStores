<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 *              (c) 2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class ModuleAnyStoresSearch extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_anystores_search';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if( TL_MODE == 'BE' )
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['anystores_search'][0]).' ###';
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
        // unique form id
        $strFormId = 'anystores_search_'.$this->id;

        // localize url parameter keys
        $strSearchKey    = $GLOBALS['TL_LANG']['anystores']['url_params']['search'] ?: 'search';
        $strSearchValue  = \Input::post($strSearchKey);

        $strCountryKey   = $GLOBALS['TL_LANG']['anystores']['url_params']['country'] ?: 'country';
        $strCountryValue = \Input::post($strCountryKey);


        // redirect if form was send
        if ( \Input::post('FORM_SUBMIT') == $strFormId && ($this->anystores_allowEmptySearch || !empty($strSearchValue)) )
        {
            $intPageId = $this->jumpTo ?: $GLOBALS['objPage']->id;
            $objPage   = \PageModel::findByPk($intPageId);

            if ( $objPage )
            {
                /**
                 * Build url
                 * @example /search/_term_/country/_de_
                 */
                $strPageUrl = $this->generateFrontendUrl($objPage->row(),
                     "/{$strSearchKey}/".$this->encodeSearchValue($strSearchValue)
                    ."/{$strCountryKey}/".$strCountryValue
                );

                $this->redirect($strPageUrl, 302);
            }

            $this->log("Can't find redirect page in module ID {$this->id}", __METHOD__, TL_ERROR);
        }

        // render countries for the dropdown
        if ( ($objCountries = AnyStoresModel::findAllPublished()) !== null )
        {
            $arrCountries    = array_unique($objCountries->fetchEach('country'));
            $arrCountryNames = \System::getCountries();

            foreach ( $arrCountries as $country )
            {
                $arrCountryOptions[$country] = $arrCountryNames[$country];
            }

            asort($arrCountryOptions);

            $this->Template->countryOptions = $arrCountryOptions;
        }

        $this->Template->formId       = $strFormId;
        $this->Template->formAction   = \Environment::get('indexFreeRequest');

        $this->Template->searchName   = $strSearchKey;
        $this->Template->searchId     = 'ctrl_search_'.$this->id;
        $this->Template->searchValue  = \Input::get($strSearchKey);

        $this->Template->countryName  = $strCountryKey;
        $this->Template->countryId    = 'ctrl_country_'.$this->id;
        $this->Template->countryValue = \Input::get($strCountryKey) ?: $GLOBALS['TL_LANGUAGE'];
    }


    /**
     * Encode the search value
     * @param string $strValue
     * @return string The encoded search value
     */
    protected function encodeSearchValue($strValue)
    {
        return rawurlencode(str_replace(array('?', '/', '#'), '', $strValue));
    }

}
