<?php

namespace app\models;

use Yii;
use yii\base\Model;
use amnah\yii2\user\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['password', 'confirmPassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
        ];
    }

    public function updatePassword($email)
    {
        $user = User::findOne(['email' => $email]);
        if ($user) {
            if ($this->validate()) {
                $user->newPassword = $this->password;
                return $user->save();
            }
        }
        return false;
    }
}
