<?php
use yii\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout'=>"{items}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        $order,

//        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
