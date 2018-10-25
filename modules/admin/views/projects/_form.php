<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICO_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ICO_Website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ICO_Description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'URL_Coinmarketcap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'URL_ICODrops')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Category')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Categories::getList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a category ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'HARD_CAP')->textInput() ?>

    <?= $form->field($model, 'Currency_HARD_CAP')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Currencies::getList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a currency ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'ICO_Price')->textInput() ?>

    <?= $form->field($model, 'Currency_ICO_Price')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Currencies::getList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a currency ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'START_ICO')->widget(DatePicker::classname(), [
        'name' => 'check_issue_date',
        'value' => $model->START_ICO /*== 0 ? '' : date('Y-m-d', $model->START_ICO)*/,
        'options' => ['placeholder' => 'Select issue date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'END_ICO')->widget(DatePicker::classname(), [
        'name' => 'check_issue_date',
        'value' => $model->END_ICO/*date('Y-m-d', $model->END_ICO)*/,
        'options' => ['placeholder' => 'Select issue date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'Scam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => \app\models\BaseModel::getStatusList(),
        'language' => 'de',
        'options' => ['placeholder' => 'Select a currency ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/projects', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
