<?php

use yii\helpers\Html;
use common\components\Notification;
use frontend\models\Student;

/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */

$this->title = 'Create Borrowedbook';
$this->params['breadcrumbs'][] = ['label' => 'Borrowedbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$recipient_id = Student::findOne($this->id);
$users = ArrayHelper::map(User::find()->all(), 'id', 'username');
Notification::notify(Notification::KEY_NEW_MESSAGE, $recipient_id, $message->id);
?>
<div class="borrowedbook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
