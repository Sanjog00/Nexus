<?php

namespace app\models;

use yii\base\Model;

class UserSearch extends Model
{
    public $fullname;

    public function rules()
    {
        return [
            ['fullname', 'safe'],
        ];
    }
}
