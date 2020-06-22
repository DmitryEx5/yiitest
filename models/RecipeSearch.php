<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * RecipeSearch represents the model behind the search form of `app\models\Recipe`.
 */
class RecipeSearch extends Recipe
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id', 'isHidden'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = Recipe::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'isHidden' => $this->isHidden,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    /**
     * @param array $componentIds
     * @param array $existsComponents
     * @return array|ActiveRecord[]|null
     */
    public static function findByComponentIds($componentIds, $existsComponents)
    {
        $sql = 'SELECT * FROM `recipe` WHERE id IN 
                    (SELECT recipe_id FROM `recipe_component`';
        foreach ($componentIds as $key => $componentId) {
            $sql .= $key === 0 ? " WHERE " : " OR ";
            $sql .= 'component_id = ' . $componentId;

            unset($existsComponents[$componentId]);
        }
        if (!empty($existsComponents)) {
            foreach ($existsComponents as $id => $component) {
                $sql .= ' AND component_id != ' . $id;
            }
        }
        $sqlEnd = ' GROUP BY recipe_id HAVING COUNT(recipe_id) = ' . count($componentIds) . ')';
        $result = Recipe::findBySql($sql . $sqlEnd)->all();

        if (!empty($result)) {
            return $result;
        }

        $sqlEnd = ' GROUP BY recipe_id HAVING COUNT(recipe_id) > 1 ORDER BY COUNT(recipe_id) DESC)';
        $result = Recipe::findBySql($sql . $sqlEnd)->all();

        if (!empty($result)) {
            return $result;
        }

        return NULL;
    }
}
