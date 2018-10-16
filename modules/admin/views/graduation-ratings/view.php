<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Ratings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graduation-ratings-view">

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
            'name',
            'type',
            'status',
            'min_star',
            'max_value',
            [
                'label' => Yii::t('app/graduation-ratings', 'Allowed'),
                'format' => 'raw',
                'value' => function() use ($model){
//                    $data = \yii\helpers\Json::decode($model->allowed);
                    return implode('<br>', explode(',',$model->allowed));
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
<?php
$this->title = Yii::t('app/graduation-ratings', 'Graduation Rating Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graduation-rating-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/graduation-ratings', 'Create Graduation Rating Data'), ['graduation-rating-data/create', 'graduation_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'graduation.name',
            'score',
            'value',
            // 'status',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'graduation-rating-data'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
