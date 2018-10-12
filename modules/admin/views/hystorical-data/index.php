<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\HystoricalDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/hystirical-data', 'Hystorical Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hystorical-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<!--        --><?//= Html::a(Yii::t('app/hystirical-data', 'Create Hystorical Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'created_at:date',
            'project.ICO_NAME',
            'project.ICO_Website',
            'currency.name',
//            'circulating_supply',
//            'total_supply',
//            'max_supply',
            //'date_added',
            'price',
            'volume_24h',
            'market_cap',
            //'status',

            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
