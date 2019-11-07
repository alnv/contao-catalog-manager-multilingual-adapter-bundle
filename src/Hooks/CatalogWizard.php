<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Hooks;


class CatalogWizard {


    public function parseCatalogField( $arrField, $arrCatalogField ) {

        if ( $arrCatalogField['translatableFor'] ) {

            $arrLanguages = \StringUtil::deserialize( $arrCatalogField['translatableFor'], true );

            if ( in_array( '*', $arrLanguages ) ) {

                $arrField['eval']['translatableFor'] = '*';
            }
            else {

                $arrField['eval']['translatableFor'] = $arrLanguages;
            }
        }

        return $arrField;
    }
}
