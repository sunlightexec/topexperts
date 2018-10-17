<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.10.2018
 * Time: 23:01
 */
use yii\helpers\Html;
?>


<?php if($ratingModel->type == 1):?>
    <?= \kartik\select2\Select2::widget( [
        'name' => 'ProjectData[Score]',
        'data' => \app\models\helpers\GraduationRatingData::getValues($ratingModel->id),
        'hideSearch' => true,
        'value' => !empty($model) ? $model->Score : '',
//        'language' => 'de',
        'options' => [
            'placeholder' => 'Select a type ...',
        ],

        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
<?php else:?>
    <?= Html::textInput('ProjectData[Score]', !empty($model) ? $model->score : '') ?>
<?php endif;?>

