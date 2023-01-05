<?php

namespace DreamFactory\Core\As400\Database\Query\Processors;

use DreamFactory\Core\As400\Database\Query\Grammars\As400Grammar;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor;

class As400Processor extends Processor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $sql
     * @param array $values
     * @param string $sequence
     *
     * @return int/array
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $sequenceStr = $sequence ?: 'id';

        if (is_array($sequence)) {
            $grammar = new As400Grammar;
            $sequenceStr = $grammar->columnize($sequence);
        }

        $sqlStr = 'select %s from new table (%s)';

        $finalSql = sprintf($sqlStr, $sequenceStr, $sql);
        $results = $query->getConnection()
            ->select($finalSql, $values);

        if (is_array($sequence)) {
            return array_values((array)$results[0]);
        } else {
            $result = (array)$results[0];
            if (isset($result[$sequenceStr])) {
                $id = $result[$sequenceStr];
            } else {
                $id = $result[strtoupper($sequenceStr)];
            }

            return is_numeric($id) ? (int)$id : $id;
        }
    }
}
