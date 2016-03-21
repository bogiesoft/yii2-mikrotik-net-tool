<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\RouterTable;
use app\models\cacti\HostTable;

class RouterUpdate extends Action {

    public function run($id) {
        $baseModel = new RouterTable();

        $model = $baseModel->getData($id);

        $getHostGraph = HostTable::fetchHost();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->update()) {
                \Yii::$app->session->setFlash('success', 'Router data has been updated.');
                return $this->controller->redirect(['router']);
            } else {
                \Yii::$app->session->setFlash('info', 'Nothing update.');
                return $this->controller->redirect(['router']);
            }
        }

        return $this->controller->render('router-update', ['model' => $model,'getHostGraph' => $getHostGraph]);
    }

}
