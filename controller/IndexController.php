<?php
    class IndexController extends BaseController {

        public function __construct() {
            parent::__construct(new View('index'));
        }

        public function indexAction() {
            $pages = $this->getPages();
            $sort = $this->getSort();
            $tasks = $pages['count_all_task'] >= 1 ? Task::getAllTask([], Config::COUNT_TASK_ON_PAGE, $pages['offset'], $sort['sort'], $sort['desc']) : null;
            return $this->render('index', ['tasks' => $tasks, 'count_pages' => $pages['count_pages'], 'active_page' => $pages['active_page'], 'sort' => $sort['sort'], 'sort_active' => $sort['sort_active']]);
        }

        public function authAction() {
            if(isset($_SESSION['auth_admin'])) $this->redirect('admin/index');

            $login = $this->request->login;
            $password = sha1($this->request->password.Config::SALT);

            $admin = Users::getUser(['login' => 'admin'])[0];
            if((mb_strtolower($login) !== mb_strtolower($admin['login'])) || ($password !== $admin['password'])) {
                $_SESSION['error_auth'] = 'Неверные логин или пароль';
                return $this->redirect('index/index#auth');
            }
            $_SESSION["auth_admin"]["login"] = $login;
            $_SESSION["auth_admin"]["password"] = $password;
            return $this->redirect('admin/index');
        }

        public function addtaskAction() {
            if(!isset($_POST)) return $this->action404();
            $name = $this->request->name;
            $email = $this->request->email;
            $text = $this->request->text;
            $date = time();
            $status = null;
            if(!$name || !$email || !$text) {
                $_SESSION['add_error'] = 'Заполните все поля';
                return $this->redirect('/index#add');
            }
            if(!Task::addTask(['name' => $name, 'email' => $email, 'text' => $text, 'date' => $date, "status" => $status])) {
                $_SESSION['add_error'] = 'Произошла ошибка при добавлении';
                return $this->redirect('/index#add');
            }
            $_SESSION['add_success'] = 'Задача успешно создана';
            return $this->redirect('/index');
        }

        public function verifyadminAction() {
            //$login = $this->request->;
        }

    }
?>