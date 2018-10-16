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
    public function actionSetGraduation()
    {
        $arProjectData = ProjectData::find()->where('graduation_id is NULL')->all();
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
        if(is_array($res['status']) && $res['status']['error_code'] == 0) {
            foreach ($res['data'] as $item) {
                $valId = Currencies::check( $item['symbol'] );

                $projectModel = Projects::getProjectByAttr($item['name'], $item['slug']);
                if(empty($projectModel)) {
                    $err .= "Project {$item['name']} not found\n";
                    echo "Project {$item['name']} not found\n";
                    continue;
                }
                $model = new HystoricalData();
//                print_r([
//                    $item['quote'][$item['symbol']]['last_updated'],
//                    strtotime($item['quote'][$item['symbol']]['last_updated'])
//                ]);
//                echo "\n";
                $data = [
                    'project_id' => $projectModel->id,
                    'currency_id' => $valId,
                    'circulating_supply' => $item['circulating_supply'],
                    'total_supply' => $item['total_supply'],
                    'max_supply' => $item['max_supply'],
                    'date_added' => strtotime($item['quote']['USD']['last_updated']),
                    'price' => $item['quote']['USD']['price'],
                    'volume_24h' => $item['quote']['USD']['volume_24h'],
                    'market_cap' => $item['quote']['USD']['market_cap'],
                ];
                $model->setAttributes($data);
                if(!$model->save()) {print_r([$item['symbol'], $model->errors]); echo "\n";}
            }
        }

        file_put_contents('hyst-data.err', $err);
    }
}