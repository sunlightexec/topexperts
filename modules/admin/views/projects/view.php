<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/projects', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/projects', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/projects', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/projects', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ICO_NAME',
            'ICO_Website',
            'ICO_Description:ntext',
            'URL_Coinmarketcap:url',
            'URL_ICODrops:url',
            'category.name',
            'HARD_CAP',
            'currencyHARDCAP.name',
            'ICO_Price',
            'currencyICOPrice.name',
            'START_ICO:date',
            'END_ICO:date',
            'Scam',
            'start_coin:datetime',
            'flip_all',
            'flip_3',
            'flip_12',
            'hold_all',
            'hold_3',
            'hold_12',
        ],
    ]) ?>

</div>
