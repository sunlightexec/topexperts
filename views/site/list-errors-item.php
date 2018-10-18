<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="news-item">
    <?= Html::a($model['shortname'], ['/site/load-error', 'file' => $model['shortname']])?>
</div>