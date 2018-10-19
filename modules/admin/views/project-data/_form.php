<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectData */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $md = $model->getGraduation()->one();?>
<div class="project-data-form">

    <?php $form = ActiveForm::begin([
            'action' => $model->isNewRecord ? ['/admin/project-data/create'] : ['/admin/project-data/update', 'id' => $model->id]
    ]); ?>

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

    <?= $form->field($model, 'expert_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\Experts::getList(),
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

<!--    --><?//= $form->field($model, 'Report_Date')->textInput() ?>

    <?= $form->field($model, 'graduation_id')->widget(Select2::classname(), [
        'data' => \app\models\helpers\GraduationRatings::getList(),
        'hideSearch' => true,
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],
//        'disabled' => $model->isNewRecord ? false : true,
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'pluginEvents' => [
            'select2:select' => "function(e){
                        var graduation_id = e.params.data.id;
                        var project_id = " . $model->id .";
                        var expert_id = $('#projectdata-expert_id').val();
                        
                        $.ajax({
                            type: 'POST',
                            url : '" . \Yii::$app->urlManager->createUrl('/admin/project-data/get-rating-value')."',
                            data : {
                                graduation_id: graduation_id,
                                project_id: project_id,
                                expert_id: expert_id
                            },
                            success: function(data) {
                                $('.project-data-form').replaceWith(data);
                            }
                        });
                        return false;
                    }"
        ],
    ]) ?>
    <div id="setupRaiting">
    <?php if(!$model->isNewRecord):?>
        <?php if(!empty($md) && $md->type == 1):?>
            <?= $form->field($model, 'scoreFlip')->widget(Select2::classname(), [
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
                'pluginEvents' => [
                    'select2:select' => "function(e){
                        var data = e.params.data;
                        console.log(data);
                    }"
                ],
            ]) ?>
        <?php else:?>
            <?= $form->field($model, 'scoreFlip')->textInput(['maxlength' => true]) ?>
        <?php endif;?>
    <?php else:?>
        <?= $form->field($model, 'scoreFlip')->textInput(['maxlength' => true]) ?>
    <?php endif?>
    <?php if(!$model->isNewRecord):?>
        <?php if(!empty($md) && $md->type == 1):?>
            <?= $form->field($model, 'scoreHold')->widget(Select2::classname(), [
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
                'pluginEvents' => [
                    'select2:select' => "function(e){
                        var data = e.params.data;
                        console.log(data);
                    }"
                ],
            ]) ?>
        <?php else:?>
            <?= $form->field($model, 'scoreHold')->textInput(['maxlength' => true]) ?>
        <?php endif;?>
    <?php else:?>
        <?= $form->field($model, 'scoreHold')->textInput(['maxlength' => true]) ?>
    <?php endif?>
    </div>

    <?= $form->field($model, 'max_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flip')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'hold')->textInput(['disabled' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/projects', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
