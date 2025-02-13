<?php

namespace app\models;

use Yii;
use yii\base\Model;

class VerificationCodeForm extends Model
{
    public $digit1;
    public $digit2;
    public $digit3;
    public $digit4;
    public $digit5;

    public function rules()
    {
        return [
            [['digit1', 'digit2', 'digit3', 'digit4', 'digit5'], 'safe'],
            [['digit1', 'digit2', 'digit3', 'digit4', 'digit5'], 'string', 'max' => 1],
        ];
    }

    public function getCode()
    {
        return $this->digit1 . $this->digit2 . $this->digit3 . $this->digit4 . $this->digit5;
    }
}
