<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Experts */

$this->title = Yii::t('app/experts', 'Update Experts: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/experts', 'Experts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/experts', 'Update');
?>
<div class="experts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
