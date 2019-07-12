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
    protected $sliderModel;
    protected $emailsModel;
    protected $anyModel;
    protected $pricesModel;
    protected $licensesModel;
    protected $painModel;
    protected $reviewModel;
    protected $methodsModel;
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
        $this->sliderModel = new SliderModel();
        $this->staffModel = new StaffModel();
        $this->emailsModel = new EmailsModel();
        $this->anyModel = new AnyModel();
        $this->pricesModel = new PricesModel();
        $this->painModel = new PainModel();
        $this->methodsModel = new MethodsModel();
        $this->reviewModel = new ReviewModel();
        //ответ системы
        $this->response = new Response();
        //шаблоны
        $this->view = new View();

        if (!$this->isUser())
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
        if (empty($table) || empty($id)) return false;
        return $this->anyModel->setTable($table)->delete(['id' => $id]);
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
        if (empty($table) || empty($id)) return false;
        return $this->anyModel->setTable($table)->update($data, ['id' => $id]);
    }

    /**
     * Добавляет элемент в базы по таблице
     * @param String $table
     * @param array $data
     * @return array
     */
    public function insertElement(String $table, array $data): array
    {
        if (!$this->isUser()) return ['access' => 'Недостаточно прав'];
        if (empty($table)) return ['table' => 'Таблица не указана'];

        switch ($table) {
            case 'posts':
                $data['user_id'] = $this->user['id'];
                return $this->postsModel->setItem($data);
            case 'licenses':
                return $this->licensesModel->setItem($data);
            case 'staff':
                return $this->staffModel->setItem($data);
            case 'slides':
                return $this->sliderModel->setItem($data);
            case 'emails':
                return $this->emailsModel->setItem($data);
            case 'prices':
                return $this->pricesModel->setItem($data);
            case 'pain':
                return $this->painModel->setItem($data);
            case 'methods':
                return $this->methodsModel->setItem($data);
            case 'reviews':
                return $this->reviewModel->setItem($data);
            default:
                return ['table' => 'Таблица не найдена'];
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
        $data = [];
        if (!empty($id)) {
            $data = $this->anyModel->setTable($table)->getRow(['id' => $id]);
        }
        $this->view->assign('data', $data);
        return $this->view->render("/AdminPanel/forms/$table.phtml") ?? '';
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
                case 'posts':
                    $content = $this->getPosts();
                    break;
                case 'licenses':
                    $content = $this->getLicenses();
                    break;
                case 'staff':
                    $content = $this->getStaff();
                    break;
                case 'slider':
                    $content = $this->getSlides();
                    break;
                case 'emails':
                    $content = $this->getEmails();
                    break;
                case 'prices':
                    $content = $this->getPrices();
                    break;
                case 'pain':
                    $content = $this->getPain();
                    break;
                case 'methods':
                    $content = $this->getMethods();
                    break;
                case 'reviews':
                    $content = $this->getReviews();
                    break;
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
            'slider' => ['href' => "/admin/slider/", 'label' => 'Слайдер', 'active' => false],
            'emails' => ['href' => "/admin/emails/", 'label' => 'E-mails', 'active' => false],
            'prices' => ['href' => "/admin/prices/", 'label' => 'Прайс', 'active' => false],
            'pain' => ['href' => "/admin/pain/", 'label' => 'Боль', 'active' => false],
            'methods' => ['href' => "/admin/methods/", 'label' => 'Методы лечения', 'active' => false],
            'reviews' => ['href' => "/admin/reviews/", 'label' => 'Отзывы', 'active' => false],
        ];

        if ($currentPage && isset($pages[$currentPage]) && $pages[$currentPage])
            $pages[$currentPage]['active'] = true;
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
        $this->view->assign('posts', $this->postsModel->getAll());
        $this->view->assign('currentPage', intval(Request::get('page', 1)));
        $this->view->assign('countPosts', $this->postsModel->count(
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
     * Получим слайды
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getSlides(): string
    {
        $this->view->assign('slides', $this->sliderModel->getAll());
        return $this->view->render('/AdminPanel/slider.phtml');
    }

    /**
     * Получим отзывы
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getReviews(): string
    {
        $this->view->assign('reviews', $this->reviewModel->getAll());
        return $this->view->render('/AdminPanel/reviews.phtml');
    }

    /**
     * Получим контактные данные
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getEmails(): string
    {
        $this->view->assign('emails', $this->emailsModel->getAll());
        return $this->view->render('/AdminPanel/emails.phtml');
    }

    /**
     * Получим прайс
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getPrices(): string
    {
        $this->view->assign('prices', $this->pricesModel->getAll());
        return $this->view->render('/AdminPanel/prices.phtml');
    }

    /**
     * Получим боль
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getPain(): string
    {
        $this->view->assign('pains', $this->painModel->getAll());
        return $this->view->render('/AdminPanel/pain.phtml');
    }

    /**
     * Получим методы лечения
     * @return string
     * @throws \Xore\ExceptionApp
     */
    private function getMethods(): string
    {
        $this->view->assign('methods', $this->methodsModel->getAll());
        return $this->view->render('/AdminPanel/methods.phtml');
    }

    /**
     * получить пользователя по токену
     * @return array|bool
     */
    public function isUser()
    {
        if (!empty($user)) {
            return !empty($this->user);
        } else {
            $this->user = $this->userModel->getRow([
                'token' => Request::cookie('token')
            ]);
            return !empty($this->user);
        }
    }
}