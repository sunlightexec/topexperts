<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HystoricalData */

$this->title = Yii::t('app/hystirical-data', 'Update Hystorical Data: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/hystirical-data', 'Hystorical Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/hystirical-data', 'Update');
?>
<div class="hystorical-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
