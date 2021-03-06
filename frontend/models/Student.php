<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "student".
 *
 * @property int $studentId
 * @property int $userId
 * @property string $fullName
 * @property int $idNumber
 * @property string $regNo
 *
 * @property Borrowedbook[] $borrowedbooks
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'fullName', 'idNumber', 'regNo'], 'required'],
            [['userId', 'idNumber'], 'integer'],
            [['fullName'], 'string', 'max' => 255],
            [['regNo'], 'string', 'max' => 50],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'studentId' => 'Student ID',
            'userId' => 'User ID',
            'fullName' => 'Full Name',
            'idNumber' => 'Id Number',
            'regNo' => 'Reg No',
        ];
    }

    /**
     * Gets query for [[Borrowedbooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBorrowedbooks()
    {
        return $this->hasMany(Borrowedbook::className(), ['studentId' => 'studentId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
