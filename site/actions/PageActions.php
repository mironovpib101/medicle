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
        }

        //подключаем шаблоны
        try {
            return $view->render("/site/$page.phtml", false);
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }
}