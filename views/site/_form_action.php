<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h2 class="text-center">Network Tools</h2>
<?php $form =  ActiveForm::begin(['id' => 'runAction','action' => ['site/execute'],]);?>
<?= $form->field($model,'host',['inputOptions' => ['class' => 'form-control','placeholder' => 'Host']])->label(false) ?>
<div class="row">
	<div class="col-md-6"><?= $form->field($model,'action')->radioList(['ping' => 'Ping', 'traceroute' => 'Traceroute' ,'bt' => 'Bandwidth Test'])->label("Select Action") ?></div>
	<div class="col-md-6"><?= $form->field($model,'router')->radioList(\app\models\RouterTable::getList())->label("Select Router") ?></div>
</div>
<div id="btWrap">
	<div class="row">
		<div class="col-md-6"><?= $form->field($model,'bt_protocol')->radioList(['udp' => 'UDP', 'tcp' => 'TCP'])?></div>
		<div class="col-md-6"><?= $form->field($model,'bt_direction')->radioList(['transmit' => 'TX', 'receive' => 'RX','both' => 'BOTH'])?></div>
	</div>
	<div class="row">
		<div class="col-md-6"><?= $form->field($model,'bt_username',['inputOptions' => ['class' => 'form-control','placeholder' => 'Bandwidth Test Username']]) ?></div>
		<div class="col-md-6"><?= $form->field($model,'bt_password',['inputOptions' => ['class' => 'form-control','placeholder' => 'Bandwidth Test Password']]) ?></div>
	</div>
	<div class="row">
		<div class="col-md-6"><?= $form->field($model,'bt_duration',['inputOptions' => ['class' => 'form-control','placeholder' => 'Bandwidth Test Duration : default = 10 , max = 30']])->label('Bandwidth Test Duration (second)') ?></div>
	</div>
</div>
<div class="text-center">
	<?= Html::submitButton('submit', ['id' => 'actionSubmit','class' => 'btn btn-primary']); ?>
</div>
<?php ActiveForm::end(); ?>