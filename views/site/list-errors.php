<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <h1>List Import Errors</h1>

        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'list-errors-item',
            'layout' => '{items}'
        ])?>

    </div>
</div>
