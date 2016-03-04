<?php
namespace app\actions\master;

use yii\base\Action;
use yii\data\ActiveDataProvider;

use app\models\RouterTable;

class Router extends Action {
	public function run()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => RouterTable::find()
		]);

		return $this->controller->render('router',['dataProvider' => $dataProvider]);		
	}
}