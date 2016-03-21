<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\RouterTable;
use app\models\cacti\HostTable;

class RouterCreate extends Action {

    public function run() {
        $model = new RouterTable();

        $getHostGraph = HostTable::fetchHost();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'New router has been added.');
                return $this->controller->redirect(['router']);
            }
        }

        return $this->controller->render('router-create', ['model' => $model ,'getHostGraph' => $getHostGraph]);
    }

}
