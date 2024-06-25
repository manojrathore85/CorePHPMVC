<?php
namespace App\Services;
use PDO;

use \App\Services\DB;  
class DBFunctions {
    public $pdo;
    public function __construct() {    
        $this->pdo = DB::connect();   
    }

    public function insert($table, $data) {
        // Example: $data = ['column1' => 'value1', 'column2' => 'value2', ...]
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $conditions) {
        // Example: $data = ['column1' => 'value1', 'column2' => 'value2', ...]
        // Example: $conditions = ['id' => 1, 'status' => 'active']
        $setClause = '';
        foreach ($data as $column => $value) {
            $setClause .= "$column = ?, ";
        }
        $setClause = rtrim($setClause, ', ');

        $whereClause = '';
        $whereValues = [];
        foreach ($conditions as $column => $value) {
            $whereClause .= "$column = ? AND ";
            $whereValues[] = $value;
        }
        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), $whereValues));

        return $stmt->rowCount();
    }

    public function select($table, $columns = '*', $conditions = [], $orderBy = '', $limit = '') {
        // Example: $columns = ['column1', 'column2', ...] or '*'
        // Example: $conditions = ['id' => 1, 'status' => 'active']
        // Example: $orderBy = 'column ASC'
        // Example: $limit = '10'

        $whereClause = '';
        $whereValues = [];
        if(!empty($conditions)){
            foreach ($conditions as $column => $value) {
                $whereClause .= "$column = ? AND ";
                $whereValues[] = $value;
            }
        }
        $whereClause = empty($whereClause) ? '' : 'WHERE ' . rtrim($whereClause, ' AND ');

        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
        $sql = "SELECT $columns FROM $table $whereClause $orderBy $limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereValues);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSingle($table, $columns = '*', $conditions = [], $orderBy = '', $limit = '') {
        // Example: $columns = ['column1', 'column2', ...] or '*'
        // Example: $conditions = ['id' => 1, 'status' => 'active']
        // Example: $orderBy = 'column ASC'
        // Example: $limit = '10'

        $whereClause = '';
        $whereValues = [];
        if(!empty($conditions)){
            foreach ($conditions as $column => $value) {
                $whereClause .= "$column = ? AND ";
                $whereValues[] = $value;
            }
        }
        $whereClause = empty($whereClause) ? '' : 'WHERE ' . rtrim($whereClause, ' AND ');

        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
        $sql = "SELECT $columns FROM $table $whereClause $orderBy $limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereValues);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($table, $conditions) {
        // Example: $conditions = ['id' => 1, 'status' => 'active']
        $whereClause = '';
        $whereValues = [];
        foreach ($conditions as $column => $value) {
            $whereClause .= "$column = ? AND ";
            $whereValues[] = $value;
        }
        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "DELETE FROM $table WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($whereValues);

        return $stmt->rowCount();
    }

    public function selectQuery($qry){
        $stmt = $this->pdo->prepare($qry);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    }
}
?>
