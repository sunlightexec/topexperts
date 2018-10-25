<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 11.10.2018
 * Time: 18:46
 */

namespace app\models\helpers;

use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class HystoricalData extends \app\models\HystoricalData
{
    public function behaviors()
    {
        return [
            'asDate' => [
                'class' => TimestampBehavior::className(),
                /*'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),*/
            ],
        ];
    }

    public static function getMaxPrice($project_id = null, $period = 'last')
    {
        $project = Projects::find()->where("id = $project_id")->one();
        $start = $project->START_ICO;
        $stop = $project->END_ICO;
        $coin = $project->start_coin;
        $now = time();
        $workDate = $stop > $coin ? $stop : $coin;

        if(empty($stop) || $stop > $now) return 0;

        $model = self::find()->select(['price' => 'MAX(price)'])->filterWhere(['project_id' => $project_id]);

        switch($period) {
            case 'last':
                $model = $model->andWhere('created_at BETWEEN ' . $workDate .
                    ' AND DATE_SUB(' . $workDate . ', INTERVAL 30 day)');
                break;
            case 'quarter':
                if( $coin > strtotime("-90 DAY") ) return 0;
                $model = $model->andWhere('created_at BETWEEN ' . strtotime("-90 DAY").
                    ' AND DATE_SUB(' . strtotime("-90 DAY") . ', INTERVAL 30 day)');
                break;
            case 'year':
                if( $coin > strtotime("-365 DAY") ) return 0;
                $model = $model->andWhere('created_at BETWEEN ' . strtotime("-365 DAY") .
                    ' AND DATE_SUB(' . strtotime("-365 DAY") . ', INTERVAL 30 day)');
                break;
        }

        $model = $model->groupBy('project_id')->one();
        if(empty($model))
            return 0;

        return $model->price;
    }

    public static function getHoldPrice($project_id = null, $period = 'last')
    {
        $project = Projects::find()->where("id = $project_id")->one();
        $start = $project->START_ICO;
        $stop = $project->END_ICO;
        $coin = $project->start_coin;
        $now = time();
        $workDate = $stop > $coin ? $stop : $coin;

        if(empty($stop) || $stop > $now) return 0;

        $model = self::find()->select(['price' => 'price'])->filterWhere(['project_id' => $project_id]);

        switch($period) {
            case 'last':
                $model = $model->andWhere('created_at >= ' . $workDate)
                    ->orderBy('created_at DESC');
                break;
            case 'quarter':
                if( $coin > strtotime("-90 DAY") ) return 0;
                $model = $model->andWhere('created_at BETWEEN ' . strtotime("-90 DAY").
                    ' AND DATE_SUB(' . strtotime("-90 DAY") . ', INTERVAL 30 day)')
                    ->orderBy('created_at ASC');
                break;
            case 'year':
                if( $coin > strtotime("-365 DAY") ) return 0;
                $model = $model->andWhere('created_at BETWEEN ' . strtotime("-365 DAY") .
                    ' AND DATE_SUB(' . strtotime("-365 DAY") . ', INTERVAL 15 day)')
                    ->orderBy('created_at ASC');
                break;
        }

        $model = $model->one();
        if(empty($model))
            return 0;

        return $model->price;
    }

    public static function insertOrReplace($data)
    {
        $where = [];
        $where['currency_id'] = $data['currency_id'];
        $where['date_added'] = $data['date_added'];
        if(!empty($data['project_id'])) {
            $where['project_id'] = $data['project_id'];
        } else {
            $where['project_id'] = null;
        }
        $model = self::find()
            ->filterWhere(['name' => $data['name']])
            ->andFilterWhere($where)
            ->one();

        if(empty($model)) {
            $model = new self();
        }
        $model->detachBehavior('asDate');
        $model->setAttributes($data);
        if(!$model->save()) print_r([$model->errors, $data['volume_24h']]);

    }
}