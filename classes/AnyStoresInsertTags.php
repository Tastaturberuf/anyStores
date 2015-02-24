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


/**
 * AnyStores insert tags
 *
 * anystores::details:[ID]
 * anystores::count:[CategoryID|all]
 *
 * @todo
 * anystores:phone:[ID]
 * anystores:fax:[ID]
 * ...
 *
 */
class AnyStoresInsertTags extends \Controller
{
    /**
     * The "replaceInsertTags" hook is triggered when an unknown insert tag is
     * found. It passes the insert tag as argument and expects the replacement
     * value or "false" as return value.
     *
     * @param string $strTag
     * @return bool | string
     */
    public function replaceTags($strTag)
    {
        $arrElements = explode('::', $strTag);

        if ( $arrElements[0] != 'anystores' )
        {
            return false;
        }

        $arrKeys = explode(':', $arrElements[1]);

        try
        {
            switch( $arrKeys[0] )
            {
                // get store details
                case 'details':

                    if ( ($objStore = AnyStoresModel::findPublishedByIdOrAlias($arrKeys[1])) !== null )
                    {
                        // Child template
                        $objTemplate = new \FrontendTemplate('anystores_details');
                        $objTemplate->setData($objStore->loadDetails()->row());

                        // Module template
                        $this->Template = new \FrontendTemplate('mod_anystores_inserttag');
                        $this->Template->store = $objTemplate;

                        // Parse module template
                        $strTemplate = $this->Template->parse();
                        $strTemplate = $this->replaceInsertTags($strTemplate);

                        return $strTemplate;
                    }

                    return false;
                    break;
                // count category items
                case 'count':
                    if ( $arrKeys[1] == 'all' )
                    {
                        return AnyStoresModel::countAll();
                    }
                    else
                    {
                        return AnyStoresModel::countBy('pid', $arrKeys[1]);
                    }
                default:
                    return false;
            }
        }
        catch (\Exception $e)
        {
            $this->log('Replace insert tag error: '.$e->getMessage(), __METHOD__, TL_ERROR);
        }

        return false;
    }

}
