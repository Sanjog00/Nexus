<?php

namespace app\models;

use yii\base\Model;
use app\components\ProfilePictureGenerator;


class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $gender;
    public $role_id;
    public $fullname;

    public function rules()
    {
        return [
            [['username', 'email', 'fullname', 'password', 'gender'], 'required'],
            ['email', 'email'],
            ['fullname', 'string', 'max' => 45],
            ['password', 'string', 'min' => 6],
            ['gender', 'in', 'range' => ['Male', 'Female', 'Other']],
            ['username', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\CustomUser', 'message' => 'This email is already registered.'],
            ['username', 'unique', 'targetClass' => '\app\models\CustomUser', 'message' => 'This username is already taken.'],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new CustomUser();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->fullname = strtoupper($this->fullname);

            $user->gender = $this->gender;
            $user->status = 1; // Active status
            $user->role_id = 1; // Default role
            $user->auth_key = \Yii::$app->security->generateRandomString();
            $user->password = \Yii::$app->security->generatePasswordHash($this->password);
            $user->access_token = \Yii::$app->security->generateRandomString();
            $profilePictureUrl = ProfilePictureGenerator::generate($user->fullname, $user->username);
            $user->profile_picture = $profilePictureUrl;

            $usermain = new Usersmain();
            $usermain->username = $this->username;
            $usermain->email = $this->email;
            $usermain->fullname = strtoupper($this->fullname);
            $usermain->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
            $usermain->gender = $this->gender;
            $usermain->profile_image_path = $profilePictureUrl;
            $usermain->save();

            return $user->save() ? $user : null;
        }

        return null;
    }
}
