<?php
/**
 * ██████╗ ███████╗ ██████╗ ██████╗ ██████╗ ███████╗
 * ██╔══██╗██╔════╝██╔════╝██╔═══██╗██╔══██╗██╔════╝
 * ██║  ██║█████╗  ██║     ██║   ██║██║  ██║█████╗  
 * ██║  ██║██╔══╝  ██║     ██║   ██║██║  ██║██╔══╝  
 * ██████╔╝███████╗╚██████╗╚██████╔╝██████╔╝███████╗
 * ╚═════╝ ╚══════╝ ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝
 *                                                    
 * DECODE Framework - Core System
 * 
 * @package  DECODE Framework
 * @author   Drunkoffjava
 * @version  1.0.0
 * @license  MIT License
 */
class Database {
    private static $instance = null;
    private $connection = null;
    private $config;
    
    private function __construct() {
        $this->config = require __DIR__ . '/../config/database.php';
        $this->connect();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect() {
        try {
            $dsn = "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}";
            
            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $this->config['options']
            );
            
        } catch (PDOException $e) {
            echo "Database connection failed:<br>";
            echo "Error: " . $e->getMessage() . "<br>";
            echo "DSN: $dsn<br>";
            die();
        }
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }
    
    public function select($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
        
        $this->query($sql, array_values($data));
        return $this->connection->lastInsertId();
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        $fields = implode('=?, ', array_keys($data)) . '=?';
        $sql = "UPDATE {$table} SET {$fields} WHERE {$where}";
        
        $params = array_merge(array_values($data), $whereParams);
        return $this->query($sql, $params)->rowCount();
    }
    
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }
    
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollBack();
    }
} 