<?php

    class View {

        private $dir_tmpl;

        public function __construct($dir_tmpl){
            $this->dir_tmpl = $dir_tmpl;
        }

        public function render($params, $layout, $return=false) {
            $template = $return ? $this->dir_tmpl.'/'.$layout.'.php' : 'layout/'.$layout.'.php';
            extract($params);
            ob_start();
            include($template);
            if($return) return ob_get_clean();
            else echo ob_get_clean();
        }

    }
?>
