<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $notification_id
 * @property int|null $sender_id
 * @property string|null $notification_text
 * @property int|null $is_read
 * @property string|null $created_at
 * @property string|null $type
 * @property int $post_id
 * @property int|null $receiver_id
 *
 * @property Usersmain $sender
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'is_read', 'post_id', 'receiver_id'], 'integer'],
            [['notification_text'], 'string'],
            [['created_at'], 'safe'],
            [['post_id'], 'required'],
            [['type'], 'string', 'max' => 15],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usersmain::class, 'targetAttribute' => ['sender_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => Yii::t('app', 'Notification ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'notification_text' => Yii::t('app', 'Notification Text'),
            'is_read' => Yii::t('app', 'Is Read'),
            'created_at' => Yii::t('app', 'Created At'),
            'type' => Yii::t('app', 'Type'),
            'post_id' => Yii::t('app', 'Post ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
        ];
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Usersmain::class, ['user_id' => 'sender_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Posts::class, ['post_id' => 'post_id']);
    }

    public function getComment()
    {
        return $this->hasOne(Comments::class, ['comment_id' => 'comment_id']);
    }
}
