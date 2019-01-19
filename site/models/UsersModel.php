<?php
/**
 * Created by IntelliJ IDEA.
 * User: oleg
 * Date: 21.09.18
 * Time: 18:15
 */

use xore\db\Model;

class UsersModel extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }
}