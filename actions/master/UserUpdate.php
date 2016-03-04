<?php

namespace app\actions\master;

use yii\base\Action;
use app\models\UserTable;

class UserUpdate extends Action {

    public function run($id) {
        $baseModel = new UserTable();
        
        $model = $baseModel->getData($id);
        $model->scenario = 'update';

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->passwordUpdate != null)
            {
                $model->password = \Yii::$app->security->generatePasswordHash($model->passwordUpdate);
            }
            if ($model->update(false)) {
                \Yii::$app->session->setFlash('success', 'User has been updated.');
                return $this->controller->redirect(['user']);
            } else {
                \Yii::$app->session->setFlash('info', 'Nothing update.');
                return $this->controller->redirect(['user']);
            }
        }

        return $this->controller->render('user-update', ['model' => $model]);
    }

}
