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
        $ojCurrentEntity = \Database::getInstance()->prepare('SELECT * FROM ' . $strTable . ' WHERE `alias`=?')->limit(1)->execute(\Input::get('auto_item'));
        $strLangPid = $ojCurrentEntity->langPid;

        if (!$strLangPid) {
            $strLangPid = $ojCurrentEntity->id;
        }

        $arrValues = [$strLanguage, $strLangPid];

        if (!$strLanguage) {
            $strQuery = ' WHERE `language`=? AND id=?';
        } else {
            $strQuery = ' WHERE `language`=? AND langPid=?';
        }

        $objTranslations = \Database::getInstance()->prepare('SELECT alias FROM ' . $strTable . $strQuery)->limit(1)->execute($arrValues);
        $objEvent->getUrlParameterBag()->setUrlAttribute('items', $objTranslations->alias);
    }
}