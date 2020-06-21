<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecipeComponent;

/**
 * RecipeComponentSearch represents the model behind the search form of `app\models\RecipeComponent`.
 */
class RecipeComponentSearch extends RecipeComponent
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RecipeComponent::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'recipe_id' => $this->recipe_id,
            'component_id' => $this->component_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
