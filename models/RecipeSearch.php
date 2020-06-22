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
        $sql = 'SELECT r.* FROM recipe_component as rc
                    INNER JOIN recipe as r
                    ON rc.recipe_id = r.id 
         ';
        foreach ($componentIds as $key => $componentId) {
            unset($existsComponents[$componentId]);
        }

        if (!empty($existsComponents)) {
            $sql .= ' WHERE NOT (rc.component_id IN (' . implode(',', array_keys($existsComponents)) . ')) ';
        }
        $sqlEnd = ' GROUP BY rc.component_id HAVING COUNT(rc.component_id) = ' . count($componentIds);
        $result = Recipe::findBySql($sql . $sqlEnd)->all();

        if (!empty($result)) {
            return $result;
        }

        $sqlEnd = ' GROUP BY rc.recipe_id HAVING COUNT(rc.component_id) > 1 ORDER BY COUNT(rc.component_id) DESC';
        $result = Recipe::findBySql($sql . $sqlEnd)->all();

        if (!empty($result)) {
            return $result;
        }

        return NULL;
    }
}
