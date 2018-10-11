<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\HystoricalData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hystorical-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currency_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Currencies::getList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a currency ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'circulating_supply')->textInput() ?>

    <?= $form->field($model, 'total_supply')->textInput() ?>

    <?= $form->field($model, 'max_supply')->textInput() ?>

<!--    --><?//= $form->field($model, 'date_added')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'volume_24h')->textInput() ?>

    <?= $form->field($model, 'market_cap')->textInput() ?>

<!--    --><?//= $form->field($model, 'status')->textInput() ?>

<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>

<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/hystirical-data', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
