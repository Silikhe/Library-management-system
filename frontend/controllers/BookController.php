<?php

namespace frontend\controllers;
use frontend\models\Bookauthor;

use Yii;
use frontend\models\Book;
use frontend\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\BorrowedbookSearch;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  /*  public function actionCreate()
    {
        $model = new Book();
        $bookAuthor = New BookAuthor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $authorId = Yii::$app->request->post()['Bookauthor']['authorId'];
            $bookId = $model->bookId;
            if($this->bookauthors($authorId,$bookId)){
                return $this->redirect(['index']);
            }
            return $this->redirect(['create']);
        }
        return $this->render('create', [
            'model' => $model,
            'bookAuthor'=>$bookAuthor
        ]);
    } */
    public function actionCreate()
    {
        // if( \Yii::$app->user->can( 'create-book' ))
        {
            $model = new Book();
            $bookAuthor = New BookAuthor();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $authorId = Yii::$app->request->post()['Bookauthor']['authorId'];
                $bookId = $model->bookId;
                if($this->bookauthors($authorId,$bookId)){
                    return $this->redirect(['index']);
                }
                return $this->redirect(['create']);
            }
            return $this->render('create', [
                'model' => $model,
                'bookAuthor'=>$bookAuthor
            ]);
        }
        // else{
        //     throw new ForbiddenHttpException();
        // }

    }

    // public function actionApprove($id,$studentId){
    //     $command = \Yii::$app->db->createCommand('UPDATE book SET status=1 WHERE bookId='.$id);
    //     $command->execute();
    //     $this->createNotification($studentId,$id);
    //     return $this->redirect(['index']);
    // }
    // public function createNotification($studentId,$bookId){
    //     $book = Book::find()->where(['bookId'=>$bookId])->one();
    //     $icon= 'fa fa-book';
    //     $userId = Student::find()->where(['studentsId'=>$studentId])->one();
    //     \Yii::$app->db->createCommand()->insert('notifications', [
    //         'icon' => $icon,
    //         'userId' => $userId->userId,
    //         'message'=> 'Your request for book '.$book->bookName.' has been approved.'
    //     ])->execute();
    //     return true;
    // }



    public function actionBorrowedbook()
{
    $model = new \frontend\models\Borrowedbook();
    $searchModel = new BorrowedbookSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return $this ->redirect ('index');
        }
    }

    return $this->renderAjax('borrowedbook', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]);
}



public function actionApprove()
{
    $model = new \frontend\models\Book();
    $searchModel = new BorrowedbookSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return $this ->redirect ('index');
        }
    }

    return $this->renderAjax('approve', [
        'model' => $model,
        'dataProvider' => $dataProvider,

    ]);
}


    public function actionAddauthor()
    {
        $model = new \frontend\models\Author();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                return $this->redirect(['create']);}
        }

        return $this->renderAjax('addauthor', [
            'model' => $model,
        ]);
    }
    public function bookauthors($authorId,$bookId){
        $model = New BookAuthor();
        $data= array('BookAuthor'=>['bookId'=>$bookId,'authorId'=>$authorId]);

        if($model->load($data) && $model->save()){
            return true;
        }
        return false;
    }
    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bookId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function updateAfterDelete($bookId){
        $command = \Yii::$app->db->createCommand('UPDATE book SET status=0 WHERE bookId='.$bookId);
        $command->execute();
        return true;
    }
    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
