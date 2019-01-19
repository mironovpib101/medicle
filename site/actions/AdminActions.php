<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:11
 */

use Xore\View;
use Xore\Request;
use Xore\Response;
use Xore\ExceptionApp;

class AdminActions
{
    protected $url = '/';
    protected $title = 'Панель управления';
    protected $user;
    protected $userModel;
    protected $postsModel;
    protected $staffModel;
    protected $licensesModel;
    protected $response;
    protected $view;

    /**
     * AdminActions constructor.
     * @throws ExceptionApp
     */
    public function __construct()
    {
        //модели
        $this->userModel = new UsersModel();
        $this->postsModel = new PostsModel();
        $this->licensesModel = new LicensesModel();
        $this->staffModel = new StaffModel();
        //ответ системы
        $this->response = new Response();
        //шаблоны
        $this->view = new View();

        if(!$this->isUser())
            throw new ExceptionApp('You don\'t have access', 403);
    }

    /**
     * Удаляет элемент из базы по таблице и id
     * @param String $table
     * @param int $id
     * @return bool
     */
    public function removeElement(String $table, int $id): bool
    {
        if(empty($table) || empty($id)) return false;

        switch ($table){
            case 'posts': return $this->postsModel->delete(['id'=>$id]);
            case 'licenses': return $this->licensesModel->delete(['id'=>$id]);
            case 'staff': return $this->staffModel->delete(['id'=>$id]);
            default: return false;
        }
    }

    /**
     * обноваляет элемент базы по таблице и id
     * @param String $table
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateElement(String $table, int $id, array $data): bool
    {
        if(empty($table) || empty($id)) return false;

        switch ($table){
            case 'posts': return $this->postsModel->update($data, ['id'=>$id]);
            case 'licenses': return $this->licensesModel->update($data, ['id'=>$id]);
            case 'staff': return $this->staffModel->update($data, ['id'=>$id]);
            default: return false;
        }
    }

    /**
     * Добавляет элемент в базы по таблице
     * @param String $table
     * @param array $data
     * @return array
     */
    public function insertElement(String $table, array $data): array
    {
        if(!$this->isUser()) return ['access' => 'Недостаточно прав'];
        if(empty($table)) return ['table' => 'Таблица не указана'];

        switch ($table){
            case 'posts':
                $data['user_id'] = $this->user['id'];
                return $this->postsModel->setItem($data);
            case 'licenses':
                return $this->licensesModel->setItem($data);
            case 'staff':
                return $this->staffModel->setItem($data);
            default: return ['table' => 'Таблица не найдена'];
        }
    }

    /**
     * Получим заполненую форму для редактирования элмента
     * @param String $table
     * @param int|null $id
     * @return String
     * @throws \Xore\ExceptionApp
     */
    public function getForm(String $table, int $id = null): String
    {
        $template = '';
        switch ($table){
            case 'posts':
                if(!empty($id)) $this->view->assign('data', $this->postsModel->getRow(['id'=>$id]));
                $template = $this->view->render('/AdminPanel/forms/post.phtml');
                break;
            case 'license':
                if(!empty($id)) $this->view->assign('data', $this->licensesModel->getRow(['id'=>$id]));
                $template = $this->view->render('/AdminPanel/forms/license.phtml');
                break;
            case 'staff':
                if(!empty($id)) $this->view->assign('data', $this->staffModel->getRow(['id'=>$id]));
                $template = $this->view->render('/AdminPanel/forms/staff.phtml');
                break;
        }
        return $template;
    }

    /**
     * показать админ панель
     * @param String $page
     * @return String
     */
    public function getHTML(String $page = 'main'): String
    {
        try {
            $content = 'Добро пожаловать!';
            switch ($page) {
                case 'posts': $content = $this->getPosts();break;
                case 'licenses': $content = $this->getLicenses();break;
                case 'staff': $content = $this->getStaff();break;
            }
            $this->view->assign('title', $this->title);
            $this->view->assign('menu', $this->getMenu($page));
            $this->view->assign('content', $content);
            return $this->view->render('/AdminPanel/layout.phtml');
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param String|null $currentPage
     * @return String
     * @throws ExceptionApp
     */
    private function getMenu(String $currentPage = null): String
    {
        $pages = [
            'posts' => ['href' => "/admin/posts/", 'label' => 'Статьи', 'active' => false],
            'licenses' => ['href' => "/admin/licenses/", 'label' => 'Лицензии', 'active' => false],
            'staff' => ['href' => "/admin/staff/", 'label' => 'Сотрудники', 'active' => false],
        ];
        if($pages[$currentPage]) $pages[$currentPage]['active'] = true;
        $this->view->assign('pages', $pages);
        return $this->view->render('/AdminPanel/menu.phtml');
    }

    /**
     * Получим страницу дня настройки постов
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getPosts(): string
    {
        $this->view->assign('posts', $this->postsModel->getItemsByPage(
            Request::get('page', 1) - 1,
            Request::get('count', 5),
            !$this->isUser()
        ));
        $this->view->assign('currentPage', intval(Request::get('page', 1)));
        $this->view->assign('countPosts',$this->postsModel->count(
            $this->isUser() ? null : ['status' => 1]
        ));
        return $this->view->render('/AdminPanel/posts.phtml');
    }

    /**
     * Получим страницу для настройки лицензий
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getLicenses(): string
    {
        $this->view->assign('licenses', $this->licensesModel->getAll());
        return $this->view->render('/AdminPanel/licenses.phtml');
    }

    /**
     * Получим страницу для настройки сотрудников
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getStaff(): string
    {
        $this->view->assign('staff', $this->staffModel->getAll());
        return $this->view->render('/AdminPanel/staff.phtml');
    }

    /**
     * получить пользователя по токену
     * @return array|bool
     */
    public function isUser()
    {
        if(!empty($user)){
            return !empty($this->user);
        }else{
            $this->user = $this->userModel->getRow([
                'token' => Request::cookie('token')
            ]);
            return !empty($this->user);
        }
    }
}