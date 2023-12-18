<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Hooks;

use  Terminal42\DcMultilingualBundle\Driver;
use Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer\Page;

class DataContainer
{

    public function generateVirtualDataContainerArray($strTable): void
    {

        if (isset($GLOBALS['TL_DCA'][$strTable]['config']['dataContainer']) && $GLOBALS['TL_DCA'][$strTable]['config']['dataContainer'] == 'Multilingual') {

            $objPage = new Page();
            $arrLanguages = $objPage->getLanguages();

            $GLOBALS['TL_DCA'][$strTable]['config']['dataContainer'] = Driver::class;
            $GLOBALS['TL_DCA'][$strTable]['config']['_table'] = $strTable;
            $GLOBALS['TL_DCA'][$strTable]['config']['langPid'] = 'lid';
            $GLOBALS['TL_DCA'][$strTable]['config']['langColumnName'] = 'language';
            $GLOBALS['TL_DCA'][$strTable]['config']['fallbackLang'] = $arrLanguages['fallback'];
            $GLOBALS['TL_DCA'][$strTable]['config']['languages'] = $arrLanguages['languages'];
            $GLOBALS['TL_DCA'][$strTable]['fields']['alias']['eval']['isMultilingualAlias'] = true;
        }
    }

    public function generateDataContainerArray($strTable): void
    {

        if (isset($GLOBALS['TL_DCA'][$strTable]['config']['dataContainer']) && $GLOBALS['TL_DCA'][$strTable]['config']['dataContainer'] == 'Multilingual') {

            $GLOBALS['TL_DCA'][$strTable]['config']['_table'] = $strTable;
        }
    }
}