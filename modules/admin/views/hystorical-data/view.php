<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HystoricalData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/hystirical-data', 'Hystorical Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hystorical-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--        --><?//= Html::a(Yii::t('app/hystirical-data', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a(Yii::t('app/hystirical-data', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app/hystirical-data', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'project.ICO_NAME',
            'project.ICO_Website',
            'currency.name',
            'circulating_supply',
            'total_supply',
            'max_supply',
            'date_added:datetime',
            'price',
            'volume_24h',
            'market_cap',
//            'status',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
