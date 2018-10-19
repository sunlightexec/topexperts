<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjectDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/projects', 'Project Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app/projects', 'Create Project Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => 'Project',
            'value' => 'project.ICO_NAME',
            'filter' => Html::activeTextInput($searchModel, 'searchProjectName', ['class' => 'form-control']),
        ],
        [
            'label' => 'Expert',
            'value' => 'expert.name',
            'filter' => Html::activeTextInput($searchModel, 'searchExpertName', ['class' => 'form-control']),
        ],
        'Score',
        [
            'label' => 'Unifed Score',
            'value' => function($model){
                return $model->flip . " / " . $model->hold;
            }
        ],
        [
            'label' => 'is star',
            'value' => function($model){
                return $model->getProject()->one()->ICO_Star>=5 ? 'Yes' : 'No';
            }
        ],
        [
            'label' => 'is scam',
            'value' => function($model){
                return !empty($model->getProject()->one()->Scam) ? 'Yes' : 'No';
            }
        ],
        [
            'label' => 'is coined',
            'value' => function($model){
                return $model->getHystoricalData()->count() > 0 ? 'Yes' : 'No';
            }
        ],
        [
            'label' => 'is calced',
            'value' => function($model){
                return (($model->getHystoricalData()->count() > 0) && ($model->getProject()->one()->ICO_Star >= 5)) ? 'Yes' : 'No';
            }
        ],
        'project.END_ICO:date',
        [
            'label' => 'start trade',
            'value' => function($model) {
                $ret = $model->getHystoricalData()->one();
                return empty($ret) ? null : date('M d, Y', $ret->date_added);
            }
        ],
        [
            'label' => 'last price',
            'value' => function($model) {

                $ret = $model->getHystoricalData()
                    ->select(['price' => 'MAX(hystorical_data.price)'])
                    ->where(['>=', 'date_added', strtotime('-1 DAY')])
                    ->groupBy('hystorical_data.project_id')
                    ->one();
                return empty($ret) ? null : $ret->price;
            }
        ],
        [
            'label' => 'Hold All',
            'attribute' => 'project_hold',
            'value' => function($model){
                return round($model->getProject()->one()->hold_all,1);
            },
            'enableSorting' => true,
        ],
        [
            'label' => 'Hold Year',
            'value' => function($model){
                return round($model->getProject()->one()->hold_12,1);
            }
        ],
        [
            'label' => 'Hold Quarte',
            'value' => function($model){
                return round($model->getProject()->one()->hold_3,1);
            }
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ];
    ?>

    <?= ExportMenu::widget([
        'dataProvider' => $dataProviderExport,
        'columns' => $gridColumns
    ]);?>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    <?php Pjax::end(); ?>
</div>
