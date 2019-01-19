<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:15
 */

use xore\db\Model;

class PricesModel extends Model
{
    public function __construct()
    {
        parent::__construct('prices');
    }

    /**
     * Добавление новой лицензии
     * @param array $data
     * @return array
     */
    public function setItem(array $data): array
    {
        $validate = $this->validate([
            'name' => ['required'],
            'price' => ['required'],
        ], $data);
        if(count($validate) > 0) return $validate;
        return $this->insert($data) > 0 ? [] : ['db' => 'не удалось добавить запись в БД'];
    }
}