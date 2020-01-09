<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Hooks;

use Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer\Page;


class VirtualDataContainer {


    public function generateVirtualDataContainerArray( $strTable ) {

        if ( isset( $GLOBALS['TL_DCA'][ $strTable ]['config']['dataContainer'] ) && $GLOBALS['TL_DCA'][ $strTable ]['config']['dataContainer'] == 'Multilingual' ) {

            $objPage = new Page();
            $arrLanguages = $objPage->getLanguages();
            $GLOBALS['TL_DCA'][ $strTable ]['config']['_table'] = 't1';
            $GLOBALS['TL_DCA'][ $strTable ]['config']['langPid'] = 'lid';
            $GLOBALS['TL_DCA'][ $strTable ]['config']['langColumnName'] = 'language';
            $GLOBALS['TL_DCA'][ $strTable ]['config']['fallbackLang'] = $arrLanguages['fallback'];
            $GLOBALS['TL_DCA'][ $strTable ]['config']['languages'] = $arrLanguages['languages'];
        }
    }
}