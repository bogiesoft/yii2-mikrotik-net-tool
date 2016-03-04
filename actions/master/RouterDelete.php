<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\RouterTable;

class RouterDelete extends Action {

    public function run($id) {
        $baseModel = new RouterTable();
        $model = $baseModel->getData($id);

        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Router has been deleted.');
            return $this->controller->redirect(['router']);
        }
    }

}
