<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $componentColumns array */

$this->title = 'Список блюд';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новое блюдо', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
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
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
