<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatingData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="graduation-rating-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'graduation_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\GraduationRatings::getList(),
        'hideSearch' => true,
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],
        'disabled' => true,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'score')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/graduation-ratings', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
