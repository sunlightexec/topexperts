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
            'attribute' => 'project_name',
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
            'label' => 'Is Star',
            'attribute' => 'is_star',
            'value' => function($model){
                return (($model->flip >= 8) ? 'Yes' : 'No') . ' / ' . (($model->hold >= 8) ? 'Yes' : 'No');
            },
            'filter' => Html::activeDropDownList($searchModel, 'is_star', [
                '' => 'All',
                '2' => 'No',
                '1'=>'Yes'
            ], ['class' => 'form-control'])
        ],
        [
            'label' => 'is scam',
            'value' => function($model){
                return !empty($model->getProject()->one()->Scam) ? 'Yes' : 'No';
            }
        ],
        [
            'label' => 'Is Coined',
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
            'label' => 'is calc',
            'value' => function($model){
                return ((($model->getHystoricalData()->count() > 0) && ($model->flip > 8)) ? 'Yes' : 'No') . ' / ' .
                    ((($model->getHystoricalData()->count() > 0) && ($model->hold > 8)) ? 'Yes' : 'No');
            }
        ],
        'project.END_ICO:date',
        [
            'label' => 'start trade',
            'value' => function($model) {
                $ret = $model->getHystoricalData()->orderBy('created_at DESC')->one();
                return empty($ret) ? null : date('M d, Y', $ret->date_added);
            }
        ],
        [
            'label' => 'last price',
            'value' => function($model) {

                $ret = $model->getHystoricalData()
                    ->select(['price' => 'MAX(hystorical_data.price)'])
                    ->where(['>=', 'updated_at', strtotime('-2 DAY')])
                    ->groupBy('hystorical_data.project_id')
                    ->one();
                return empty($ret) ? null : $ret->price;
            }
        ],
        [
            'label' => 'Flip All',
            'attribute' => 'project_flip',
            'value' => function($model){
                return round($model->getProject()->one()->flip_all,1);
            },
            'enableSorting' => true,
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
