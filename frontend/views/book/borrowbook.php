<?php
use kartik\date\DatePicker;
use frontend\models\Book;
use frontend\models\Student;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\Borrowedbook */
/* @var $form ActiveForm */
$books = ArrayHelper::map(Book::find()->where(['status'=>0])->all(), 'bookId', 'bookName');
$students = ArrayHelper::map(Student::find()->all(), 'studentId', 'fullName');?>
<div class="borrowbook">
    <?php $form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin([
            'action' =>['book/borrowbook'],
            'method'=>'post',
        ]); ?>
        <?= $form->field($model, 'studentId')->dropDownList($students) ?>
        <?= $form->field($model, 'bookId')->dropDownList($books) ?>
        <?= $form->field($model, 'borrowDate')->hiddenInput(['value'=>date('yy/m/d')])->label(false) ?>
        <?= $form->field($model, 'expectedReturn')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter Expected Return date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format'=>'yyyy/mm/dd'
            ]
        ]);
 ?>
        <div class="form-group">
            <?= Html::submitButton('Confirm', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?></div>
    <!-- borrowbook -->