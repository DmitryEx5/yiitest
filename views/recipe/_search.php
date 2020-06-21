<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $components array */
?>

<div class="recipe-search">

    <?php
    $styleDDL = 'width:19%; margin-right: 1%; float:left;';
    $styleLastDDL = 'width:20%; float:left;';
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-five">
            <?= yii\helpers\Html::dropDownList('components[0]', NULL, $components, ['class' => 'form-control', 'prompt' => 'Выберите ингредиент']) ?>
        </div>
        <div class="col-md-five">
            <?= yii\helpers\Html::dropDownList('components[1]', NULL, $components, ['class' => 'form-control', 'prompt' => 'Выберите ингредиент']) ?>
        </div>
        <div class="col-md-five">
            <?= yii\helpers\Html::dropDownList('components[2]', NULL, $components, ['class' => 'form-control', 'prompt' => 'Выберите ингредиент']) ?>
        </div>
        <div class="col-md-five">
            <?= yii\helpers\Html::dropDownList('components[3]', NULL, $components, ['class' => 'form-control', 'prompt' => 'Выберите ингредиент']) ?>
        </div>
        <div class="col-md-five">
            <?= yii\helpers\Html::dropDownList('components[4]', NULL, $components, ['class' => 'form-control', 'prompt' => 'Выберите ингредиент']) ?>
        </div>
    </div>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
