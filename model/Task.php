<?php

    class Task extends BaseModel {

        public static $table = "task";

        public function __construct() {
            parent::__construct(self::$table);
        }

        public static function getAllTask($params=false, $limit=false, $offset=false, $sort=false, $desc=false) {
            return self::select($params, $limit, $offset, $sort, $desc);
        }

        public static function addTask($data) {
            return self::insert($data);
        }

        public static function updateTask($data, $params=false) {
            return self::update($data, $params);
        }

    }

?>