<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $components array */
/* @var $errors array */
/* @var $foundRecipes array */
/* @var $selectedComponents array */
/* @var $componentColumns array */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поиск блюд';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/site/search-form', [
        'model' => $model,
        'components' => $components,
        'selectedComponents' => $selectedComponents,
        'errors' => $errors,
    ]) ?>

    <?= isset($errors['notFoundRecipes'])
        ? Html::tag('div', '<strong>Ничего не найдено</strong>', ['class' => 'alert-danger text-center', 'style' => 'padding:15px'])
        : '' ?>

    <?php if (!empty($foundRecipes) && $dataProvider !== NULL) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => NULL,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                [
                    'label' => 'Ингредиент 1',
                    'format' => 'text',
                    'value' => function ($data) use ($componentColumns) {
                        return $componentColumns[$data->id][0];
                    }
                ],
                [
                    'label' => 'Ингредиент 2',
                    'format' => 'text',
                    'value' => function ($data) use ($componentColumns) {
                        return $componentColumns[$data->id][1];
                    }
                ],
                [
                    'label' => 'Ингредиент 3',
                    'format' => 'text',
                    'value' => function ($data) use ($componentColumns) {
                        return $componentColumns[$data->id][2];
                    }
                ],
                [
                    'label' => 'Ингредиент 4',
                    'format' => 'text',
                    'value' => function ($data) use ($componentColumns) {
                        return $componentColumns[$data->id][3];
                    }
                ],
                [
                    'label' => 'Ингредиент 5',
                    'format' => 'text',
                    'value' => function ($data) use ($componentColumns) {
                        return $componentColumns[$data->id][4];
                    }
                ]
            ],
        ]);
    } ?>

</div>
