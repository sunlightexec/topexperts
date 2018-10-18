<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>By Flip</h2>

                <?= \app\components\widgets\ListExperts::widget()?>
            </div>
            <div class="col-lg-6">
                <h2>By Hold</h2>

                <?= \app\components\widgets\ListExperts::widget(['order' => 'hold'])?>
            </div>
        </div>

    </div>
</div>
