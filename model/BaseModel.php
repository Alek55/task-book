<?php

    abstract class BaseModel {

        protected static $db = null;
        private $table_name;

        public function __construct($table_name) {
            $this->table_name = $table_name;
        }

        public static function setDB() {
            self::$db = DataBase::getDB();
        }

        protected static function select($params=false, $limit=false, $offset=false, $sort=false, $desc=false) {
            $class = get_called_class();
            return self::$db->select($class::$table, $params, $limit, $offset, $sort, $desc);
        }

        protected static function insert($data) {
            $class = get_called_class();
            return self::$db->insert($class::$table, $data);
        }

        protected static function update($data, $params=false) {
            $class = get_called_class();
            return self::$db->update($class::$table, $data, $params);
        }

    }
?>