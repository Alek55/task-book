<?php

    class Request {

        private $data;

        public function __construct() {
            $this->data = $this->xss($_REQUEST);
        }

        public function __get($name) {
            if(isset($this->data[$name])) return $this->data[$name];
        }

        private function xss($data) {
            if(is_array($data)) {
                $clear_data = [];
                foreach($data as $key => $value) {
                    $clear_data[$key] = $this->xss($value);
                }
                return $clear_data;
            }
            return trim(htmlspecialchars($data));
        }

    }

?>
