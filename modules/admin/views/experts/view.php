<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Experts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/experts', 'Experts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app/experts', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/experts', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app/experts', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'old_description:ntext',
            'description:ntext',
            'spreadsheet',
            'count_ratings',
            'grading_ratings',
            'paid_ratings',
            [
                'attribute' => 'address',
                'format' => 'raw',
                'value' => function() use ($model){
                    $out = '';
                    foreach (\yii\helpers\Json::decode($model->address, true) as $key => $val) {
                        $out .= "<p><strong>$key</strong>: $val</p>";
                    }
                    return $out;
                }
            ],
            'email:email',
            'subscribe',
            'comments:ntext',
            'status',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
