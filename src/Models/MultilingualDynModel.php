<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models;

use Doctrine\DBAL\Query\QueryBuilder;
use Terminal42\DcMultilingualBundle\Model\Multilingual;

class MultilingualDynModel extends Multilingual
{

    public static $strTable = '';

    public function __construct($objResult = null)
    {

        if (!static::$strTable) {
            return;
        }

        parent::__construct($objResult);
    }

    public function createDynTable($strTable, $objResult = null): void
    {

        static::$strTable = $strTable;

        //if (isset(static::$arrClassNames)) {
            //static::$arrClassNames[$strTable] = static::class;
        //}

        try {
            parent::__construct($objResult);
        } catch (\Exception $exception) {
            //
        }
    }

    public static function findByIdOrAlias($varId, array $arrOptions = [])
    {

        if (!isset($arrOptions['column']) || !\is_array($arrOptions['column'])) {
            $arrOptions['column'] = [];
        }

        if (!isset($arrOptions['value']) || !\is_array($arrOptions['value'])) {
            $arrOptions['value'] = [];
        }

        $strAliasColumn = 'alias';
        if (\preg_match('/^[1-9]\d*$/', $varId)) {
            $strAliasColumn = 'id';
        }

        if (isset($GLOBALS['TL_DCA'][static::getTable()]) && ($GLOBALS['TL_DCA'][static::getTable()]['fields']['alias']['eval']['isMultilingualAlias'] ?? false)) {
            $strColumn = '(' . static::getTable() . '.' . $strAliasColumn . '=? OR translation.' . $strAliasColumn . '=?)';
            $arrOptions['value'][] = $varId;
        } else {
            $strColumn = static::getTable() . '.' . $strAliasColumn . '=?';
        }
        $arrOptions['value'][] = $varId;

        $arrOptions['column'][] = $strColumn;
        $arrOptions['limit'] = 1;
        $arrOptions['return'] = 'Model';

        return static::find($arrOptions);
    }

    protected static function applyOptionsToQueryBuilder(QueryBuilder $qb, array $options): void
    {

        if (!empty($options['column'])) {
            if (\is_array($options['column'])) {
                foreach ($options['column'] as $column) {
                    $qb->andWhere($column);
                }
            } else {

                $table = static::getTable();
                $qb->andWhere("$table.{$options['column']}=?");
            }
        }

        if (!empty($options['group'])) {
            $qb->groupBy($options['group']);
        }


        if (!empty($options['having'])) {
            $qb->having($options['having']);
        }


        if (!empty($options['order'])) {
            $qb->orderBy($options['order'], '');
        }
    }
}