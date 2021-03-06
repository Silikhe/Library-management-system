<?php

namespace frontend\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Student;
use frontend\models\Borrowedbook;

/**
 * BorrowedbookSearch represents the model behind the search form of `frontend\models\Borrowedbook`.
 */
class BorrowedbookSearch extends Borrowedbook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bbId', 'studentId', 'bookId'], 'integer'],
            [['borrowDate', 'expectedReturn', 'actualReturnDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (Yii::$app->user->can('Student')){
            $studentId = Student::find()->where(['userId'=>Yii::$app->user->id])->one();
            $query = BorrowedBook::find()->where(['actualReturnDate'=>NULL])->andWhere(['studentId'=>$studentId->studentId]);

        }
        if (Yii::$app->user->can('Librarian')){
            $query = BorrowedBook::find()->where(['actualReturnDate'=>NULL]);
        }



        // $query = Borrowedbook::find();
        // $query = Borrowedbook::find()->where(['actualReturnDate'=>NULL]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'bbId' => $this->bbId,
            'studentId' => $this->studentId,
            'bookId' => $this->bookId,
            'borrowDate' => $this->borrowDate,
            'expectedReturn' => $this->expectedReturn,
            'actualReturnDate' => $this->actualReturnDate,

        ]);

        return $dataProvider;
    }
}
