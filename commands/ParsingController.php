<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\api\CoinMarketCap;
use app\models\helpers\Currencies;
use app\models\helpers\HystoricalData;
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
    public function actionClearData()
    {
        HystoricalData::deleteAll();
    }

    public function actionLatestData()
    {
        $api = new CoinMarketCap(
            'work',
            '418b4546-2ac8-4ae9-b4b6-9f7cbf549a9b'
        );

        $res = $api->getLatestData();
        $res = Json::decode($res);
        if(is_array($res['status']) && $res['status']['error_code'] == 0) {
            foreach ($res['data'] as $item) {
                $valId = Currencies::check( $item['symbol'] );
                $model = new HystoricalData();
//                print_r([
//                    $item['quote'][$item['symbol']]['last_updated'],
//                    strtotime($item['quote'][$item['symbol']]['last_updated'])
//                ]);
//                echo "\n";
                $data = [
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
    }
}