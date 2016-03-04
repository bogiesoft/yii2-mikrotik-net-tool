<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserTable extends ActiveRecord implements IdentityInterface {

	public $passwordUpdate;

	public static function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return [
			[['username','password','privileges'],'required','on' => 'create'],
			[['username','privileges'],'required','on' => 'update'],
			['passwordUpdate', 'safe'],
			['username','unique']
		];
	}

	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = \Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    public function getData($id) {
        $model = self::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Not found');
        } else {
            return $model;
        }
    }

	public static function findByUsername($username)
	{
		$user = self::findOne(['username' => $username]);

		return $user;
	}

	public function validatePassword($password,$hash)
	{
		return \Yii::$app->getSecurity()->validatePassword($password,$hash);
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