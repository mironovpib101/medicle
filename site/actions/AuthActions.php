<?php

use Xore\Request;
use Xore\View;
use Xore\Response;

/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 15.01.19
 * Time: 22:18
 */

class AuthActions
{
    protected $view;
    protected $userModel;
    protected $response;
    protected $user;

    public function __construct()
    {
        //модели
        $this->userModel = new UsersModel();
        //шаблоны
        $this->view = new View();
        //ответ системы
        $this->response = new Response();
    }

    /**
     * авторизация
     */
    public function auth()
    {
        $user = $this->userModel->getRow([
            'login' => Request::post('login'),
            'password' => md5(Request::post('password')),
        ]);
        if(!empty($user)){
            $this->response->setCookie('token', $user['token'], null, '/');
        }
        $this->response->redirect(empty($user) ? '/' : '/admin/');
    }

    /**
     * Вывод окна логина
     * @throws \Xore\ExceptionApp
     */
    public function getForm()
    {
        if($this->isUser()){
            $this->response->redirect( '/admin/');
            return '';
        } else {
            $this->view->assign('title', 'Авторизация');
            return $this->view->render('/AdminPanel/forms/login.phtml');
        }
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