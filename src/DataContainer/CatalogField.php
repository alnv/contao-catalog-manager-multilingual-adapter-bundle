<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer;


class CatalogField {


    public function getLanguages() {

        $objPage = new Page();
        $arrLanguages =  $objPage->getLanguages()['languages'];
        array_unshift( $arrLanguages, '*' );

        return $arrLanguages;
    }
}