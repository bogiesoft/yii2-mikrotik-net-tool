<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\UserTable;

class UserDelete extends Action {

    public function run($id) {
        $baseModel = new UserTable();
        $model = $baseModel->getData($id);

        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'User has been deleted.');
            return $this->controller->redirect(['user']);
        }
    }

}
