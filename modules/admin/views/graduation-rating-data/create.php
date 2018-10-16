<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatingData */

$this->title = Yii::t('app/graduation-ratings', 'Create Graduation Rating Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Rating Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graduation-rating-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
