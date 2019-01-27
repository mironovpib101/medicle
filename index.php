<?php
if(!file_exists('./env.php')) {
    echo 'env not found';
    exit;
}
//подключаем env
require_once 'env.php';
//подключим ядро
require_once 'xore/App.php';
//подлючим модели
require_once 'site/models/AnyModel.php';
require_once 'site/models/PostsModel.php';
require_once 'site/models/UsersModel.php';
require_once 'site/models/LicensesModel.php';
require_once 'site/models/StaffModel.php';
require_once 'site/models/SliderModel.php';
require_once 'site/models/PricesModel.php';
require_once 'site/models/EmailsModel.php';
require_once 'site/models/PainModel.php';
require_once 'site/models/MethodsModel.php';
//подключим экшены
require_once 'site/actions/PageActions.php';
require_once 'site/actions/AdminActions.php';
require_once 'site/actions/AuthActions.php';

use Xore\App;
use Xore\Request;
use Xore\Messages\Email;
use Xore\Services;

//создаём объект ядра
$app = new App();

//подключаем mysql
$app::setMySQL(MYSQL_HOST, MYSQL_DB, MYSQL_PORT, MYSQL_USER, MYSQL_PASS);

//подключаем smtp
Email::setConfig(SMTP_EMAIL, SMTP_PORT, SMTP_HOST,SMTP_PASS);


//создание эндпойнтов
//главная страница
$app->get('/', function () {
    //создаём обработчик для главной старницы
    return (new PageActions())->getHTML('index');
});

//Врачи
$app->get('/{page}/', function ($page) use ($app) {
    $pages = ['staff', 'prices', 'contacts', 'treatment', 'diseases', 'about', 'posts', 'admin', 'login'];
    if(in_array($page, $pages)){
        switch ($page){
            default: return (new PageActions())->getHTML($page);
            case 'admin': return (new AdminActions())->getHTML('Добро пожаловать!');
            case 'login': return (new AuthActions())->getForm();

        }
    }else{
        $app->getResponse()->setCode(404);
        return (new PageActions())->notFound();
    }
});

$app->post('/send_request/', function () use ($app) {
    $phone = Request::post('phone');
    $fullanme = Request::post('fullname');
    $result = false;
    $app->getResponse()->setContentType('application/json');

    $emailList = [];
    foreach ((new EmailsModel())->getAll() as $item) {
        $emailList[] = $item['email'];
    }

    if(count($emailList) === 0 || empty($fullanme) || empty($phone)){
        $result = false;
    }else{
        $result = Email::send(
            $emailList,
            'Новая заявка',
            "Поступила новая заявка от $fullanme ($phone)"
        );
    }

    return json_encode([
        'data' => $result === false ? Email::getError() : [],
        'status' => $result
    ], JSON_UNESCAPED_UNICODE);
});

//получить страницу описания недуга
$app->get('/pain/{id}/', function ($id){
    return (new PageActions())->getPain($id);
});
//получить страницу описания метода лечения
$app->get('/treatment/{id}/', function ($id){
    return (new PageActions())->getMethod($id);
});

//сохранение одного пункта
$app->post('/admin/save/{table}/', function ($table) use ($app){
    $app->getResponse()->setContentType('application/json');
    //полученные данные
    $data = Request::post();
    $result = (new AdminActions())->insertElement($table, $data);
    return json_encode([
        'data' => ['table' => $table, 'data' => $data, 'errors' => $result],
        'status' => count($result) === 0,
    ], JSON_UNESCAPED_UNICODE);
});

//редактирование одного пункта
$app->put('/admin/save/{table}/{id}/', function ($table, $id) use ($app){
    $app->getResponse()->setContentType('application/json');
    //полученные данные
    $data = json_decode(Request::put(), true);
    return json_encode([
        'data' => ['table' => $table, 'id'=>$id, 'data' => $data],
        'status' => (new AdminActions())->updateElement($table, $id, $data)
    ], JSON_UNESCAPED_UNICODE);
});

//удаление объектов в базе
$app->delete('/admin/delete/{table}/{id}/', function ($table, $id)  use ($app) {
    $app->getResponse()->setContentType('application/json');
    return json_encode([
        'data' => ['table' => $table, 'id' => $id],
        'status' => (new AdminActions())->removeElement($table, $id)
    ], JSON_UNESCAPED_UNICODE);
});

//авторизация
$app->post('/admin/login/auth/', function () {
    //создаём обработчик для админ панели
    (new AuthActions())->auth();
});

//админка
$app->get('/admin/{page}/', function ($page) {
    //создаём обработчик для админ панели
    return (new AdminActions())->getHTML($page);
});

//получить форму для создания объекта
$app->get('/admin/form/{table}/', function ($table)  use ($app) {
    $app->getResponse()->setContentType('application/json');
    $htmlForm = (new AdminActions())->getForm($table);
    return json_encode([
        'data' => $htmlForm,
        'status' => !empty($htmlForm),
    ], JSON_UNESCAPED_UNICODE);
});

//получить форму для редактирования объекта
$app->get('/admin/form/{table}/{id}/', function ($table, $id)  use ($app) {
    $app->getResponse()->setContentType('application/json');
    $htmlForm = (new AdminActions())->getForm($table, $id);
    return json_encode([
        'data' => $htmlForm,
        'status' => !empty($htmlForm),
    ], JSON_UNESCAPED_UNICODE);
});

//загрузка файла
$app->post('/admin/upload/{folder}/', function ($folder) use ($app) {
    $app->getResponse()->setContentType('application/json');

    //если мы не знаем пользователя, то и картинка не нужна
    if(!(new AdminActions())->isUser()){
        return json_encode([
            'status' => false
        ], JSON_UNESCAPED_UNICODE);
    }

    $save = $link = false;
    if($image = Request::file('upload')->toImage()){
        switch ($folder){
            case 'licenses':
                $save = $image->addWidth(250)->setQuality(60)->save(true, "/$folder/");
                break;
            default:
                $save = $image->save(true, "/$folder/");
                break;
        }
    }
    if($save){
        $link = $image->getLink();
    }

    return json_encode([
        'uploaded' => !empty($link) && $save * 1,
        'url' => $link
    ], JSON_UNESCAPED_UNICODE);
});

//если не один route не подошел
$app->notFound((new PageActions())->notFound(), 404);

//получение результата
$app->response();