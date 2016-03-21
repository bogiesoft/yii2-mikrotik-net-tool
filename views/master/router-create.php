<?php
$this->title = 'Network Tools';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2>Create New Router</h2>
        <hr>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'name') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'host') ?></div>
        </div>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'user') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'pass') ?></div>
        </div>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'port') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'src_address') ?></div>
        </div>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'host_graph',['inputOptions' => ['class' => 'form-control','onChange' => 'getInterfaceGraph(this.value)']])->dropDownList($getHostGraph,['prompt' => '**select host graph**']) ?></div>
        </div>
        <div class="row">
            <div class="col-md-12"><?= $form->field($model, 'rra_graph',['inputOptions' =>['class' => 'form-control','placeholder' => 'If you add more than one rra, please separate with comas']])->label('RRA Graph')?></div>
        </div>
        <div class="text-center">
            <?= Html::submitButton('create', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>