<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "component".
 *
 * @property int $id
 * @property string $name
 * @property int $isHidden
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RecipeComponent[] $recipeComponents
 * @property Recipe[] $recipes
 */
class Component extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'component';
    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['isHidden'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'isHidden' => 'Is Hidden'
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function(){
                    return gmdate("Y-m-d H:i:s");
                },
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getRecipeComponents()
    {
        return $this->hasMany(RecipeComponent::class, ['component_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::class, ['id' => 'recipe_id'])->viaTable('recipe_component', ['component_id' => 'id']);
    }
}
