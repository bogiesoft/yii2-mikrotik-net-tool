<?php

namespace app\actions\master;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use app\models\UserTable;

class User extends Action {

    public function run() {
        $dataProvider = new ActiveDataProvider([
            'query' => UserTable::find()
        ]);

        return $this->controller->render('user', ['dataProvider' => $dataProvider]);
    }

}
