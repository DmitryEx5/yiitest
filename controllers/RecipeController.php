<?php

namespace app\controllers;

use app\models\ComponentSearch;
use app\models\RecipeComponent;
use Yii;
use app\models\Recipe;
use app\models\RecipeSearch;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends Controller
{
    /**
     * @return array|array[]
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
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RecipeSearch();

        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'components' => $components,
        ]);
    }

    /**
     * Displays a single Recipe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recipe();

        if (!empty($post = Yii::$app->request->post())) {
            $postComponentIds = $post['components'];
            unset($post['components']);

            if ($model->load($post) && $model->save()) {
                foreach ($postComponentIds as $componentId) {
                    $modelRecipeComponent = new RecipeComponent();
                    $modelRecipeComponent->recipe_id = $model->id;
                    $modelRecipeComponent->component_id = $componentId;
                    $modelRecipeComponent->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        return $this->render('create', [
            'model' => $model,
            'components' => $components
        ]);
    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException|\Throwable
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
