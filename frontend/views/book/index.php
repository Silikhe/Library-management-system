<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Book;
use yii\bootstrap\Modal;
use frontend\models\BorrowedBook;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php if (Yii::$app->user->can('Admin')){?>
  <div class="box box-info">
            <div class="box-header with-border">
          <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
              <div style="text-align: center;">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              </div>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'bookId',
                        'bookName',
                        'referenceNo',
                        'publisher',
                        'status',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
            <!-- /.box-body -->
          </div>
   <?php }?>
   <?php if (Yii::$app->user->can('Librarian')){?>
  <div class="box box-info">
            <div class="box-header with-border">
          <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
              <div style="text-align: center;">
                  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
              </div>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'bookId',
                        'bookName',
                        'referenceNo',
                        'publisher',
                        [
                          'label'=>'Status',
                          'format' => 'raw',
                          'value' => function ($dataProvider) {
                          $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                          if($bookStatus->status == 0){
                            $btn = 'success';
                              $status = 'Available';
                          }elseif ($bookStatus->status == 1){
                            $btn = 'info';
                            $status = 'Issued';
                          }elseif ($bookStatus->status == 2){
                              $btn = 'warning';
                              $status = 'Pending';
                              return '<span class="btn btn-'.$btn.' approvebtn">'.$status.'</span>';
                          }
                          return '<span class="btn btn-'.$btn.'">'.$status.'</span>';
                          },
                          ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
            <!-- /.box-body -->
          </div>
   <?php }?>
   <?php if (Yii::$app->user->can('Student')){?>
  <div class="box box-info">

            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'bookId',
                        'bookName',
                        'referenceNo',
                        'publisher',
                        [
                          'label'=>'Return',
                          'format' => 'raw',

                          'value' => function ($dataProvider) {
                              $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                              if($bookStatus->status == 0){
                                $btn = 'block';
                              }elseif ($bookStatus->status == 1){
                                $btn = 'none';
                              }elseif ($bookStatus->status == 2){
                                $btn = 'none';
                              }
                          return '<span  style="display:'.$btn.'" class="btn btn-warning borrowbook">Borrow</span>';
                          },
                          ],
                        [
                          'label'=>'Status',
                          'format' => 'raw',
                          'value' => function ($dataProvider) {
                          $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                          if($bookStatus->status == 0){
                            $btn = 'success';
                              $status = 'Available';
                              return '<span class=" approvebtn btn btn-'.$btn.' ">'.$status.'</span>';
                          }elseif ($bookStatus->status == 1){
                            $btn = 'info';
                              $status = 'Issued';
                          }elseif ($bookStatus->status == 2){
                            $btn = 'warning';
                              $status = 'Pending';
                          }
                          return '<span class="btn btn-'.$btn.'">'.$status.'</span>';
                          },
                          ],

                        // ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
            <!-- /.box-body -->
          </div>
   <?php }?>
   <?php
        Modal::begin([
              'header'=>'<h4>Borrow Book</h4>',
              'id'=>'borrowbook',
              'size'=>'modal-lg'
              ]);
          echo "<div id='borrowbookContent'></div>";
          Modal::end();
        ?>


<?php
        Modal::begin([
              'header'=>'<h4>Approve Book</h4>',
              'id'=>'approvebook',
              'size'=>'modal-sm'
              ]);
          echo "<div id='approvebookContent'></div>";
          Modal::end();
        ?>