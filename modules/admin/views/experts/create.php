<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Experts */

$this->title = Yii::t('app/experts', 'Create Experts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/experts', 'Experts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
