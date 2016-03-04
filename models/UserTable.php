<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IndentityInterface;

class UserTable extends ActiveRecord implements IndentityInterface {

	public static function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return [

		];
	}


	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	public function getId()
	{         return $this->id;
	}

	public function getAuthKey()
	{
		return $this->authKey;
	}

	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}
	
}