<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:03
 */

use Xore\View;

class PageActions
{
    protected $url = '/';
    protected $title = 'Главная страница';

    private function getMenu(String $currentPage = null): String
    {
        $view = new View();
        $pages = [
            'diseases'    => ['href' => "/diseases/", 'label' => 'Что мы лечим', 'active' => false],
            'treatment' => ['href' => "/treatment/", 'label' => 'Методы лечения', 'active' => false],
            'staff'    => ['href' => "/staff/", 'label' => 'Врачи', 'active' => false],
            'about'   => ['href' => "/about/", 'label' => 'О нас', 'active' => false],
            'prices'   => ['href' => "/prices/", 'label' => 'Цены', 'active' => false],
            'contacts'   => ['href' => "/contacts/", 'label' => 'Контакты', 'active' => false],
        ];
        if($pages[$currentPage]) $pages[$currentPage]['active'] = true;
        $view->assign('pages', $pages);

        return $view->render('/site/components/menu.phtml');
    }

    public function getHTML(String $page)
    {
        $view = new View();

        switch ($page){
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
        }

        $view->assign('menu', $this->getMenu($page));
        $view->assign('header', $view->render("/site/components/header.phtml", false));
        $view->assign('footer', $view->render("/site/components/footer.phtml", false));
        //подключаем шаблоны
        try {
            return $view->render("/site/$page.phtml", false);
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }
}