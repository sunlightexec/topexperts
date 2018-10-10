<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Currencies */

$this->title = Yii::t('app/currencies', 'Create Currencies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/currencies', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
