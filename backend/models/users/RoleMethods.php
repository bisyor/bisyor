<?php

namespace backend\models\users;

use Yii;
use backend\models\users\Roles;
use backend\models\users\UserRoles;
use backend\models\users\Users;

/**
 * This is the model class for table "role_methods".
 *
 * @property int $id
 * @property int|null $role_id Роль
 * @property int|null $method_id Метод
 * @property int|null $value Значение
 *
 * @property ModuleMethods $method
 * @property Roles $role
 */
class RoleMethods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_methods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'method_id', 'value'], 'default', 'value' => null],
            [['role_id', 'method_id', 'value'], 'integer'],
            [['method_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModuleMethods::className(), 'targetAttribute' => ['method_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'method_id' => 'Method ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Method]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMethod()
    {
        return $this->hasOne(ModuleMethods::className(), ['id' => 'method_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }


    /**
     * userni rollarini olish
     * @return array|string|null
     */
    public static  function getUsersRole()
    {
        $user = Yii::$app->user->identity;
        if($user == null) return null;
        $results = [];
        $user_id = $user->id;
        $users_roles = (new \yii\db\Query())
                        ->select(['user_roles.role_id'])
                        ->from('user_roles')
                        ->where(['user_id' => $user_id ])
                        ->all();
        $results = $users_roles != null ? array_column($users_roles , 'role_id') : "";
        return $results;
    }


    /**
     * roleni tekshirish
     * @param $roles
     * @param $table
     * @param $value
     * @return int
     */
    public static  function getAccess($roles , $table , $value)
    {   
        // $roles = self::getUsersRole();
        $methods = RoleMethods::find()->join("LEFT JOIN", "module_methods", 'role_methods.method_id = module_methods.id')
            ->select(['role_methods.id', 'module_methods.title', 'module_methods.module',  'module_methods.method', 'role_methods.value'])
            ->where(['role_id' => $roles])
            ->andWhere(['module_methods.module' => $table])
            ->andWhere(['module_methods.method' => $value])
            ->one();
        if($methods != null) {
            return $methods['value'] == 1 ? 0 : 1;
        }
        else {
            return 0;
        }
    }

    public static  function getAccessAll($roles)
    {
        $methods = RoleMethods::find()->join("LEFT JOIN", "module_methods", 'role_methods.method_id = module_methods.id')
            ->select(['module_methods.module',  'module_methods.method'])
            ->andWhere(['role_id' => $roles,'value'=>1])
            ->asArray()->all();

        return $methods;
    }
}
