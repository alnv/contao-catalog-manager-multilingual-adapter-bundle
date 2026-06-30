<?php

namespace Alnv\ContaoCatalogManagerMultilingualAdapterBundle\Models;

use Alnv\ContaoCatalogManagerBundle\Helper\Toolkit;
use Contao\System;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Terminal42\DcMultilingualBundle\Model\Multilingual;

class MultilingualDynModel extends Multilingual
{

    public static $strTable = '';

    public function __construct($objResult=null)
    {
        if (System::getContainer()
                ->get('contao.routing.scope_matcher')
                ->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')) && !static::$strTable) {
            static::$strTable = Toolkit::getTableByDo();
        }

        parent::__construct($objResult);
    }

    public static function createDynTable($strTable, $objResult = null)
    {
        static::$strTable = $strTable;

        return new static($objResult);
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