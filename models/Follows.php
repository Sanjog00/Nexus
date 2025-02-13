<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "follows".
 *
 * @property int $follower_id
 * @property int $followed_id
 * @property string|null $followed_at
 *
 * @property Usersmain $followed
 * @property Usersmain $follower
 */
class Follows extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'follows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['follower_id', 'followed_id'], 'required'],
            [['follower_id', 'followed_id'], 'integer'],
            [['followed_at'], 'safe'],
            [['follower_id', 'followed_id'], 'unique', 'targetAttribute' => ['follower_id', 'followed_id']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usersmain::class, 'targetAttribute' => ['follower_id' => 'user_id']],
            [['followed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usersmain::class, 'targetAttribute' => ['followed_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'follower_id' => Yii::t('app', 'Follower ID'),
            'followed_id' => Yii::t('app', 'Followed ID'),
            'followed_at' => Yii::t('app', 'Followed At'),
        ];
    }

    /**
     * Gets query for [[Followed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowed()
    {
        return $this->hasOne(Usersmain::class, ['user_id' => 'followed_id']);
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(Usersmain::class, ['user_id' => 'follower_id']);
    }
}
