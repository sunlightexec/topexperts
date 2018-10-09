<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Experts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="experts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'old_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'spreadsheet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address[facebook]')->textInput(['maxlength' => true])->label('facebook'); ?>
    <?= $form->field($model, 'address[twitter]')->textInput(['maxlength' => true])->label('twitter'); ?>
    <?= $form->field($model, 'address[youtube]')->textInput(['maxlength' => true])->label('youtube'); ?>
    <?= $form->field($model, 'address[tg_chat]')->textInput(['maxlength' => true])->label('tg_chat'); ?>
    <?= $form->field($model, 'address[tg_group]')->textInput(['maxlength' => true])->label('tg_group'); ?>
    <?= $form->field($model, 'address[discord]')->textInput(['maxlength' => true])->label('discord'); ?>
    <?= $form->field($model, 'address[reddit]')->textInput(['maxlength' => true])->label('reddit'); ?>
    <?= $form->field($model, 'address[medium]')->textInput(['maxlength' => true])->label('medium'); ?>
    <?= $form->field($model, 'address[bitcointalk_forum]')->textInput(['maxlength' => true])->label('bitcointalk_forum'); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subscribe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/experts', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
