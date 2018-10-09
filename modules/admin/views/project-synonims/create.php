<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProjectSynonims */

$this->title = Yii::t('app/project_synonims', 'Create Project Synonims');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/project_synonims', 'Project Synonims'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-synonims-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
