<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:15
 */

use xore\db\Model;

class AnyModel extends Model
{
    public function __construct()
    {
        parent::__construct('emails');
    }

    /**
     * @param String $table
     * @return AnyModel
     */
    public function setTable(String $table): AnyModel
    {
        $this->table = $table;
        return $this;
    }
}