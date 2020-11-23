<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models;

use \Terminal42\DcMultilingualBundle\Model\Multilingual;
use Contao\Model\Registry;

class MultilingualDynModel extends Multilingual {

    public static $strTable = '';

    public function __construct($objResult = null) {

        if ( !static::$strTable ) {
            return null;
        }

        parent::__construct($objResult);
    }

    public function createDynTable($strTable, $objResult = null) {

        static::$strTable = $strTable;
        static::$arrClassNames[$strTable] = 'Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models\MultilingualDynModel';
        parent::__construct($objResult);
    }

    public static function findByIdOrAlias($varId, array $arrOptions=[]) {

        if (!isset($arrOptions['column']) && !is_array($arrOptions['column'])) {
            $arrOptions['column'] = [];
        }
        if (!isset($arrOptions['value']) && !is_array($arrOptions['value'])) {
            $arrOptions['value'] = [];
        }

        $strAliasColumn = 'alias';
        if (preg_match('/^[1-9]\d*$/', $varId)) {
            $strAliasColumn = 'id';
        }

        if (isset($GLOBALS['TL_DCA'][static::getTable()]) && $GLOBALS['TL_DCA'][static::getTable()]['fields']['alias']['eval']['isMultilingualAlias']) {
            $strColumn = '(t1.'.$strAliasColumn.'=? OR t2.'.$strAliasColumn.'=?)';
            $arrOptions['value'][] = $varId;
            $arrOptions['value'][] = $varId;
        } else {
            $strColumn = 't1.' . $strAliasColumn . '=?';
            $arrOptions['value'][] = $varId;
        }

        $arrOptions['column'][] = $strColumn;
        $arrOptions['limit'] = 1;
        $arrOptions['return'] = 'Model';

        return static::find($arrOptions);
    }
}