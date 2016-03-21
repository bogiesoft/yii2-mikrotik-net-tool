<?php
namespace app\models\cacti;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class HostTable extends ActiveRecord{

	public static function getDb()
	{
		return \Yii::$app->dbCacti;
	}

	public static function tableName()
	{
		return 'host';
	}

	public static function fetchHost()
	{
		$query = self::find()->where(['!=','id',1])->asArray()->all();

		return ArrayHelper::map($query,'description','description');
	}
}