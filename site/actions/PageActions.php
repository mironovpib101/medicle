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

    public function getHTML()
    {
        //подключаем шаблоны
        $view = new View();
        try {
            return $view->render('/site/index.phtml', false);
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }
}