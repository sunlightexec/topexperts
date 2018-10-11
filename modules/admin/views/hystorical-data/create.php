<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HystoricalData */

$this->title = Yii::t('app/hystirical-data', 'Create Hystorical Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/hystirical-data', 'Hystorical Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hystorical-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
