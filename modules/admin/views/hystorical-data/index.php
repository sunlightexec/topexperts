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
            'date_added:datetime',
            [
                'label' => 'Project Name',
                'value' => 'project.ICO_NAME',
                'filter' => Html::activeTextInput($searchModel, 'searchName', ['class' => 'form-control'])
            ],
            [
                'label' => 'URL',
                'value' => 'project.ICO_Website',
                'filter' => Html::activeTextInput($searchModel, 'searchURL', ['class' => 'form-control'])
            ],
            [
                'label' => 'SEMBOL',
                'value' => 'currency.name',
                'filter' => Html::activeTextInput($searchModel, 'searchCurrency', ['class' => 'form-control'])
            ],
//            'circulating_supply',
//            'total_supply',
//            'max_supply',
            //'date_added',
            'price',
            'volume_24h',
            'market_cap',
            //'status',

            //'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
