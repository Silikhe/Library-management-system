<?php

use yii\helpers\Html;
use common\components\Notification;


Notification::notify(Notification::KEY_NEW_MESSAGE, $recipient_id, $message->id);
/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */

$this->title = 'Create Borrowedbook';
$this->params['breadcrumbs'][] = ['label' => 'Borrowedbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrowedbook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
