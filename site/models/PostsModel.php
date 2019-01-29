<?php

use Xore\db\Model;

/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 12.01.19
 * Time: 19:56
 */

class PostsModel extends Model
{
    /**
     * Статусы постов: 0 - черновик, 1 - опубликован
     * PostsModel constructor.
     */
    public function __construct()
    {
        parent::__construct('posts');
    }

    /**
     * получить все опубликованые статьи
     * @return array
     */
    public function getPublic(): array
    {
        $result = $this->getAll("SELECT * FROM ".$this->getTable()." WHERE status = 1 ORDER BY date ASC");
        return !$result ? [] : $result;
    }

    /**
     * Добавление нового поста
     * @param array $data
     * @return array
     */
    public function setItem(array $data): array
    {
        $validate = $this->validate([
            'user_id' => ['required'],
            'title' => ['required'],
            'text' => ['required'],
        ], $data);
        if(count($validate) > 0) return $validate;
        $data['date'] = date('Y-m-d', $data['date'] ? strtotime($data['date']) : null);
        return $this->insert($data) > 0 ? [] : ['db' => 'не удалось добавить запись в БД'];
    }

    /**
     * пагинация постов
     *
     * @param Int $page
     * @param Int $count
     * @param bool $onlyPublic
     * @return array
     */
    public function getItemsByPage(Int $page = 1, Int $count = 5, $onlyPublic = true): Array
    {
        $page--;
        //с какого элемента начать
        $indexStarted = $count*$page;
        //вывод только опубликованых
        $filter = $onlyPublic ? 'where status=1' : '';
        $result = $this->getAll("SELECT * FROM posts ${filter} ORDER BY date LIMIT ${indexStarted}, ${count}");
        return is_array($result) ? $result : [];
    }
}