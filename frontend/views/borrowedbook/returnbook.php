<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\Student;
use frontend\models\Book;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */
/* @var $form ActiveForm */
$students = ArrayHelper::map(Student::find()->all(), 'studentId', 'fullName');
$books = ArrayHelper::map(Book::find()->all(), 'bookId', 'bookName');
?>
<div class="returnbook">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'studentId')->dropDownList($students,['disabled' => true]) ?>
    <?= $form->field($model, 'bookId')->dropDownList($books,['disabled' => true]) ?>
    <?= $form->field($model, 'borrowDate')->textInput(['disabled' => true])?>
    <?= $form->field($model, 'expectedReturn')->textInput(['disabled' => true]) ?>
        <?= $form->field($model, 'actualReturnDate') ->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy/mm/dd'
        ]
    ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>



