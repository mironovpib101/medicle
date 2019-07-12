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
    protected $pages = [
        'about'   => ['href' => "/about/", 'label' => 'О центре', 'active' => false],
        'diseases'    => ['href' => "/diseases/", 'label' => 'Что мы лечим', 'active' => false],
        'treatment' => [
            'href' => '/treatment/',
            'label' => 'Методы лечения',
            'active' => false,
            'child' => []
        ],
        'staff'    => ['href' => "/staff/", 'label' => 'Врачи', 'active' => false],
        'posts'    => ['href' => "/posts/", 'label' => 'Пациентам', 'active' => false],
        'prices'   => ['href' => "/prices/", 'label' => 'Цены', 'active' => false],
        'contacts'   => ['href' => "/contacts/", 'label' => 'Контакты', 'active' => false],
    ];
    protected $title = 'Главная страница';

    /**
     * @param String|null $currentPage
     * @return String
     * @throws \Xore\ExceptionApp
     */
    private function getMenu(String $currentPage = null): String
    {
        $view = new View();

        $pages = (new MethodsModel)->getAll();
        foreach ($pages as &$page){
            $page = [
                'label' => $page['title'],
                'href' => "/treatment/$page[id]/",
            ];
        }


        $this->pages['treatment']['child'] = $pages;

        if($currentPage && $this->pages[$currentPage])
            $this->pages[$currentPage]['active'] = true;
        $view->assign('pages', $this->pages);

        return $view->render('/site/components/menu.phtml');
    }

    /**
     * @param String $page
     * @return String
     * @throws \Xore\ExceptionApp
     */
    public function getHTML(String $page): String
    {
        $view = new View();
        switch ($page){
            case 'index':
                $model = new SliderModel();
                $table = $model->getTable();
                $view->assign('sliders', $model->getAll("SELECT * FROM ${table} WHERE status = '1'"));
                $view->assign('methods', (new MethodsModel())->getAll());
                $view->assign('pains', (new PainModel())->getAll());
                break;
            case 'staff':
                $view->assign('staff', (new StaffModel())->getAll());
                break;
            case 'prices':
                $view->assign('prices', (new PricesModel())->getAll());
                break;
            case 'treatment':
                $view->assign('methods', (new MethodsModel())->getAll());
                break;
            case 'diseases':
                $view->assign('pains', (new PainModel())->getAll());
                break;
            case 'about':
                $model = new SliderModel();
                $table = $model->getTable();
                $view->assign('sliders', $model->getAll("SELECT * FROM ${table} WHERE status = '1'"));
                $items = (new LicensesModel())->getAll();
                foreach ($items as &$item){
                    $patch = explode('/', $item['scan']);
                    $patch[count($patch) - 1] = '250.'.$patch[count($patch) - 1];
                    $item['preview'] = implode('/', $patch);
                }
                $view->assign('licenses',$items);
                break;
            case 'posts':
                $model = new PostsModel();
                $view->assign('posts', $model->getPublic());
                $view->assign('reviews', (new ReviewModel)->getPublic());
                $view->assign('reviews', $view->render("/site/components/reviews.phtml", false));
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

    /**
     * @param String $id
     * @return string
     * @throws \Xore\ExceptionApp
     */
    public function getPain(String $id): string
    {
        $pain = (new PainModel())->getRow(['id'=>$id]);
        if(!$pain) return $this->notFound();

        $view = new View();
        $view->assign('menu', $this->getMenu('diseases'));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));
        $view->assign('pain', $pain);

        return $view->render("/site/pain.phtml", false);
    }

    /**
     * @param String $id
     * @return string
     * @throws \Xore\ExceptionApp
     */
    public function getMethod(String $id): string
    {
        $pain = (new MethodsModel())->getRow(['id'=>$id]);
        if(!$pain) return $this->notFound();

        $view = new View();
        $view->assign('menu', $this->getMenu('treatment'));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));
        $view->assign('pain', $pain);

        return $view->render("/site/method.phtml", false);
    }

    /**
     * @return string
     * @throws \Xore\ExceptionApp
     */
    public function notFound()
    {
        $view = new View();
        $view->assign('menu', $this->getMenu());
        $view->assign('form', $view->render("/site/components/form.phtml", false));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));


        return $view->render("/site/notFound.phtml", false);
    }
}