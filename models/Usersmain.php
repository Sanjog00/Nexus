<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usersmain".
 *
 * @property int $user_id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $profile_image_path
 * @property string|null $bio
 * @property string|null $birthdate
 * @property string|null $gender
 * @property string|null $created_at
 * @property string $fullname
 *
 * @property Comments[] $comments
 * @property Usersmain[] $followeds
 * @property Usersmain[] $followers
 * @property Follows[] $follows
 * @property Follows[] $follows0
 * @property Likes[] $likes
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Notifications[] $notifications
 * @property Posts[] $posts
 * @property Posts[] $posts0
 */
class Usersmain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usersmain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'fullname'], 'safe'],
            [['bio', 'gender'], 'string'],
            [['fullname'], 'safe'],
            [['birthdate', 'created_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['password_hash', 'profile_image_path'], 'string', 'max' => 255],
            [['fullname'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'profile_image_path' => Yii::t('app', 'Profile Image Path'),
            'bio' => Yii::t('app', 'Bio'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'gender' => Yii::t('app', 'Gender'),
            'created_at' => Yii::t('app', 'Created At'),
            'fullname' => Yii::t('app', 'Fullname'),
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Followeds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolloweds()
    {
        return $this->hasMany(Usersmain::class, ['user_id' => 'followed_id'])->viaTable('follows', ['follower_id' => 'user_id']);
    }

    /**
     * Gets query for [[Followers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Usersmain::class, ['user_id' => 'follower_id'])->viaTable('follows', ['followed_id' => 'user_id']);
    }

    /**
     * Gets query for [[Follows]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollows()
    {
        return $this->hasMany(Follows::class, ['follower_id' => 'user_id']);
    }

    /**
     * Gets query for [[Follows0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollows0()
    {
        return $this->hasMany(Follows::class, ['followed_id' => 'user_id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['sender_id' => 'user_id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::class, ['receiver_id' => 'user_id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Posts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts0()
    {
        return $this->hasMany(Posts::class, ['post_id' => 'post_id'])->viaTable('likes', ['user_id' => 'user_id']);
    }
}
