<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models;

use Alnv\ContaoCatalogManagerBundle\Helper\Toolkit;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Terminal42\DcMultilingualBundle\Model\Multilingual;

class MultilingualDynModel extends Multilingual
{

    public static $strTable = '';

    public function __construct($objResult = null)
    {
        if (System::getContainer()
                ->get('contao.routing.scope_matcher')
                ->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')) && !static::$strTable) {
            self::$strTable = Toolkit::getTableByDo();
        }

        if (($GLOBALS['CM_TEMP_MODEL_TABLE'] && self::$strTable !== $GLOBALS['CM_TEMP_MODEL_TABLE'])) {
            self::$strTable = $GLOBALS['CM_TEMP_MODEL_TABLE'];
        }

        if (!static::$strTable) {
            return null;
        }

        parent::__construct($objResult);
    }

    public function createDynTable($strTable, $objResult = null)
    {
        self::$strTable = $strTable;

        return new self($objResult);
    }

    public static function findByIdOrAlias($varId, array $arrOptions = [])
    {

        if (!isset($arrOptions['column']) || !is_array($arrOptions['column'])) {
            $arrOptions['column'] = [];
        }

        if (!isset($arrOptions['value']) || !is_array($arrOptions['value'])) {
            $arrOptions['value'] = [];
        }

        $strAliasColumn = 'alias';
        if (preg_match('/^[1-9]\d*$/', $varId)) {
            $strAliasColumn = 'id';
        }

        if (isset($GLOBALS['TL_DCA'][static::getTable()]) && ($GLOBALS['TL_DCA'][static::getTable()]['fields']['alias']['eval']['isMultilingualAlias'] ?? false)) {
            $strColumn = '(' . static::getTable() . '.' . $strAliasColumn . '=? OR translation.' . $strAliasColumn . '=?)';
            $arrOptions['value'][] = $varId;
            $arrOptions['value'][] = $varId;
        } else {
            $strColumn = static::getTable() . '.' . $strAliasColumn . '=?';
            $arrOptions['value'][] = $varId;
        }

        $arrOptions['column'][] = $strColumn;
        $arrOptions['limit'] = 1;
        $arrOptions['return'] = 'Model';

        return static::find($arrOptions);
    }
}