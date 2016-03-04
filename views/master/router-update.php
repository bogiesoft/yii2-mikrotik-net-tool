<?php
$this->title = 'Network Tools';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2>Update Router</h2>
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
        <div class="text-center">
            <?= Html::submitButton('update', ['class' => 'btn btn-warning']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>