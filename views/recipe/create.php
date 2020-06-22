<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $components array */
/* @var $errors array */

$this->title = 'Создать блюдо';
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'components' => $components,
        'selectedComponents' => [],
        'errors' => $errors,
    ]) ?>

</div>
