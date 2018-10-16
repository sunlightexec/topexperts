<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatingData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Ratings'), 'url' => ['graduation-ratings/index']];
$this->params['breadcrumbs'][] = ['label' => $model->getGraduation()->one()->name, 'url' => ['graduation-ratings/view', 'id' => $model->graduation_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graduation-rating-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/graduation-ratings', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/graduation-ratings', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/graduation-ratings', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'graduation_id',
            'score',
            'value',
//            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
