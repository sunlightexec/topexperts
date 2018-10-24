<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\api\CoinMarketCap;
use app\models\GraduationRatings;
use app\models\helpers\Currencies;
use app\models\helpers\Experts;
use app\models\helpers\GraduationRatingData;
use app\models\helpers\HystoricalData;
use app\models\helpers\ProjectData;
use app\models\helpers\Projects;
use app\models\helpers\ProjectSynonims;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ParsingController extends Controller
{
    public function actionSetHystory()
    {
        $arRecs = HystoricalData::find()
            ->where('project_id IS NULL')
            ->limit(10000)
            ->all();
        $row = 0;
        foreach($arRecs as $oRec) {
            if($row++ % 2000 == 0) echo "$row++";
            $id = Projects::getProjectByAttr($oRec->name, $oRec->name);

            if(!empty($id)) {
                $oRec->project_id = $id;
                $oRec->save();
            }
        }
        echo "\nFINISH\n";
    }

    public function actionRecalcProject()
    {
        $arData = Projects::find()->all();
        $row = 1;
        foreach ($arData as $item) {
            if($row++ % 500 == 0) echo "$row";
            Projects::setRatings($item->id);
        }
    }

    public function actionUpdProjectRatings()
    {
        $arData = ProjectData::find()
//            ->where('graduation_id IS NOT NULL and flip <> hold')
            ->where('flip = 0 OR hold = 0')
            ->all();
        echo count($arData) . "\n";
        $row = 0;
        foreach ($arData as $item) {
            if($row++ % 100 == 0) echo "$row++";
            GraduationRatingData::applyRatingWithId($item);
            continue;
            $score = explode('/', $item->Score);
//            die(print_r($score));
            if(count($score) == 1) {
                $flip = $hold = $score;
            } else {
                $flip = $score[0];
                $hold = $score[1];
            }

            /*$sco = $item->getGraduation()->one()->getGraduationRatingDatas()
                ->where(['=', 'score', $flip])->one();*/
            $GR = $item->getGraduation()->one();
            if($GR->type == 1) {
                $sco = GraduationRatingData::find()
                    ->filterWhere([
                        'score' => $flip,
                        'graduation_id' => $item->graduation_id
                    ])
                    ->one();
                $divider = 1;
            } else {
                $sco = GraduationRatingData::find()
                    ->filterWhere([
//                        'score' => $flip,
                        'graduation_id' => $item->graduation_id
                    ])
                    ->one();
                $divider = $GR->max_value;
            }

            if(empty($sco)) {
                $item->flip = 0;
            } else {
                $item->flip = str_replace( ['%', ','],['','.'],$sco->value ) / $divider;
            }

            if($flip != $hold){
                /*$sco = $item->getGraduation()->one()->getGraduationRatingDatas()
                    ->where(['=', 'score', $hold])->one();*/
                if($GR->type == 1) {
                    $sco = GraduationRatingData::find()
                        ->filterWhere([
                            'score' => $hold,
                            'graduation_id' => $item->graduation_id
                        ])
                        ->one();
                } else {
                    $sco = GraduationRatingData::find()
                        ->filterWhere([
//                            'score' => $hold,
                            'graduation_id' => $item->graduation_id
                        ])
                        ->one();
                }
                $divider = $GR->max_value;
            }

            if(empty($sco)) {
                $item->hold = 0;
            } else {
                $item->hold = str_replace( ['%', ','],['','.'],$sco->value ) / $divider;
            }
            $item->save();
        }
    }

    public function actionSetStarProject()
    {
        $arProjects = Projects::find()->all();
        $row = 1;
        foreach ($arProjects as $oProject) {
            if($row++ % 500 == 0) echo "$row++";
            Projects::setStar($oProject->id);
        }
    }

    public function actionSetRatingProjects()
    {
        $arProjects = Projects::find()->all();
        $row = 1;
        foreach ($arProjects as $oProject) {
            if($row++ % 2000 == 0) echo "$row++";
            Projects::setRatings($oProject->id);
        }
    }

    public function actionSetRatingExperts()
    {
        $arExperts = Experts::find()->all();
        $row = 1;
        foreach ($arExperts as $oExpert) {
            if($row++ % 5 == 0) echo "$row++";
            Experts::setRatings($oExpert->id);
        }
    }

    public function actionSetGraduation()
    {
        ini_set('memory_limit', '256M');
        $arProjectData = ProjectData::find()->all();
        $row = 0;
        foreach ($arProjectData as $oProjectData) {
            $row++;
            if($row % 500 == 0) echo "$row++\n";

            GraduationRatingData::applyRating($oProjectData);
        }
    }

    public function actionClearData()
    {
        HystoricalData::deleteAll();
    }

    public function actionSetProjectId()
    {
        $arItems = HystoricalData::find()->where('project_id is NULL')->all();
        foreach ($arItems as $count => $oItem) {
            $projectModel = Projects::getProjectByAttr($oItem->name, '-');
            if($count % 500 == 0) echo "$count ++";
            if(!empty($projectModel)) {
                $oItem->project_id = $projectModel->id;
                if(!$oItem->save()) {print_r($oItem->errors); echo "\n";}
            }
        }
    }

    public function actionLatestData()
    {
        $api = new CoinMarketCap(
            'work',
            '418b4546-2ac8-4ae9-b4b6-9f7cbf549a9b'
        );

        $res = $api->getLatestData();

        $res = Json::decode($res);
        $err = '';
        file_put_contents('json.json',json_encode($res['data']));
        if(is_array($res['status']) && $res['status']['error_code'] == 0) {
            foreach ($res['data'] as $item) {
                $valId = Currencies::check( $item['symbol'] );

                $projectModel = Projects::getProjectByAttr($item['name'], $item['slug']);
                if(empty($projectModel)) {
                    $project_id = null;
                    $err .= "Project {$item['name']} not found\n";
                    echo "Project {$item['name']} not found\n";
//                    continue;
                } else {
                    $project_id = $projectModel->id;
                }
                $model = new HystoricalData();
//                print_r([
//                    $item['quote'][$item['symbol']]['last_updated'],
//                    strtotime($item['quote'][$item['symbol']]['last_updated'])
//                ]);
//                echo "\n";
                $data = [
                    'project_id' => $project_id,
                    'currency_id' => $valId,
                    'circulating_supply' => $item['circulating_supply'],
                    'total_supply' => $item['total_supply'],
                    'max_supply' => $item['max_supply'],
                    'date_added' => strtotime($item['date_added']),
                    'price' => $item['quote']['USD']['price'],
                    'volume_24h' => $item['quote']['USD']['volume_24h'],
                    'market_cap' => $item['quote']['USD']['market_cap'],
                    'name' => $item['name'],
                ];
                $model->setAttributes($data);
                if(!$model->save()) {print_r([$item['symbol'], $model->errors]); echo "\n";}
            }
        }

        file_put_contents('hyst-data.err', $err);
    }
}