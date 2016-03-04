<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MasterController extends Controller {

    public $defaultAction = 'router';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['router', 'router-create', 'router-update', 'router-delete', 'logout'],
                'rules' => [
                    [
                        'actions' => ['router', 'router-create', 'router-update', 'router-delete', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'router-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'router' => 'app\actions\master\Router',
            'router-create' => 'app\actions\master\RouterCreate',
            'router-update' => 'app\actions\master\RouterUpdate',
            'router-delete' => 'app\actions\master\RouterDelete',
        ];
    }

}
