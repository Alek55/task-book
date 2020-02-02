<?php

class Users extends BaseModel {

    protected static $table = "users";

    public function __construct() {
        parent::__construct(self::$table);
    }

    public static function getUser($params=false, $limit=false, $offset=false) {
        return self::select($params, $limit, $offset);
    }

}

?>