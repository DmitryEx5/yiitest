<?php

namespace app\controllers;

use Yii;
use app\models\RecipeComponent;
use app\models\RecipeComponentSearch;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * RecipeComponentController implements the CRUD actions for RecipeComponent model.
 */
class RecipeComponentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RecipeComponent models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/recipe/index']);
    }

    /**
     * @return Response
     */
    public function actionCreate()
    {
        $model = new RecipeComponent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'component_id' => $model->component_id]);
        }

        return $this->redirect(['/recipe/view', 'id' => $model->recipe_id]);
    }

    /**
     * @param integer $recipe_id
     * @param integer $component_id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($recipe_id, $component_id)
    {
        $model = $this->findModel($recipe_id, $component_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'component_id' => $model->component_id]);
        }

        return $this->redirect(['/recipe/view', 'id' => $model->recipe_id]);
    }

    /**
     * @param integer $recipe_id
     * @param integer $component_id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($recipe_id, $component_id)
    {
        $this->findModel($recipe_id, $component_id)->delete();

        return $this->redirect(['/recipe/view', 'id' => $recipe_id]);
    }

    /**
     * Finds the RecipeComponent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $recipe_id
     * @param integer $component_id
     * @return RecipeComponent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($recipe_id, $component_id)
    {
        if (($model = RecipeComponent::findOne(['recipe_id' => $recipe_id, 'component_id' => $component_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
