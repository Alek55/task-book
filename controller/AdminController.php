<?php
class AdminController extends BaseController {

    public function __construct() {
        parent::__construct(new View('admin'));
        $this->layout = 'admin';
        if(!$this->is_auth_admin()) $this->redirect('/#auth');
    }

    private function is_auth_admin() {
        if(!isset($_SESSION['auth_admin'])) return false;
        $admin = Users::getUser(['login' => 'admin'])[0];
        return ((mb_strtolower($_SESSION['auth_admin']['login']) === mb_strtolower($admin['login'])) && ($_SESSION['auth_admin']['password'] === $admin['password']));
    }

    public function indexAction() {
        $pages = $this->getPages();

        $sort = $this->getSort();
        $tasks = $pages['count_all_task'] >= 1 ? Task::getAllTask([], Config::COUNT_TASK_ON_PAGE, $pages['offset'], $sort['sort'], $sort['desc']) : null;
        return $this->render('index', ['tasks' => $tasks, 'count_pages' => $pages['count_pages'], 'active_page' => $pages['active_page'], 'sort' => $sort['sort'], 'sort_active' => $sort['sort_active']]);
    }

    public function logoutAction() {
        if(isset($_SESSION['auth_admin'])) unset($_SESSION['auth_admin']);
        return $this->redirect('/');
    }

    public function checktaskAction() {
        $id = $this->request->id;
        $id = (int)$id;
        if(!Task::updateTask(['status' => 1], ['id' => $id])) echo json_encode('error');
        else echo json_encode('success');
    }

    public function savetextAction() {
        $id = $this->request->id;
        $id = (int)$id;
        $text = $this->request->text;
        if(!$text) echo json_encode('error');
        else {
            if(!Task::updateTask(['text' => $text, 'edit' => 1], ['id' => $id])) echo json_encode('error');
            else echo json_encode('success');
        }
    }

}
?>