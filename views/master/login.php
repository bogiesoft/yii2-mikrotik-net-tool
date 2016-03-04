<?php
$this->title = 'Network Tools';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div id="login-wrap" class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-body" style="padding-bottom: 30px;">
				<div class="text-center"><h2>Log In</h2></div>
				<hr>
				<?php $form = ActiveForm::begin();?>
				<?= $form->field($model,'username',['inputOptions' => ['class' => 'form-control input-lg input-login','placeholder' => 'Username']])->label(false) ?>
				<?= $form->field($model,'password',['inputOptions' => ['class' => 'form-control input-lg input-login','placeholder' => 'Password']])->passwordInput()->label(false) ?>
				<?= Html::submitButton('Log In',['class' =>  'btn btn-success btn-lg btn-block btn-login']);?>
				<?php ActiveForm::end();?>
				<hr>
			</div>
		</div>
	</div>
</div>