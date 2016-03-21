<h3 class="text-center">Graph Traffic</h3>
<hr>
<?php foreach ($graphs as $graph) : ?>
	<div class="img-graph">
		<img class="img-responsive center-block" src="<?= \yii\helpers\Url::to(['ajax/render-graph','graph' => $graph,'time' => time()],true) ?>"/>
	</div>
<?php endforeach; ?>