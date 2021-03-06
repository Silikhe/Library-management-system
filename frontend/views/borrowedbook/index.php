  <?php

  use yii\helpers\Html;
  use yii\grid\GridView;
  use yii\bootstrap\Modal;
  use frontend\models\Book;
  use frontend\models\BorrowedBook;
  use frontend\models\Student;
  /* @var $this yii\web\View */
  /* @var $searchModel frontend\models\BorrowedBookSearch */
  /* @var $dataProvider yii\data\ActiveDataProvider */
  $this->title = 'Silas LMS';
  $this->params['breadcrumbs'][] = $this->title;


  $totalBooks = Book::find()->asArray()->all();
  $totalBorrows = Borrowedbook::find()->where(['actualReturnDate'=>NULL])->asArray()->all();
  $totalStudents = Student::find()->asArray()->all();
  $overdue = Borrowedbook::find()->where('expectedReturn > '.date('yy/m/d'))->andWhere(['actualReturnDate'=>NULL])->asArray()->all();
  $borrowStudents = Borrowedbook::find()->asArray()->all();

//   if(\Yii::$app->user->can('Student')){
//     $studentId = Student::find()->where(['userId'=>\yii::$app->user->id])->one();
//     $bb = BorrowedBook::find()->Where(['studentId'=>$studentId->studentsId])->asArray()->all();
// }
// if(\Yii::$app->user->can('Librarian')){
//     $bb = BorrowedBook::find()->asArray()->all();
// }
  ?>
  <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">TOTAL BOOKS</span>
                <span class="info-box-number"><?= count($totalBooks)?><small></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fa fa-book"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">BORROWED BOOKS</span>
                <span class="info-box-number"><?= count($totalBorrows)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">OVERDUE BOOKS</span>
                <span class="info-box-number"><?= count($overdue)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">TOTAL STUDENTS</span>
                <span class="info-box-number"><?= count($totalStudents)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
              <?php if (Yii::$app->user->can('Admin')){?>
            <div style="padding-top: 20px;">
              <button type="button" class="btn btn-block btn-success btn-lg assignbook" style="width: 300px;"><i class="fa fa-plus" aria-hidden="true"></i> Assign a Book</button>
              </div>
              <?php }?>
              <?php if (Yii::$app->user->can('Librarian')){?>
            <div style="padding-top: 20px;">
              <button type="button" class="btn btn-block btn-success btn-lg assignbook" style="width: 300px;"><i class="fa fa-plus" aria-hidden="true"></i> Assign a Book</button>
              </div>
              <?php }?>
              <?php if (Yii::$app->user->can('Student')){?>
            <div style="padding-top: 20px;">
              <button type="button" class="btn btn-block btn-success btn-lg borrowedbook" style="width: 300px;"><i class="fa fa-plus" aria-hidden="true"></i> Borrow Book</button>
              </div>
              <?php }?>
              <?php if (Yii::$app->user->can('Admin')){?>
                <div style="text-align: center;">
                  <h2 class="box-title"><strong>BOOK ASSIGNMENT</strong></h2>
              </div>
              <?php }?>

              <?php if (Yii::$app->user->can('Librarian')){?>
                <div style="text-align: center;">
                  <h2 class="box-title"><strong>BOOK ASSIGNMENT</strong></h2>
              </div>
              <?php }?>

              <?php if (Yii::$app->user->can('Student')){?>
                <div style="text-align: center;">
                  <h2 class="box-title"><strong>BOOKS BORROWED</strong></h2>
              </div>
              <?php }?>

              <!-- <div style="text-align: center;">
                  <h2 class="box-title"><strong>BOOK ASSIGNMENTS</strong></h2>
              </div> -->
                <div class="box-tools">
                  <div class="input-group input-group-sm hidden-xs" style="width: 300px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                    <div class="input-group-btn">
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
              <?php if (Yii::$app->user->can('Admin')){?>
              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      //'bbId',
                      [
                          'attribute' => 'studentId',
                          'value' => function ($dataProvider) {
                          $studentName = Student::find()->where(['studentId'=>$dataProvider->student])->One();
                          return $studentName->fullName;
                          },
                          ],
                          [
                              'attribute' => 'bookId',
                              'value' => function ($dataProvider) {
                              $studentName = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                              return $studentName->bookName;
                              },
                              ],
                              [
                                  'attribute' => 'borrowDate',
                                  'value' => function ($dataProvider) {
                                  $date = new DateTime($dataProvider->borrowDate);
                                  return $date->format('F j, Y,');
                                  },
                                  ],
                                  [
                                      'attribute' => 'Expected Return',
                                      'value' => function ($dataProvider) {
                                      $date = new DateTime($dataProvider->expectedReturn);
                                      return $date->format('F j, Y,');
                                      },
                                      ],
                                      [
                                      'attribute' => 'returnDate',
                                      'value'=>date('yy/m/d')
                                      ],

                                      [
                                          'label'=>'Return',
                                          'format' => 'raw',
                                          'value' => function ($dataProvider) {
                                          return '<span val="'.$dataProvider->bbId.'" class="btn btn-danger returnbook">Return</span>';
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
                                              }elseif ($bookStatus->status == 1){
                                                $btn = 'Info';
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
  <?php }?>
          <?php if (Yii::$app->user->can('Librarian')){?>
              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      //'bbId',
                      [
                          'attribute' => 'studentId',
                          'value' => function ($dataProvider) {
                          $studentName = Student::find()->where(['studentId'=>$dataProvider->student])->One();
                          return $studentName->fullName;
                          },
                          ],
                          [
                              'attribute' => 'bookId',
                              'value' => function ($dataProvider) {
                              $studentName = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                              return $studentName->bookName;
                              },
                              ],
                              [
                                  'attribute' => 'borrowDate',
                                  'value' => function ($dataProvider) {
                                  $date = new DateTime($dataProvider->borrowDate);
                                  return $date->format('F j, Y,');
                                  },
                                  ],
                                  [
                                      'attribute' => 'Expected Return',
                                      'value' => function ($dataProvider) {
                                      $date = new DateTime($dataProvider->expectedReturn);
                                      return $date->format('F j, Y,');
                                      },
                                      ],
                                      [
                                      'attribute' => 'returnDate',
                                      'value'=>date('yy/m/d')
                                      ],

                                      [
                                          'label'=>'Return',
                                          'format' => 'raw',
                                          'value' => function ($dataProvider) {
                                            $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                                            if($bookStatus->status == 2){

                                                $display = 'none';
                                           return '<span val="'.$dataProvider->bbId.' "style="display:'.$display.'" " class="btn btn-danger returnbook">Return</span>';

                                            }
                                          return "";
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
                                              }elseif ($bookStatus->status == 1){
                                                $btn = 'Info';
                                                  $status = 'Issued';
                                              }elseif ($bookStatus->status == 2){
                                                $btn = 'warning';
                                                  $status = 'Pending';
                                              }
                                              return '<span class="btn btn-'.$btn.'">'.$status.'</span>';
                                              },
                                              ],
                                              [
                                                'label'=>'Approve Books',
                                                'format' => 'raw',
                                                'value' => function ($dataProvider) {
                                                $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                                                if( $bookStatus->status == 2){
                                                  return Html::a('Approve', ['approvebook','id'=>$dataProvider->bookId,'studentId'=>$dataProvider->studentId], ['class' => 'btn btn-success']);                                                 }
                                                return '';
                                                },

                                             ],
                                              ['class' => 'yii\grid\ActionColumn'],
                                              ],
                                              ]); ?>

  <?php }?>
  <?php if (Yii::$app->user->can('Student')){?>
              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      //'bbId',
                      [
                          'attribute' => 'studentId',
                          'value' => function ($dataProvider) {
                          $studentName = Student::find()->where(['studentId'=>$dataProvider->student])->One();
                          return $studentName->fullName;
                          },
                          ],
                          [
                              'attribute' => 'bookId',
                              'value' => function ($dataProvider) {
                              $studentName = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                              return $studentName->bookName;
                              },
                              ],
                              [
                                  'attribute' => 'borrowDate',
                                  'value' => function ($dataProvider) {
                                  $date = new DateTime($dataProvider->borrowDate);
                                  return $date->format('F j, Y,');
                                  },
                                  ],
                                  [
                                      'attribute' => 'Expected Return',
                                      'value' => function ($dataProvider) {
                                      $date = new DateTime($dataProvider->expectedReturn);
                                      return $date->format('F j, Y,');
                                      },
                                      ],
                                      [
                                      'attribute' => 'returnDate',
                                      'value'=>date('yy/m/d')
                                      ],

                                      [
                                          'label'=>'Return',
                                          'format' => 'raw',
                                          'value' => function ($dataProvider) {
                                            $bookStatus = Book::find()->where(['bookId'=>$dataProvider->bookId])->One();
                                            if($bookStatus->status == 1){
                                                $display = 'block';
                                                return '<span val="'.$dataProvider->bbId.'"  class="btn btn-danger returnbook">Return</span>';

                                            }
                                          return "";
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
                                                  return '<span class="btn btn-'.$btn.'">'.$status.'</span>';

                                              }elseif ($bookStatus->status == 1){
                                                $btn = 'info';
                                                  $status = 'Issued';
                                                  $display = 'none';
                                                  return '<span class="btn btn-'.$btn.'">'.$status.'</span>';

                                              }elseif ($bookStatus->status == 2){
                                                $btn = 'warning';
                                                  $status = 'Pending';
                                                  $display = 'none';
                                                  return '<span class="btn btn-'.$btn.'">'.$status.'</span>';

                                              }
                                              return "";
                                              },
                                              ],
                                              // ['class' => 'yii\grid\ActionColumn'],
                                              ],
                                              ]); ?>
  <?php }?>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
  <?php

          Modal::begin([
              'header'=>'<h4>Assign A Book</h4>',
              'id'=>'assignbook',
              'size'=>'modal-lg'
              ]);
          echo "<div id='assignbookContent'></div>";
          Modal::end();
        ?>

  <?php
        Modal::begin([
              'header'=>'<h4>Borrow Book</h4>',
              'id'=>'borrowedbook',
              'size'=>'modal-lg'
              ]);
          echo "<div id='borrowedbookContent'></div>";
          Modal::end();
        ?>

  <?php
        Modal::begin([
              'header'=>'<h4>Return Book</h4>',
              'id'=>'returnbook',
              'size'=>'modal-lg'
              ]);
          echo "<div id='returnbookContent'></div>";
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

