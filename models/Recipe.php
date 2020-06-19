<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property string $name
 * @property int $isHidden
 *
 * @property RecipeComponent[] $recipeComponents
 * @property Component[] $components
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * Gets query for [[RecipeComponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeComponents()
    {
        return $this->hasMany(RecipeComponent::className(), ['recipe_id' => 'id']);
    }

    /**
     * Gets query for [[Components]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponents()
    {
        return $this->hasMany(Component::className(), ['id' => 'component_id'])->viaTable('recipe_component', ['recipe_id' => 'id']);
    }
}
