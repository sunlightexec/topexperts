<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\helpers\Exceptions */

$this->title = Yii::t('app/exceptions', 'Create Exceptions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/exceptions', 'Exceptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exceptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
