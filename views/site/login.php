<?php
$this->title = 'Network Tools';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div id="login-wrap" class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default panel-tranparent">
            <div class="panel-heading">
                <div class="text-center"><strong>Log In</strong></div>
            </div>
            <div class="panel-body panel-tranparent" style="padding-bottom: 30px;">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control input-lg input-login', 'placeholder' => 'Username']])->label(false) ?>
                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control input-lg input-login', 'placeholder' => 'Password']])->passwordInput()->label(false) ?>
                <?= Html::submitButton('Log In', ['class' => 'btn btn-success btn-lg btn-block btn-login']); ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="panel-footer"><div class="text-center">&copy; Network Tools <?= date('Y') ?></div></div>
        </div>
    </div>
</div>