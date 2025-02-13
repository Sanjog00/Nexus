<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $message_id
 * @property int|null $sender_id
 * @property int|null $receiver_id
 * @property string|null $content
 * @property string|null $message_type
 * @property string|null $created_at
 *
 * @property Usersmain $receiver
 * @property Usersmain $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id'], 'integer'],
            [['content', 'message_type'], 'string'],
            [['created_at'], 'safe'],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usersmain::class, 'targetAttribute' => ['sender_id' => 'user_id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usersmain::class, 'targetAttribute' => ['receiver_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('app', 'Message ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'content' => Yii::t('app', 'Content'),
            'message_type' => Yii::t('app', 'Message Type'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Receiver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Usersmain::class, ['user_id' => 'receiver_id']);
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
}
