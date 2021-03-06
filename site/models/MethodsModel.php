<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:15
 */

use xore\db\Model;

class MethodsModel extends Model
{
    public function __construct()
    {
        parent::__construct('methods');
    }

    /**
     * Добавление нового метода
     * @param array $data
     * @return array
     */
    public function setItem(array $data): array
    {
        $validate = $this->validate([
            'title' => ['required'],
            'text' => ['required'],
        ], $data);
        if(count($validate) > 0) return $validate;
        return $this->insert($data) > 0 ? [] : ['db' => 'не удалось добавить запись в БД'];
    }
}