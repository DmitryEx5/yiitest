<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property string $name
 * @property int $isHidden
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RecipeComponent[] $recipeComponents
 * @property Component[] $components
 */
class Recipe extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['isHidden'], 'integer'],
            [['name'], 'string', 'max' => 155],
            [['name'], 'unique'],
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
            'isHidden' => 'Is Hidden',
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
     * @return ActiveQuery
     */
    public function getRecipeComponents()
    {
        return $this->hasMany(RecipeComponent::class, ['recipe_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getComponents()
    {
        return $this->hasMany(Component::class, ['id' => 'component_id'])->viaTable('recipe_component', ['recipe_id' => 'id']);
    }
}
