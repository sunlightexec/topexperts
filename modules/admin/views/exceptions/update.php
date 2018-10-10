<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\helpers\Exceptions */

$this->title = Yii::t('app/exceptions', 'Update Exceptions: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/exceptions', 'Exceptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/exceptions', 'Update');
?>
<div class="exceptions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
