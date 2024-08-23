<?php

namespace common\models;
use backend\models\users\UserRoles;

class User extends \backend\models\users\Users implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {   
        if (!empty(static::findOne(['phone' => $username]))) {
            return static::findOne(['phone' => $username]);
        }else{
            return static::findOne(['email' => $username]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    public static function getTypes($id){
        return UserRoles::find()->join('LEFT JOIN', 'roles', 'roles.id = user_roles.role_id')->where(['user_id' => $id])->andWhere(['roles.admin_access' => 1])->asArray()->all();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       return \Yii::$app->security->validatePassword($password, $this->password);
    }
}
