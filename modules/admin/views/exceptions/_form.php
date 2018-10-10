<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\helpers\Exceptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exceptions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Projects::getList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a expert ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_true')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_fall')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_fall2')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'status')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/exceptions', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
