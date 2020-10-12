<?php

namespace frontend\models;

use Yii;
use frontend\models\User;

/**
 * This is the model class for table "notification".
 *
 * @property int $notId
 * @property string $icon
 * @property int $user_id
 * @property string $created_at
 * @property string $message
 *
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icon', 'user_id', 'created_at', 'message'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['icon'], 'string', 'max' => 255],
            [['message'], 'string', 'max' => 225],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'notId' => 'Not ID',
            'icon' => 'Icon',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'message' => 'Message',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
