<?php

    class BaseController {

        protected $view;
        protected $request;
        protected $layout = 'main';

        public function __construct($view) {
            if(!session_id()) session_start();
            $this->view = $view;
            $this->request = new Request();
        }

        public function action404() {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            return $this->render('error404');
        }

        final protected function render($file, $params=[]) {
            $view_part = $this->view->render($params, $file, true);
            $params['content'] = $view_part;
            $this->view->render($params, $this->layout);
        }

        final protected function redirect($url) {
            header("Location: $url");
            exit();
        }

        protected function getPages() {
            $count_all_task = count(Task::getAllTask());
            $count_pages = ceil($count_all_task / Config::COUNT_TASK_ON_PAGE);
            $page = $this->request->page ? $this->request->page : 1;
            if(($count_all_task >= 1) && ($page > $count_pages || $page < 1)) {
                $this->action404();
                exit;
            }
            $offset = ($page - 1) * 3;
            return ['count_pages' => $count_pages, 'active_page' => $page, 'count_all_task' => $count_all_task, 'offset' => $offset];
        }

        protected function getSort() {
            $sort_active = null;
            if(($this->request->sort === 'name_up' || $this->request->sort === 'name_down' || $this->request->sort === 'email_up' || $this->request->sort === 'email_down' || $this->request->sort === 'status_up' || $this->request->sort === 'status_down')) {
                $sort_active = $this->request->sort;
                $sort_param = explode('_', $this->request->sort);
                $sort = $sort_param[0];
                $desc = $sort_param[1] == 'up' ? false : true;
            }
            else {
                $sort = 'name';
                $sort_active = 'name_up';
                $desc = false;
            }
            return ['sort' => $sort, 'desc' => $desc, 'sort_active' => $sort_active];
        }

    }

?>
