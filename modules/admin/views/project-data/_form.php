<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Projects::getList(),
        'hideSearch' => true,
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],
//        'disabled' => true,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'expert_id')->textInput() ?>

<!--    --><?//= $form->field($model, 'Report_Date')->textInput() ?>

    <?= $form->field($model, 'graduation_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\GraduationRatings::getList(),
        'hideSearch' => true,
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],
        'disabled' => $model->isNewRecord ? false : true,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?php if(!$model->isNewRecord):?>
        <?php if($model->getGraduation()->one()->type == 1):?>
            <?= $form->field($model, 'Score')->widget(Select2::classname(), [
                'data' => \app\models\helpers\GraduationRatingData::getValues($model->graduation_id),
                'hideSearch' => true,
//        'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a type ...',
                ],
//                'disabled' => $model->isNewRecord ? false : true,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        <?php else:?>
            <?= $form->field($model, 'Score')->textInput(['maxlength' => true]) ?>
        <?php endif;?>
    <?php else:?>
        <?= $form->field($model, 'Score')->textInput(['maxlength' => true]) ?>
    <?php endif?>
    <?= $form->field($model, 'flip')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'hold')->textInput(['disabled' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/projects', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
