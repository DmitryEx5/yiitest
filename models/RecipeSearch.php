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
     * @return array|ActiveRecord[]|null
     */
    public static function findByComponentIds($componentIds)
    {
        $resultFull = [];
        $resultPart = [];
        $sql = 'SELECT r.*, COUNT(c.id) as comp_count 
                    FROM recipe_component as rc
                    LEFT JOIN component as c
                    ON c.id = rc.component_id 
                    LEFT JOIN recipe as r
                    ON r.id = rc.recipe_id 
                    WHERE (component_id IN (' . implode(',', $componentIds) . '))
                    AND c.isHidden = 0 
                    GROUP BY rc.recipe_id HAVING comp_count > 1 ORDER BY comp_count DESC
         ';

        $RCactiveQuery = Recipe::findBySql($sql);
        $RCArray = $RCactiveQuery->asArray()->all();
        $RCs = $RCactiveQuery->asArray(FALSE)->all();
        foreach ($RCArray as $key =>$RC) {
            $components = RecipeComponent::find()->where(['recipe_id' => $RC['id']])->all();
            $resultPart[] = $RCs[$key];
            if ($RC['comp_count'] == count($components) && count($components) == count($componentIds)) {
                $resultFull[] = $RCs[$key];
            }
        }

        if (!empty($resultFull)) {
            return $resultFull;
        }

        if (!empty($resultPart)) {
            return $resultPart;
        }

        return NULL;
    }
}
