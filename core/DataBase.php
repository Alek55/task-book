<?php

    class DataBase {

        private $mysql;
        private static $db = null;
        private $secret;

        public static function getDB() {
            if(self::$db === null) self::$db = new DataBase(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
            return self::$db;
        }

        protected function __construct($host, $user, $password, $dbname) {
            $this->secret = '?';
            try {
                $this->mysql = new PDO("mysql:dbname=$dbname;host=$host", $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }

        public function select($table_name, $params=false, $limit=false, $offset=false, $sort=false, $desc=false) {
            $sql = "SELECT * FROM `$table_name`";
            $param_arr = [];
            if(is_array($params) && count($params) > 0) {
                $sql .= " WHERE ";
                foreach($params as $key => $value) {
                    $param_arr[] = $value;
                    $sql .= "$key=$this->secret AND ";
                }
                $sql = substr($sql, 0, -5);
            }
            if($sort) {
                $sql .= " ORDER BY `$sort`";
                if($desc) $sql.= ' DESC';
                else $sql .= ' ASC';
            }
            if($limit) $sql .= " LIMIT $limit OFFSET $offset";
            $q = $this->mysql->prepare($sql);
            $q->execute($param_arr);
            $res = $q->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        public function insert($table_name, $data) {
            if(count($data) == 0) return false;
            $sql = "INSERT INTO `$table_name`";
            $fields = "(";
            $values = "(";
            $param_arr = [];
            foreach($data as $key => $value) {
                $fields .= "`$key`,";
                $values .= "$this->secret,";
                $param_arr[] = $value;
            }
            $fields = substr($fields, 0, -1);
            $values = substr($values, 0, -1);
            $fields .= ")";
            $values .= ")";
            $sql .= " $fields VALUES $values";
            $q = $this->mysql->prepare($sql);
            $q->execute($param_arr);
            return true;
        }

        public function update($table_name, $data, $params=false) {
            if(count($data) == 0) return false;
            $sql = "UPDATE `$table_name` SET ";
            $param_arr = [];
            foreach($data as $key => $value) {
                $sql .= "`$key`=".$this->secret.",";
                $param_arr[] = $value;
            }
            $sql = substr($sql, 0, -1);
            if($params) {
                $sql .= " WHERE ";
                foreach($params as $k => $v) {
                    $param_arr[] = $v;
                    $sql .= "$k=".$this->secret." AND ";
                }
                $sql = substr($sql, 0, -5);
            }
            $q = $this->mysql->prepare($sql);
            $q->execute($param_arr);
            return true;
        }

    }

?>
