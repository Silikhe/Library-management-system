<?php

namespace frontend\controllers;

class ReturnbookController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReturnbook()
    {
        $model = new \frontend\models\Borrowedbook();
        
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
        
        return $this->renderAjax('returnbook', [
            'model' => $model,
        ]);
    }
}
