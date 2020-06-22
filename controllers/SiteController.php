<?php

namespace app\controllers;

use app\models\Component;
use app\models\ComponentSearch;
use app\models\Recipe;
use app\models\RecipeSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new Recipe();
        $errors = [];
        $foundRecipes = [];
        $selectedComponents = [];
        $componentColumns = [];
        $dataProvider = NULL;

        /** @var array|Component[] $components */
        $components = [];
        $componentModels = (new ComponentSearch())->search([])->models;
        foreach ($componentModels as $componentModel) {
            $components[$componentModel->id] = $componentModel->name;
        }

        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $selectedComponents = $post['components'];
            foreach ($selectedComponents as $key => $componentId) {
                if (empty($componentId)) {
                    unset($selectedComponents[$key]);
                }
            }
            if (count($selectedComponents) < 2) {
                $errors['notEnoughComponents'] = 1;
            } else {
                $foundRecipes = RecipeSearch::findByComponentIds($selectedComponents);
                if (empty($foundRecipes)) {
                    $errors['notFoundRecipes'] = 1;
                } else {
                    foreach ($foundRecipes as $key => $recipe) {
                        $_components = $recipe->getComponentsAsArray();
                        for ($i = 0; $i <= 4; $i++) {
                            if (isset($_components[$i])) {
                                if ($_components[$i]->isHidden == 1) {
                                    unset($foundRecipes[$key]);
                                }
                                $componentColumns[$recipe->id][$i] = $_components[$i]->name;
                            } else {
                                $componentColumns[$recipe->id][$i] = '-';
                            }
                        }
                    }
                    $dataProvider = new ArrayDataProvider(
                        [
                            'allModels' => $foundRecipes,
                            'pagination' => [
                                'pageSize' => 10,
                            ],
                            'sort' => [
                                'attributes' => ['id', 'name'],
                            ],
                        ]
                    );
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'components' => $components,
            'errors' => $errors,
            'foundRecipes' => $foundRecipes,
            'selectedComponents' => $selectedComponents,
            'componentColumns' => $componentColumns,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
