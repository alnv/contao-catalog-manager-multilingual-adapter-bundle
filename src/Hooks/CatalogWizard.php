<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Hooks;

use Contao\StringUtil;

class CatalogWizard
{

    public function parseCatalogField($arrField, $arrCatalogField)
    {

        if ($arrCatalogField['translatableFor']) {

            $arrLanguages = StringUtil::deserialize($arrCatalogField['translatableFor'], true);

            if (in_array('*', $arrLanguages)) {
                $arrField['eval']['translatableFor'] = '*';
            } else {
                $arrField['eval']['translatableFor'] = $arrLanguages;
            }
        }

        return $arrField;
    }

    public function parseCatalog($arrCatalog)
    {

        if ($arrCatalog['dataContainer'] == 'Multilingual') {

            $arrCatalog['_table'] = $arrCatalog['table'];
            $GLOBALS['CM_MODELS'][$arrCatalog['table']] = 'Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models\MultilingualDynModel';
        }

        return $arrCatalog;
    }
}
