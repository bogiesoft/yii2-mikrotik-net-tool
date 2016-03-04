<?php
$this->title = 'Network Tools';

use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-6">
        <div class="pull-left"><strong>Router List</strong></div>
    </div>
    <div class="col-md-6">
        <div class="pull-right"><a href="<?= Url::to(['master/router-create']) ?>" class="btn btn-primary">Create</a></div>
    </div>
</div>
<hr>
<div class="table-responsive">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'host',
            'port',
            'user',
            'pass',
            'src_address',
            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{router-update} {router-delete}',
                'buttons' => [
                    'router-update' => function($url, $model, $key) {
                        return '<a href="' . $url . '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> </a>';
                    },
                    'router-delete' => function($url, $model, $key) {
                        return '<a href="' . $url . '" class="btn btn-danger btn-xs" data-method="post" data-confirm="are you sure want to delete router ' . $model->name . '?"><span class="glyphicon glyphicon-trash"></span> </a>';
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>