<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "component".
 *
 * @property int $id
 * @property string $name
 * @property int $isHidden
 * @property string $created
 * @property string $updated
 *
 * @property RecipeComponent[] $recipeComponents
 * @property Recipe[] $recipes
 */
class Component extends \yii\db\ActiveRecord
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
            [['name', 'created', 'updated'], 'required'],
            [['isHidden'], 'integer'],
            [['created', 'updated'], 'safe'],
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
            'isHidden' => 'Is Hidden',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeComponents()
    {
        return $this->hasMany(RecipeComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('recipe_component', ['component_id' => 'id']);
    }
}
