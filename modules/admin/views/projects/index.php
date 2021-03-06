<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/projects', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/projects', 'Create Projects'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        'ICO_NAME',
        'ICO_Website',
        'category.name',
        'HARD_CAP',
        'currencyHARDCAP.name',
        'ICO_Price',
        'currencyICOPrice.name',
        'ICO_Star',
        'Scam',
        [
            'attribute' => 'is_coined',
            'value' => function($model){
                return $model->getHystoricalData()->count() > 0 ? 'Yes' : 'No';
            },
            'filter' => Html::activeDropDownList($searchModel, 'is_coined', [
                '' => 'All',
                '2' => 'No',
                '1'=>'Yes'
            ], ['class' => 'form-control'])
        ],
        [
            'attribute' => 'flip_all',
            'value' => function($model){
                return number_format($model->flip_all,4);
            }
        ],
        [
            'attribute' => 'hold_all',
            'value' => function($model){
                return number_format($model->hold_all,4);
            }
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ];

    ?>

    <?= ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns
    ]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
    <?php Pjax::end(); ?>
</div>
