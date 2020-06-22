<?php

namespace app\controllers;

use app\models\Component;
use app\models\ComponentSearch;
use app\models\RecipeComponent;
use Yii;
use app\models\Recipe;
use app\models\RecipeSearch;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $searchModel = new RecipeSearch();

        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $componentColumns = [];
        if (!empty($recipes = $dataProvider->models)) {
            foreach ($recipes as $recipe) {
                $_components = $recipe->getComponentsAsArray();
                for ($i = 0; $i <= 4; $i++) {
                    $componentColumns[$recipe->id][$i] = isset($_components[$i])
                        ? $_components[$i]->name
                        : '-';
                }

            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'componentColumns' => $componentColumns,
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
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'components' => $this->findComponents($id, TRUE),
        ]);
    }

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = new Recipe();
        $errors = [];

        if (!empty($post = Yii::$app->request->post())) {
            $postComponentIds = $post['components'];
            unset($post['components']);

            if (count($postComponentIds) > 1) {
                if ($model->load($post) && $model->save()) {
                    foreach ($postComponentIds as $componentId) {
                        if (!empty($componentId)) {
                            $modelRecipeComponent = new RecipeComponent();
                            $modelRecipeComponent->recipe_id = $model->id;
                            $modelRecipeComponent->component_id = $componentId;
                            $modelRecipeComponent->save();
                        }
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors['notEnoughComponents'] = 1;
            }
        }

        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        return $this->render('create', [
            'model' => $model,
            'components' => $components,
            'errors' => $errors,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $model = $this->findModel($id);
        $errors = [];

        if (!empty($post = Yii::$app->request->post())) {
            $postComponentIds = $post['components'];
            unset($post['components']);

            if (count($postComponentIds) > 1) {
                if ($model->load($post) && $model->save()) {
                    /** @var RecipeComponent[] $existsRC */
                    $existsRC = $model->getRecipeComponents()->all();
                    foreach ($existsRC as $modelRC) {
                        $modelRC->delete();
                    }
                    foreach ($postComponentIds as $key => $componentId) {
                        if (!empty($componentId)) {
                            $modelRecipeComponent = new RecipeComponent();
                            $modelRecipeComponent->recipe_id = $model->id;
                            $modelRecipeComponent->component_id = $componentId;
                            $modelRecipeComponent->save();
                        }
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors['notEnoughComponents'] = 1;
            }
        }

        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        $selectedComponents = [];
        foreach ($this->findComponents($id, FALSE) as $key => $component) {
            $selectedComponents[] = $component->id;
        }

        return $this->render('update', [
            'model' => $model,
            'components' => $components,
            'selectedComponents' => $selectedComponents,
            'errors' => $errors
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
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $this->findModel($id)->delete();
        foreach (RecipeComponent::findAll(['recipe_id' => $id]) as $rcModel) {
            $rcModel->delete();
        }

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

    /**
     * @param integer $id
     * @param bool $asArray
     * @return Component[]|array
     * @throws NotFoundHttpException
     */
    protected function findComponents($id, $asArray)
    {
        $rcArray = RecipeComponent::findAll(['recipe_id' => $id]);
        $components = [];
        if (!empty($rcArray)) {
            foreach ($rcArray as $recipeComponent) {
                $component = Component::findOne($recipeComponent->component_id);
                if ($asArray) {
                    $components[] = $component->name;
                } else {
                    $components[] = $component;
                }
            }

            return $components;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
