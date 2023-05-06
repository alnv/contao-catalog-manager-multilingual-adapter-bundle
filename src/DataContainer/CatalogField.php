<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer;

class CatalogField
{

    public function getLanguages()
    {

        $objPage = new Page();
        $arrPages = $objPage->getLanguages();
        $arrLanguages = $arrPages['languages'] ?? [];
        array_unshift($arrLanguages, '*');

        return $arrLanguages;
    }
}