<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 12.01.19
 * Time: 19:53
 */

use Xore\View;

class PostsActions
{
    protected $url = '/posts/';
    protected $title = 'Статьи';
    protected $model;

    public function __construct()
    {
        $this->model = new PostsModel();
    }

    public function getHTML()
    {
        //подключаем шаблоны
        $view = new View();
        try {
            //добавляем шапку
            $view->assign('active', $this->url);
            $view->assign('header', $view->render('/site/header.phtml', false));
            $view->assign('title', $this->title);

            return $view->render('/site/index.phtml', true);
        } catch (\Xore\ExceptionApp $e) {
            return $e->getMessage();
        }
    }

    /**
     * получаем посты
     * @param Int $page
     * @param Int $count
     * @param $onlyPublic
     * @return array
     */
    public function getPosts(Int $page = 1, Int $count = 5, $onlyPublic = true)
    {
        return $this->model->getItemsByPage($page, $count, $onlyPublic);
    }
}