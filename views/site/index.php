<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $components array */
/* @var $errors array */
/* @var $foundRecipes array */

$this->title = 'Поиск блюд';
$this->params['breadcrumbs'][] = $this->title;
?>



<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/site/search-form', [
        'model' => $model,
        'components' => $components,
        'selectedComponents' => [],
        'errors' => $errors,
    ]) ?>

    <?= isset($errors['notFoundRecipes'])
        ? Html::tag('div', '<strong>Ничего не найдено</strong>', ['class' => 'alert-danger text-center', 'style' => 'padding:15px'])
        : '' ?>

</div>
