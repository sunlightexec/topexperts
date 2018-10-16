<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatings */

$this->title = Yii::t('app/graduation-ratings', 'Update Graduation Ratings: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Ratings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/graduation-ratings', 'Update');
?>
<div class="graduation-ratings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
