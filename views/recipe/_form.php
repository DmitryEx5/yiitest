<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $form yii\widgets\ActiveForm */
/* @var $components array */
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(['id' => 'recipe_form']); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <label class="control-label" for="components[0]">Ингредиент</label>
            <?= yii\helpers\Html::dropDownList('components[0]', NULL, $components, [
                'class' => 'form-control',
                'prompt' => 'Выберите...',
                'label' => '123',
                'id' => 'component[0]',
            ]) ?>
        </div>
        <div class="col-md-2">
            <label class="control-label" for="components[1]">Ингредиент</label>
            <?= yii\helpers\Html::dropDownList('components[1]', NULL, $components, [
                'class' => 'form-control',
                'prompt' => 'Выберите...',
                'id' => 'component[1]',
            ]) ?>
        </div>
        <div class="col-md-2">
            <label class="control-label" for="components[2]">Ингредиент</label>
            <?= yii\helpers\Html::dropDownList('components[2]', NULL, $components, [
                'class' => 'form-control',
                'prompt' => 'Выберите...',
                'id' => 'component[2]',
            ]) ?>
        </div>
        <div class="col-md-2">
            <label class="control-label" for="components[3]">Ингредиент</label>
            <?= yii\helpers\Html::dropDownList('components[3]', NULL, $components, [
                'class' => 'form-control',
                'prompt' => 'Выберите...',
                'id' => 'component[3]',
            ]) ?>
        </div>
        <div class="col-md-2">
            <label class="control-label" for="components[4]">Ингредиент</label>
            <?= yii\helpers\Html::dropDownList('components[4]', NULL, $components, [
                'class' => 'form-control',
                'prompt' => 'Выберите...',
                'id' => 'component[4]',
            ]) ?>
        </div>
    </div>

    <div class="row" id="components-error" style="display: none;">
        <div class="col-md-12">
            <div class="alert-danger text-center" style="padding: 15px"><strong>Выберите больше ингредиентов</strong></div>
        </div>
    </div>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJs(
    " 
    let selects = $('select');
    
    $('#recipe_form').on('submit', function() {
        let countSelected = 0;
        selects.each(function (index, element) {
            if ($(element).val()) {
                ++countSelected;
            }
        });
        if (countSelected < 2) {
            $('#components-error').slideDown();
            selects.each(function (index, element) {
                if (!$(element).val()) {
                    $(element).parent().addClass('has-error');
                } else {
                    $(element).parent().removeClass('has-error');
                }
            });
            
            return false;
        } else {
            $('#components-error').slideUp();
            selects.each(function (index, element) {
                $(element).parent().removeClass('has-error');
            });
        }
    });
    
    selects.on('change', function () {
        let _this = $(this).get(0);
        $('select').each(function (index, element) {
            if (element.id !== _this.id) {
                $(element).find('option').each(function (componentIndex, component) {
                    if (componentIndex === _this.selectedIndex) {
                        $(component).hide();
                    } else {
                        if (check(componentIndex, component)) {
                            $(component).show();
                        }
                    }
                });
            }
        });
    });

    function check(componentIndex, component) {
        let needShow = true;
        selects.each(function (index, element) {
            if ($(element).get(0).selectedIndex === componentIndex) {
                needShow = false;
            }
        });
        
        return needShow;
    }"
); ?>

<!--<script>-->
<!--    if (countSelected < 2) {-->
<!--        $('#components-error').slideToggle();-->
<!--        console.log($('#components-error'));-->
<!--    }-->
<!--</script>-->