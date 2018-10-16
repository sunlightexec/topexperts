<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatingData */

$this->title = Yii::t('app/graduation-ratings', 'Update Graduation Rating Data: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Rating Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getGraduation()->one()->name, 'url' => ['graduation-ratings/view', 'id' => $model->graduation_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/graduation-ratings', 'Update');
?>
<div class="graduation-rating-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
