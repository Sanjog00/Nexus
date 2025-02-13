<?php
namespace app\models;

use yii\db\ActiveRecord;

class CustomUser extends ActiveRecord
{
    /**
     * Specifies the associated database table.
     *
     * @return string the table name
     */
    public static function tableName()
    {
        return 'user'; // Your user table name
    }

    public static function getDb()
    {
        return \Yii::$app->db; // Default database connection
    }

    /**
     * Define validation rules for your attributes.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'auth_key', 'fullname', 'gender'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['fullname', 'string', 'max' => 45],
            ['gender', 'in', 'range' => ['Male', 'Female', 'Other']],
            [['email', 'username'], 'unique'], // Ensure unique usernames and emails
        ];
    }

    /**
     * Automatically set `created_at` on insert.
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s'); // Set timestamp during insert
        }

        return parent::beforeSave($insert);
    }
}


?>