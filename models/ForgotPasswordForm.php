<?php

namespace app\models;

use yii\base\Model;

class ForgotPasswordForm extends Model
{
    public $username;

    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'validateUserExists'],
        ];
    }

    public function validateUserExists($attribute, $params)
    {
        $user = Usersmain::find()
            ->where(['or', ['email' => $this->username], ['username' => $this->username]])
            ->one();

        if (!$user) {
            $this->addError($attribute, 'No user found with this email or username.');
        }
    }

    public function getAssociatedEmail()
    {
        $user = Usersmain::find()
            ->where(['or', ['email' => $this->username], ['username' => $this->username]])
            ->one();

        return $user ? $user->email : '';
    }
}
