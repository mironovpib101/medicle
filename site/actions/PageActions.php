<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:03
 */

use Xore\Request;
use Xore\View;

class PageActions
{
    protected $url = '/';
    protected $title = 'Главная страница';
    protected $pages = [
        'diseases'    => ['href' => "/diseases/", 'label' => 'Что мы лечим', 'active' => false],
        'treatment' => ['href' => "/treatment/", 'label' => 'Методы лечения', 'active' => false],
        'staff'    => ['href' => "/staff/", 'label' => 'Врачи', 'active' => false],
        'posts'    => ['href' => "/posts/", 'label' => 'Статьи', 'active' => false],
        'about'   => ['href' => "/about/", 'label' => 'О нас', 'active' => false],
        'prices'   => ['href' => "/prices/", 'label' => 'Цены', 'active' => false],
        'contacts'   => ['href' => "/contacts/", 'label' => 'Контакты', 'active' => false],
    ];

    private function getMenu(String $currentPage = null): String
    {
        $view = new View();
        if($this->pages[$currentPage]) $this->pages[$currentPage]['active'] = true;
        $view->assign('pages', $this->pages);
        return $view->render('/site/components/menu.phtml');
    }

    public function getPost(String $id): String
    {
        $view = new View();
        $view->assign('post', (new PostsModel())->getRow(['id' => $id]));
        $view->assign('menu', $this->getMenu('posts'));
        $view->assign('form', $view->render("/site/components/form.phtml", false));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));

        return $view->render("/site/post.phtml", false);
    }

    public function getHTML(String $page): String
    {
        $view = new View();
        switch ($page){
            case 'index':
                $model = new SliderModel();
                $table = $model->getTable();
                $view->assign('sliders', $model->getAll("SELECT * FROM ${table} WHERE status = '1'"));
                break;
            case 'staff':
                $view->assign('staff', (new StaffModel())->getAll());
                break;
            case 'prices':
                $view->assign('prices', (new PricesModel())->getAll());
                break;
            case 'contacts':
                $view->assign('contacts', (new PricesModel())->getAll());
                break;
            case 'treatment':
                $view->assign('treatment', (new PricesModel())->getAll());
                break;
            case 'about':
                $view->assign('about', (new PricesModel())->getAll());
                break;
            case 'diseases':
                $view->assign('diseases', (new PricesModel())->getAll());
                break;
            case 'posts':
                $model = new PostsModel();
                $view->assign('posts', $model->getItemsByPage(Request::get('page', 1), 5, true));
                $view->assign('countPosts',$model->count(['status' => 1]));
                $view->assign('currentPage', intval(Request::get('page', 1)));
                break;
        }

        if($page === 'index'){
            $view->assign('title',  'Главная страница');
        }else{
            $view->assign('title',  isset($this->pages[$page]) ? $this->pages[$page]['label'] : 404);
        }
        $view->assign('menu', $this->getMenu($page));
        $view->assign('form', $view->render("/site/components/form.phtml", false));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));
        //подключаем шаблоны
        try {
            return $view->render("/site/$page.phtml", false);
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }
    public function notFound()
    {
        $view = new View();
        $view->assign('menu', $this->getMenu('posts'));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));

        return $view->render("/site/notFound.phtml", false);
    }
}