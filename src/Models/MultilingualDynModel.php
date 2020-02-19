<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models;

use \Terminal42\DcMultilingualBundle\Model\Multilingual;
use Contao\Model\Registry;

class MultilingualDynModel extends Multilingual {

    public static $strTable = '';

    public function __construct( $objResult = null ) {

        if ( !static::$strTable ) {

            return null;
        }

        parent::__construct( $objResult );
    }

    public function createDynTable( $strTable, $objResult = null ) {

        static::$strTable = $strTable;
        static::$arrClassNames[ $strTable ] = 'Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models\MultilingualDynModel';
        parent::__construct( $objResult );
    }

    public static function findByIdOrAlias( $varId, array $arrOptions = [] ) {

        $blnIsAlias = !preg_match( '/^[1-9]\d*$/', $varId );

        if ( !$blnIsAlias && empty( $arrOptions ) ) {

            $objModel = Registry::getInstance()->fetch( static::$strTable, $varId );

            if ($objModel !== null) {

                return $objModel;
            }
        }

        $arrOptions = array_merge(
            [
                'limit'  => 1,
                'column' => $blnIsAlias ? [ "t1.alias=?" ] : [ "t1.id=?" ],
                'value'  => $varId,
                'return' => 'Model'
            ],
            $arrOptions
        );

        return static::find( $arrOptions );
    }
}