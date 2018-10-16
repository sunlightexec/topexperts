<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatings */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="graduation-ratings-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => \app\models\helpers\GraduationRatings::getListType(),
        'hideSearch' => true,
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],
        'disabled' => $model->getProjectDatas()->count() > 0 ? true : false,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_star')->textInput() ?>

    <?= $form->field($model, 'max_value')->textInput() ?>

    <?= $form->field($model, 'arrAllowed')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Experts::getListOfNames(),
//        'language' => 'de',
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select a experts ...',
            'value' => $model->arrAllowed
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/graduation-ratings', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
