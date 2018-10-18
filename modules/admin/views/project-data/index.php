<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
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
            'flip',
            'hold',
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
                    return $model->getProject()->one()->ICO_Star >= 5 ? 'Yes' : 'No';
                }
            ],
            [
                'label' => 'Hold All',
                'value' => function($model){
                    return round($model->getProject()->one()->hold_all,1);
                }
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

            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
