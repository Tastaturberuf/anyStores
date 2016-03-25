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


class AnyStoresHooks extends \Controller
{

    /**
     * The "generateBreadcrumb" hook allows to modify the breadcrumb navigation.
     * It passes the navigation items and the frontend module as arguments and
     * expects the items as return value.
     *
     * @param array $arrItems
     * @param \Module $objModule
     * @return array
     */
    public function generateBreadcrumb($arrItems, \Module $objModule)
    {
        $strAlias = \Input::get('auto_item') ?: \Input::get('store');

        $objLocation = AnyStoresModel::findPublishedByIdOrAlias($strAlias);

        if ( !$objLocation )
        {
            return $arrItems;
        }

        $intLastKey = (int) count($arrItems) - 1;
        $arrItems[$intLastKey] = array
        (
            'isActive' => 1,
            'title'    => $objLocation->name
        );

        return $arrItems;
    }


    /**
     * The "prepareFormData" hook is triggered after a form has been submitted.
     * It passes the form data array, the form labels array and the form object
     * as arguments and does not expect a return value. This way the data can be
     * changed or extended, prior to execution of actions like email
     * distribution or data storage.
     *
     * @param array $arrSubmitted
     * @param array $arrLabels
     * @param object $objForm
     */
    public function prepareFormData(&$arrSubmitted, $arrLabels, $objForm)
    {
        if ( !strlen($objForm->anystores_sendEmail) )
        {
            return;
        }

        $strKey = $objForm->anystores_sendEmail;

        $objStore = AnyStoresModel::findPublishedByIdOrAlias($arrSubmitted[$strKey]);

        if ( !$objStore )
        {
            return;
        }

        if ( \Validator::isEmail($objStore->email) )
        {
            $objForm->recipient .= ','.$objStore->email;
        }
    }


    /**
     *
     * @param type $arrSubmitted
     * @param type $arrLabels
     * @param type $objForm
     */
    public function emailNearestStore(&$arrSubmitted, $arrLabels, $objForm)
    {
        if ( $objForm->anystores_emailNearestStore == 1 )
        {
            // if there is no postal field
            if ( !strlen($arrSubmitted['postal']) )
            {
                \System::log("No postal field for email nearest store", __METHOD__, TL_ERROR);
                return;
            }

            $arrSearch[] = $arrSubmitted['street']  ?: null;
            $arrSearch[] = $arrSubmitted['postal']  ?: null;
            $arrSearch[] = $arrSubmitted['city']    ?: null;
            $arrSearch[] = $arrSubmitted['country'] ?: null;

            // drop empty arrays
            $arrSearch = array_filter($arrSearch, 'count');

            // query string
            $strSearch = implode(', ', $arrSearch);

            $objStore = AnyStoresModel::findPublishedByAdressAndCountryAndCategory(
                $strSearch, null, deserialize($objForm->anystores_categories), 1
            );

            if ( !$objStore )
            {
                \System::log("No store found for email", __METHOD__, TL_ERROR);
                return;
            }

            if ( \Validator::isEmail($objStore->email) )
            {
                // legagy contao
                $objForm->recipient .= ','.$objStore->email;

                // efg
                $objForm->formattedMailRecipient .= ','.$objStore->email;
            }
        }
    }


    /**
     * The "replaceInsertTags" hook is triggered when an unknown insert tag is
     * found. It passes the insert tag as argument and expects the replacement
     * value or "false" as return value.
     *
     * anystores::details:[ID]
     * anystores::count:[CategoryID|all]
     *
     * @todo
     * anystores:phone:[ID]
     * anystores:fax:[ID]
     * ...
     *
     * @param string $strTag
     * @return bool | string
     */
    public function replaceInsertTagsHook($strTag)
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
                        // Location template
                        $objLocationTemplate = new \FrontendTemplate('anystores_details');
                        $objLocationTemplate->setData($objStore->loadDetails()->row());

                        // Module template
                        $objModuleTemplate = new \FrontendTemplate('mod_anystores_inserttag');
                        $objModuleTemplate->store = $objLocationTemplate;

                        // Parse module template
                        $strTemplate = $objModuleTemplate->parse();
                        $strTemplate = $this->replaceInsertTags($strTemplate);

                        return $strTemplate;
                    }

                    return false;

                // count category items
                case 'count':

                    if ( $arrKeys[1] == 'all' )
                    {
                        return AnyStoresModel::countAllPublished();
                    }
                    else
                    {
                        return AnyStoresModel::countPublishedByPid($arrKeys[1]);
                    }

                default:
                    \System::log('Invalid anyStores inserttag param: '.$arrKeys[0], __METHOD__, TL_ERROR);
                    return false;
            }
        }
        catch (\Exception $e)
        {
            \System::log('Replace insert tag error: '.$e->getMessage(), __METHOD__, TL_ERROR);
        }

        return false;
    }


    public function getSearchablePages($arrPages, $intRootId=null, $bln=true, $strLanguage=null)
    {
        if ( !$intRootId )
        {
            $objRoots = \PageModel::findPublishedRootPages();

            if ( !$objRoots )
            {
                \System::log("Can't get any root page", __METHOD__, TL_ERROR);
                return $arrPages;
            }

            while ( $objRoots->next() )
            {
                $arrPages = $this->getSearchablePages($arrPages, $objRoots->id, $bln, $objRoots->language );
            }

            return $arrPages;
        }

        // get the root page object
        $objRoot = \PageModel::findByPk($intRootId);

        if ( !$objRoot )
        {
            \System::log("Can't get the root page", __METHOD__, TL_ERROR);
            return $arrPages;
        }


        // check for sitemap enabled
        if ( !$objRoot->anystores_sitemap )
        {
            return $arrPages;
        }


        // get the domain
        $strDomain = ($objRoot->useSSL ? 'https://' : 'http://') . ($objRoot->dns ?: \Environment::get('host')) . TL_PATH . '/';


        // get the details page
        $objPage = \PageModel::findByPk($objRoot->anystores_detailPage);

        if ( !$objPage )
        {
            \System::log("Can't find the details page", __METHOD__, TL_ERROR);
            return $arrPages;
        }


        // get the locations
        $objLocations = AnyStoresModel::findPublishedByCategory(deserialize($objRoot->anystores_categories));

        if ( !$objLocations )
        {
            \System::log("Can't get the published locations", __METHOD__, TL_ERROR);
            return $arrPages;
        }

        while ( $objLocations->next() )
        {
            $strAlias = \Controller::generateFrontendUrl($objLocations->row(), null, $strLanguage);
            $arrPages[] = $strDomain.$objPage->alias.'/'.$strAlias;
        }

        return $arrPages;
    }

}
