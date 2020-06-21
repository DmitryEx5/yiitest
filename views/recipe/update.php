<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $components array */
/* @var $selectedComponents array */
/* @var $errors array */

$this->title = 'Update Recipe: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'components' => $components,
        'selectedComponents' => $selectedComponents,
        'errors' => $errors,
    ]) ?>

</div>
