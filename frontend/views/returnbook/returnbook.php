<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */
/* @var $form ActiveForm */
?>
<div class="returnbook">

    <?php $form = ActiveForm::begin(); ?>

    
        <div class="form-group accept">
            <?= Html::submitButton('Yes', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <div class="form-group decline">
            <?= Html::submitButton('No', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- returnbook -->
