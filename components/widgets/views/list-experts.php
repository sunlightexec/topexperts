<?php
use yii\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => /*$searchModel*/ false,
    'layout'=>"{items}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        [
            'attribute' => $order,
            'enableSorting' => false,
//            'contentOptions' => ['class' => 'pull-right'],
            'value' => function($model) use($order){
                return number_format($model->$order,4);
            }
        ]

//        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
