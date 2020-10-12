<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Book */
/* @var $form ActiveForm */
?>
<div class="approve">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'bookName') ?>
        <?= $form->field($model, 'referenceNo') ?>
        <?= $form->field($model, 'publisher') ?>
        <?= $form->field($model, 'status') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- approve -->
