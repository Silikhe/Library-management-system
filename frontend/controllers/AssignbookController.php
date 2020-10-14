<?php

namespace frontend\controllers;

class AssignbookController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


public function actionAssignbook()//this function is given when generating a form//
{
    $model = new \frontend\models\Borrowedbook();

    if ($model->load(\Yii::$app->request->post())) {
        if ($model->validate() && $model->save())
        {
            // form inputs are valid, do something here
            return $this->redirect(['site/index']);
        }
    }

    return $this->renderAjax('assignbook', [  //ajax is used to load a specific form and not the whole page//
        'model' => $model,
    ]);
}
public function updateAfterDelete($bookId){
    $command = \Yii::$app->db->createCommand('UPDATE book SET status=0 WHERE bookId='.$bookId);
    $command->execute();
    return true;
}

}

