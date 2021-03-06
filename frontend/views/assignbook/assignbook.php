<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Student;
use frontend\models\Book;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */
/* @var $form ActiveForm */

$students = ArrayHelper::map(Student::find()->all(), 'studentId', 'fullName');
$books = ArrayHelper::map(Book::find()->all(), 'bookId', 'bookName');
?>
<div class="assignbook">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'studentId')->dropDownList($students) ?>
        <?= $form->field($model, 'bookId')->dropDownList($books) ?>
       <?= $form->field($model, 'borrowDate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy/mm/dd'
        ]
    ]);?>

        <?= $form->field($model, 'returnDate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy/mm/dd'
        ]
    ]);?>


        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- assignbook -->
