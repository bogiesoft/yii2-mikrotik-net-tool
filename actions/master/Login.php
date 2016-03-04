<?php
namespace app\actions\master;

use yii\base\Action;

use app\models\LoginForm;

class Login extends Action {
	public function run()
	{

		if(!\Yii::$app->user->isGuest){
			return $this->controller->redirect(['router']);
		}else{
			$this->controller->layout = 'login';

			$model = new LoginForm();

			if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            	return $this->controller->redirect(['router']);
        	}

			return $this->controller->render('login',['model' => $model]);
		}
		
	}
}