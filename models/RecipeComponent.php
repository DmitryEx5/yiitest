<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recipe_component".
 *
 * @property int $recipe_id
 * @property int $component_id
 * @property string|null $created
 * @property string|null $updated
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
            [['created', 'updated'], 'safe'],
            [['recipe_id', 'component_id'], 'unique', 'targetAttribute' => ['recipe_id', 'component_id']],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['component_id' => 'id']],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * @return array|string[]
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'Recipe ID',
            'component_id' => 'Component ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRecipes()
    {
        //TODO: logic where choose some recipes to show
    }
}
