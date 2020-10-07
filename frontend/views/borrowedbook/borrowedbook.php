<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */
/* @var $form ActiveForm */
?>
<div class="borrowedbook">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'studentId') ?>
        <?= $form->field($model, 'bookId') ?>
        <?= $form->field($model, 'borrowDate') ?>
        <?= $form->field($model, 'expectedReturn') ?>
        <?= $form->field($model, 'actualReturnDate') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- borrowedbook -->
