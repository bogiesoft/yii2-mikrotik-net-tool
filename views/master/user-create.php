<?php
$this->title = 'Network Tools';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2>Create New User</h2>
        <hr>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'username') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'password')->passwordInput() ?></div>
        </div>
        <div class="row">
            <div class="col-md-12"><?= $form->field($model, 'privileges')->radioList(['0' => 'admin','1'=>'user']) ?></div>
        </div>
        <div class="text-center">
            <?= Html::submitButton('create', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>