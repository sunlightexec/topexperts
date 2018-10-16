<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GraduationRatings */

$this->title = Yii::t('app/graduation-ratings', 'Create Graduation Ratings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/graduation-ratings', 'Graduation Ratings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="graduation-ratings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
