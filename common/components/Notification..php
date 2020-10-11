<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\models\Book;
use frontend\models\User;
use frontend\models\Student;
use machour\yii2\notifications\models\Notification as BaseNotification;


/**
 * Login form
 */
class Notification extends BaseNotification
{

    /**
     * A new message notification
     */
    const KEY_NEW_MESSAGE = 'new_message';
    /**
     * A meeting reminder notification
     */
    const KEY_MEETING_REMINDER = 'meeting_reminder';
    /**
     * No disk space left !
     */
    const KEY_NO_DISK_SPACE = 'no_disk_space';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_MESSAGE,
        self::KEY_MEETING_REMINDER,
        self::KEY_NO_DISK_SPACE,
    ];

    /**
     * @inheritdoc
     */ public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_MEETING_REMINDER:
                return Yii::t('app', 'Meeting reminder');

            case self::KEY_NEW_MESSAGE:
                return Yii::t('app', 'You got a new message');

            case self::KEY_NO_DISK_SPACE:
                return Yii::t('app', 'No disk space left');
        }
    }



    /**
     * @inheritdoc
     */    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_MEETING_REMINDER:
                // $meeting = Student::findOne($this->key_id);
                $users = ArrayHelper::map(User::find()->all(), 'id', 'username');
                return Yii::t('app', 'You are meeting with {customer}', [
                    'customer' => $users->id->name
                ]);

            case self::KEY_NEW_MESSAGE:
                $message = Book::findOne($this->key_id);
                return Yii::t('app', '{customer} sent you a message', [
                    'customer' => $message->customer->name
                ]);

            case self::KEY_NO_DISK_SPACE:
                // We don't have a key_id here, simple message
                return 'Please buy more space immediately';
        }
    }


    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_MEETING_REMINDER:
                return ['meeting', 'id' => $this->key_id];

            case self::KEY_NEW_MESSAGE:
                return ['message/read', 'id' => $this->key_id];

            case self::KEY_NO_DISK_SPACE:
                return 'https://aws.amazon.com/';//simple route on external link
        };
    }

}