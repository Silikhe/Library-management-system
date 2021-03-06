<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Borrowedbook;
use frontend\models\BorrowedbookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Book;
use frontend\models\Student;

/**
 * BorrowedbookController implements the CRUD actions for Borrowedbook model.
 */
class BorrowedbookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Borrowedbook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BorrowedbookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Borrowedbook model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Borrowedbook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $model = new Borrowedbook();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($this->bookUpdate($model->bookId)){
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function bookUpdate($bookId){ // this function is used to join and update the grid to current borrowed//
        $command = \Yii::$app->db->createCommand('UPDATE book SET status= 2 WHERE bookId='.$bookId);
        $command->execute();
        return true;
    }

    /**
     * Updates an existing Borrowedbook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bbId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionBorrowedbook()
{
    $model = new \frontend\models\Borrowedbook();
    $searchModel = new BorrowedbookSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return $this ->redirect (['index']);
        }
    }

    return $this->renderAjax('borrowedbook', [
        'model' => $model,
    ]);
}


public function actionReturnbook($id)
{
    $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->updateAfterDelete($model->bookId);
            return $this->redirect(['index']);
        }

        return $this->renderAjax('returnbook', [
            'model' => $model,
        ]);
}

public function actionApprovebook($id,$studentId){
    $command = \Yii::$app->db->createCommand('UPDATE book SET status=1 WHERE bookId='.$id);
    $command->execute();
    $this->createNotification($studentId,$id);
    return $this->redirect(['index']);
}

public function createNotification($studentId,$bookId){
    $book = Book::find()->where(['bookId'=>$bookId])->one();
    $icon= 'fa fa-book';
    $userId = Student::find()->where(['studentId'=>$studentId])->one();
    \Yii::$app->db->createCommand()->insert('notification', [
        'icon' => $icon,
        'userId' => $userId->userId,
        'message'=> 'Your request for book '.$book->bookName.' has been approved.'
    ])->execute();
    return true;
}



    /**
     * Deletes an existing Borrowedbook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $bookId = BorrowedBook::find()->where(['bbId'=>$id])->one();
        $this->findModel($id)->delete();
        $this->updateAfterDelete($bookId->bookId);
        return $this->redirect(['index']);
    }

    public function updateAfterDelete($bookId){
        $command = \Yii::$app->db->createCommand('UPDATE book SET status=0 WHERE bookId='.$bookId);
        $command->execute();
        return true;
    }
    /**
     * Finds the Borrowedbook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Borrowedbook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Borrowedbook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
