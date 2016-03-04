<?php
$this->title = 'Network Tools';

use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-6">
        <div class="pull-left"><strong>User List</strong></div>
    </div>
    <div class="col-md-6">
        <div class="pull-right"><a href="<?= Url::to(['master/user-create']) ?>" class="btn btn-primary">Create</a></div>
    </div>
</div>
<hr>
<?php if(\Yii::$app->session->hasFlash('success')):?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?= \Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif;?>
<?php if(\Yii::$app->session->hasFlash('info')):?>
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?= \Yii::$app->session->getFlash('info'); ?>
</div>
<?php endif;?>
<div class="table-responsive">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'privileges',
                'class' => 'yii\grid\DataColumn',
                'format' => 'html',
                'value' => function($data){
                    return $data->privileges == "0" ? "<span class='label label-danger'>admin</span>" : "<span class='label label-success'>user</span>";
                }
            ],
            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{user-update} {user-delete}',
                'buttons' => [
                    'user-update' => function($url, $model, $key) {
                        return '<a href="' . $url . '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> </a>';
                    },
                    'user-delete' => function($url, $model, $key) {
                        return '<a href="' . $url . '" class="btn btn-danger btn-xs" data-method="post" data-confirm="are you sure want to delete user ' . $model->username . '?"><span class="glyphicon glyphicon-trash"></span> </a>';
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>