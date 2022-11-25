<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\DataContainer;

class Page {

    public function getLanguages() {

        $objDatabase = \Database::getInstance();
        $arrReturn = ['languages' => [], 'fallback' => ''];
        $objPages = $objDatabase->prepare('SELECT * FROM tl_page WHERE `type`=?')->execute('root');

        if (!$objPages->numRows) {
            return [];
        }

        while ($objPages->next()) {
            if ($objPages->fallback && !$arrReturn['fallback']) {
                $arrReturn['fallback'] = $objPages->language;
            }
            if ($objPages->language && !in_array($objPages->language, $arrReturn['languages'])) {
                $arrReturn['languages'][] = $objPages->language;
            }
        }

        var_dump($arrReturn);
        exit;

        return $arrReturn;
    }
}