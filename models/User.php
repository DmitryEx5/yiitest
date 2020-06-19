<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $role
 * @property string|null $created
 * @property string|null $updated
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['name', 'password'], 'required'],
            [['name', 'password', 'role'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array|string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'password' => 'Password',
            'role' => 'Role',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['name' => $username]);
    }

    /**
     * @param $password
     */
    public function validatePassword($password)
    {
    }

    /**
     * @param int|string $id
     * @return void|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @return int|string|void
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @return string|void
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

}
