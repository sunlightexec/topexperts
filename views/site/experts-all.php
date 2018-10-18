<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExpertsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/experts', 'Experts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'label' => 'total quoted',
                'value' => function($model){
                    return $model->countProject();
                }
            ],
            [
                'label' => 'star',
                'value' => function($model){
                    return $model->getStarProject()->count();
                }
            ],
            [
                'label' => 'scam',
                'value' => function($model){
                    return $model->getScamProject()->count();
                }
            ],
            [
                'label' => 'not coined',
                'value' => function($model){
                    return $model->getStarCoinedProject();
                }
            ],
            'flip',
            'hold',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
