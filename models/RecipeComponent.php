<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "recipe_component".
 *
 * @property int $recipe_id
 * @property int $component_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Component $component
 * @property Recipe $recipe
 */
class RecipeComponent extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'recipe_component';
    }

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['recipe_id', 'component_id'], 'required'],
            [['recipe_id', 'component_id'], 'integer'],
            [['recipe_id', 'component_id'], 'unique', 'targetAttribute' => ['recipe_id', 'component_id']],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::class, 'targetAttribute' => ['component_id' => 'id']],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::class, 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @return array|string[]
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'id Рецепта',
            'component_id' => 'id Ингредиента',
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
    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'component_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::class, ['id' => 'recipe_id']);
    }

}
