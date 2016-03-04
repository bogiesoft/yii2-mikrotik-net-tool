<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ActionForm extends Model {

    public $action;
    public $host;
    public $router;
    public $bt_protocol;
    public $bt_direction;
    public $bt_username;
    public $bt_password;
    public $bt_duration;

    public function rules() {
        return [
            [['action', 'host', 'router'], 'required'],
            [['bt_direction', 'bt_protocol'], 'required', 'when' => function($model) {
            $model->action == "bt";
        }, 'whenClient' => "function (attribute, value) {
    			return $('input[name=\"ActionForm[action]\"]:checked').val() == 'bt';
    		}"],
            [['bt_username', 'bt_password', 'bt_duration'], 'safe'],
            ['bt_duration', 'default', 'value' => 10],
            ['bt_duration', 'integer', 'min' => 10, 'max' => 30],
        ];
    }

    public function attributeLabels() {
        return [
            'bt_protocol' => 'Bandwidth Test Protocol',
            'bt_direction' => 'Bandwidth Test Direction',
            'bt_username' => 'Bandwidth Test Username',
            'bt_password' => 'Bandwidth Test Password',
            'bt_duration' => 'Bandwidth Test Duration',
        ];
    }

}
