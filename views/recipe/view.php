<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $components array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="recipe-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'isHidden',
            'created_at',
            'updated_at',
            [
                'label' => 'Ингредиент 1',
                'format' => 'text',
                'value' => function () use ($components) {
                    return isset($components[0])
                        ? $components[0]
                        : '-';
                }
            ],
            [
                'label' => 'Ингредиент 2',
                'format' => 'text',
                'value' => function () use ($components) {
                    return isset($components[1])
                        ? $components[1]
                        : '-';
                }
            ],
            [
                'label' => 'Ингредиент 3',
                'format' => 'text',
                'value' => function () use ($components) {
                    return isset($components[2])
                        ? $components[2]
                        : '-';
                }
            ],
            [
                'label' => 'Ингредиент 4',
                'format' => 'text',
                'value' => function () use ($components) {
                    return isset($components[3])
                        ? $components[3]
                        : '-';
                }
            ],
            [
                'label' => 'Ингредиент 5',
                'format' => 'text',
                'value' => function () use ($components) {
                    return isset($components[4])
                        ? $components[4]
                        : '-';
                }
            ],
        ],
    ]) ?>

</div>
