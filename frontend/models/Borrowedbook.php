<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "borrowedbook".
 *
 * @property int $bbId
 * @property int $studentId
 * @property int $bookId
 * @property string $borrowDate
 * @property string $expectedReturn
 * @property string|null $actualReturnDate
 *
 * @property Book $book
 * @property Student $student
 */
class Borrowedbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'borrowedbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['studentId', 'bookId', 'borrowDate', 'expectedReturn'], 'required'],
            [['studentId', 'bookId'], 'integer'],
            [['borrowDate', 'expectedReturn', 'actualReturnDate'], 'safe'],
            [['bookId'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['bookId' => 'bookId']],
            [['studentId'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['studentId' => 'studentId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bbId' => 'Bb ID',
            'studentId' => 'Student ID',
            'bookId' => 'Book ID',
            'borrowDate' => 'Borrow Date',
            'expectedReturn' => 'Expected Return',
            'actualReturnDate' => 'Actual Return Date',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['bookId' => 'bookId']);
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['studentId' => 'studentId']);
    }
}
