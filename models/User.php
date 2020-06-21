<?php

namespace app\models;

use yii\base\Exception;
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
     * @var mixed|null
     */
    private $auth_key = '4342asdasd';

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
            'name' => 'Имя',
            'password' => 'Пароль',
            'role' => 'Роль',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
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
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function validatePassword($user, $password)
    {
        return $user->password === $password;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return User|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed|string|null
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}
