<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class RouterTable extends ActiveRecord {

    public static function tableName() {
        return 'router';
    }

    public function rules() {
        return [
            [['host', 'port', 'user', 'name', 'src_address'], 'required'],
            [['pass'], 'safe'],
        ];
    }

    public function getData($id) {
        $model = self::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Not found');
        } else {
            return $model;
        }
    }

    public static function getList($arrayHelper = true) {
        $model = self::find();

        if ($arrayHelper) {
            return ArrayHelper::map($model->all(), 'id', 'name');
        } else {
            return $model->all();
        }
    }

}
