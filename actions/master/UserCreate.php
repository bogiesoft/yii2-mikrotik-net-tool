<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\UserTable;

class UserCreate extends Action {

    public function run() {
        $baseModel = new UserTable();
        $model->scenario = 'create';

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'New user has been added.');
                return $this->controller->redirect(['user']);
            }
        }

        return $this->controller->render('user-create', ['model' => $model]);
    }

}
