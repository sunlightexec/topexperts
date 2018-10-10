<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ProjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ICO_NAME') ?>

    <?= $form->field($model, 'ICO_Website') ?>

    <?= $form->field($model, 'ICO_Description') ?>

    <?= $form->field($model, 'URL_Coinmarketcap') ?>

    <?php // echo $form->field($model, 'URL_ICODrops') ?>

    <?php // echo $form->field($model, 'Category') ?>

    <?php // echo $form->field($model, 'HARD_CAP') ?>

    <?php // echo $form->field($model, 'Currency_HARD_CAP') ?>

    <?php // echo $form->field($model, 'ICO_Price') ?>

    <?php // echo $form->field($model, 'Currency_ICO_Price') ?>

    <?php // echo $form->field($model, 'START_ICO') ?>

    <?php // echo $form->field($model, 'END_ICO') ?>

    <?php // echo $form->field($model, 'Scam') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/projects', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app/projects', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
