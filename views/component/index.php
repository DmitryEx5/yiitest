<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComponentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Components';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Component', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'isHidden',
            ['attribute' => 'created_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
            ['attribute' => 'updated_at', 'format' => ['date', 'php:Y-m-d H:i:s']],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
