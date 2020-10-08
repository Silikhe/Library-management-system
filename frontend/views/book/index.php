<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Book;
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
                       /* [
                          'label'=>'Borrow Book',
                          'format' => 'raw',
                          'value' => function ($dataProvider) {
                          return '<span val='.$dataProvider->book_id.' class="btn btn-success requestbook">Borrow Book</span>';
                            },
                        ],*/
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
