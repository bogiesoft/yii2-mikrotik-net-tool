<?php
namespace app\assets;
use yii\web\AssetBundle;

class ChartistAsset extends AssetBundle
{
    public $sourcePath = '@bower/chartist/dist';
    public $css = [
       'chartist.css'
    ];
    public $js = [
        'chartist.js',
    ];
    public $depends = [
    ];
}