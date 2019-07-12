<?php

use Xore\db\Model;

/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 12.01.19
 * Time: 19:56
 */

class ReviewModel extends Model
{
    /**
     * ReviewModel constructor.
     */
    public function __construct()
    {
        parent::__construct('reviews');
    }

    /**
     * получить все опубликованые статьи
     * @return array
     */
    public function getPublic(): array
    {
        $result = $this->getAll("SELECT * FROM ".$this->getTable());
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
            'user_name' => ['required'],
            'avatar' => ['required'],
            'text' => ['required'],
        ], $data);
        if(count($validate) > 0) return $validate;
        return $this->insert($data) > 0 ? [] : ['db' => 'не удалось добавить запись в БД'];
    }

    /**
     * пагинация отзывов
     *
     * @param Int $page
     * @param Int $count
     * @return array
     */
    public function getItemsByPage(Int $page = 1, Int $count = 5): Array
    {
        $page--;
        //с какого элемента начать
        $indexStarted = $count*$page;
        //вывод только опубликованых
        $result = $this->getAll("SELECT * FROM posts LIMIT ${indexStarted}, ${count}");
        return is_array($result) ? $result : [];
    }
}