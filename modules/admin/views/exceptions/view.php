<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\helpers\Exceptions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/exceptions', 'Exceptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exceptions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/exceptions', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/exceptions', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/exceptions', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'project.name',
            'site',
            'msg_true',
            'msg_fall',
            'msg_fall2',
//            'status',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
