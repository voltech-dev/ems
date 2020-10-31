<?php

namespace App\Models;

use PDO;
use PDOException;

class Dtssp
{

    public static function data_output($columns, $data, $Join = false)
    {
        $out = array();
        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                if (isset($column['formatter'])) {
                    $row[$column['dt']] = ($Join) ? (isset($columns[$j]['as'])) ? $column['formatter']($data[$i][$column['as']], $data[$i]) : $column['formatter']($data[$i][$column['field']], $data[$i]) : $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = ($Join) ?  (isset($columns[$j]['as'])) ?  $data[$i][$columns[$j]['as']] : $data[$i][$columns[$j]['field']] : $data[$i][$columns[$j]['db']];
                }
            }

            $out[] = $row;
        }

        return $out;
    }

    public static function db()
    {
        $host = env('DB_HOST', '127.0.0.1');
        $database = env('DB_DATABASE', '');
        $username = env('DB_USERNAME', '');
        $password = env('DB_PASSWORD', '');
        try {
            $db = @new PDO(
                "mysql:host={$host};dbname={$database}",
                $username,
                $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            self::fatal(
                "An error occurred while connecting to the database. " .
                    "The error reported by the server was: " . $e->getMessage()
            );
        }

        return $db;
    }

    public static function limit($request, $columns)
    {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }

    public static function order($request, $columns)
    {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = $column['db'] . ' ' . $dir;
                }
            }

            if (count($orderBy)) {
                $order = 'ORDER BY ' . implode(', ', $orderBy);
            }
        }

        return $order;
    }

    public static function filter($request, $columns, &$bindings)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    //$globalSearch[] = $column['db']." LIKE ".$binding;
                    $globalSearch[] = $column['db'] . " LIKE '%" . $str . "%'";
                }
            }
        }

        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                $str = $requestColumn['search']['value'];

                if (
                    $requestColumn['searchable'] == 'true' &&
                    $str != ''
                ) {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    //$columnSearch[] = $column['db']." LIKE ".$binding;
                    $columnSearch[] = $column['db'] . " LIKE '%" . $str . "%'";
                }
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }
        //print_r($where);
        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }
        return $where;
    }

    public static function simple($request,  $table, $primaryKey, $columns, $jointables = null, $userwhere = null)
    {

        $bindings = array();
        $db = self::db();

        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);
        $userwhere = self::_flatten($userwhere);

        if ($userwhere) {
            $where = $where ?
                $where . ' AND ' . $userwhere :
                'WHERE ' . $userwhere;

            //    $whereAllSql = 'WHERE '.$userwhere;
        }

              

        if ($jointables) {

        $sql = "SELECT " . implode(", ", self::pluck($columns, 'db', $jointables)) . "
		FROM $table
		" . self::pluckTable($jointables) . "
		$where
		$order
		$limit";

            $resFilterLength = self::sql_exec(
                $db,
                $bindings,
                "SELECT COUNT($primaryKey)
		 FROM $table
		 " . self::pluckTable($jointables) . "
		 $where"
            );
            $recordsFiltered = $resFilterLength[0][0];


            // Total data set length
            $resTotalLength = self::sql_exec(
                $db,
                "SELECT COUNT($primaryKey)
		 FROM $table
         " . self::pluckTable($jointables) . "
          $where"
            );
            $recordsTotal = $resTotalLength[0][0];
        } else {
            $sql = "SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table
			$where
			$order
			$limit";

            $resFilterLength = self::sql_exec(
                $db,
                $bindings,
                "SELECT COUNT($primaryKey)
			 FROM $table			
			 $where"
            );
            $recordsFiltered = $resFilterLength[0][0];
            // Total data set length
            $resTotalLength = self::sql_exec(
                $db,
                "SELECT COUNT($primaryKey)
			 FROM $table"
            );
            $recordsTotal = $resTotalLength[0][0];
        }

        $data = self::sql_exec($db, $bindings, $sql);

        return array(
            "draw" => isset($request['draw']) ?
                intval($request['draw']) :
                0,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => self::data_output($columns, $data, $jointables),
        );
    }



    public static function sql_exec($db, $bindings, $sql = null)
    {
        // Argument shifting
        if ($sql === null) {
            $sql = $bindings;
        }

        $stmt = $db->prepare($sql);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            self::fatal("An SQL error occurred: " . $e->getMessage());
        }

        $data = $stmt->fetchAll(PDO::FETCH_BOTH);
        return $data;
    }

    public static function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg,
        ));

        exit(0);
    }

    public static function bind(&$a, $val, $type)
    {
        $key = ':binding_' . count($a);

        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type,
        );

        return $key;
    }

    public static function pluck($a, $prop, $isJoin = null)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
           $distinct =  (isset($a[$i]['distinct'])) ? 'DISTINCT ' : '';
            //   $out[] = $a[$i][$prop];
            $out[] =  (isset($a[$i]['as'])) ? $distinct.$a[$i][$prop] . ' AS ' . $a[$i]['as'] : $distinct.$a[$i][$prop];
        }     
        return $out;
    }

    public static function pluckTable($a)
    {
        $out = '';

        //    $join = 'JOIN '.$joins.' ON a.id=b.emp_id';

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $join = $a[$i]['join'];
            $table = $a[$i]['table'];
            $on = $a[$i]['on'];
            $out .= ' ' . $join . ' ' . $table . ' ON ' . $on;
        }

        return $out;
    }

    public static function _flatten($a, $join = ' AND ')
    {
        if (!$a) {
            return '';
        } else if ($a && is_array($a)) {
            return implode($join, $a);
        }
        return $a;
    }
}
