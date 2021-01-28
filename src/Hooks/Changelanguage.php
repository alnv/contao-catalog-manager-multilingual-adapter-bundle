<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Hooks;

class Changelanguage {

    public function onChangelanguageNavigation(\Terminal42\ChangeLanguage\Event\ChangelanguageNavigationEvent $objEvent) {

        if (empty($GLOBALS['CM_MASTER'])) {
            return null;
        }

        $objRoot = $objEvent->getNavigationItem()->getRootPage();
        $strLanguage = $objRoot->rootLanguage;

        if ($objRoot->fallback) {
            $strLanguage = '';
        }

        $strTable = $GLOBALS['CM_MASTER']['_table'];
        if (!$strTable) {
            return null;
        }

        \Controller::loadDataContainer($strTable);
        if ($GLOBALS['TL_DCA'][$strTable]['config']['dataContainer'] != 'Multilingual') {
            return null;
        }

        $strLanguageColumn = $GLOBALS['TL_DCA'][$strTable]['config']['langColumnName'];
        $strLangPidColumn = $GLOBALS['TL_DCA'][$strTable]['config']['langPid'];

        $ojCurrentEntity = \Database::getInstance()->prepare('SELECT * FROM ' . $strTable . ' WHERE `alias`=?')->limit(1)->execute(\Input::get('auto_item'));
        $strLangPid = $ojCurrentEntity->{$strLangPidColumn};

        if (!$strLangPid) {
            $strLangPid = $ojCurrentEntity->id;
        }

        $arrValues = [$strLanguage, $strLangPid];

        if (!$strLanguage) {
            $strQuery = ' WHERE `'.$strLanguageColumn.'`=? AND id=?';
        } else {
            $strQuery = ' WHERE `'.$strLanguageColumn.'`=? AND '.$strLangPidColumn.'=?';
        }

        $objTranslations = \Database::getInstance()
            ->prepare('SELECT alias FROM ' . $strTable . $strQuery)
            ->limit(1)
            ->execute($arrValues);
        if (!$objTranslations->numRows) {
            return null;
        }

        $objEvent->getUrlParameterBag()->setUrlAttribute('items', $objTranslations->alias);
    }
}