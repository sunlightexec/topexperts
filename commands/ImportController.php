<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\helpers\Categories;
use app\models\helpers\Currencies;
use app\models\helpers\Experts;
use app\models\helpers\ProjectData;
use app\models\helpers\ProjectSynonims;
use app\models\helpers\Projects;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ImportController extends Controller
{
    private $loadDir = '/data/';

    public function actionIndex()
    {
        $this->actionExperts();
        $this->actionProjectSynonims();
        $this->actionProjects();
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionProjectSynonims()
    {
        ProjectSynonims::deleteAll();

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'synonims.csv';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
            $row++;
            if($skipRows-- > 0) continue;
            for($i=1; $i<3; $i++) {
                if(!empty($fileop[$i])) {
                    $model = new ProjectSynonims();
                    $model->project_name = $fileop[0];
                    $model->project_synonim = $fileop[$i];
                    $model->status = 1;
                    if(!$model->save()) {
                        print_r($row);
                        print_r($model->errors);
                    };
                }
            }
        }

        return ExitCode::OK;
    }

    public function actionExperts()
    {
        Experts::deleteAll();
        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'experts.csv';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
//            print_r($fileop);fclose($handle);die();
            $row++;
            if($skipRows-- > 0) continue;
            $model = new Experts();
            $model->name = $fileop[0];
            $model->website = !empty($fileop[1]) ? $fileop[1] : '';
            $model->old_description = !empty($fileop[2]) ? $fileop[2] : '';
            $model->description = !empty($fileop[3]) ? $fileop[3] : '';
            $model->spreadsheet = !empty($fileop[4]) ? $fileop[4] : '';
            $model->count_ratings = !empty($fileop[5]) ? $fileop[5] : '';
            $model->grading_ratings = !empty($fileop[6]) ? $fileop[6] : '';
            $model->paid_ratings = !empty($fileop[7]) ? $fileop[7] : '';
            $model->address = [
                'facebook' => !empty($fileop[8]) ? $fileop[8] : '',
                'twitter' => !empty($fileop[9]) ? $fileop[9] : '',
                'youtube' => !empty($fileop[10]) ? $fileop[10] : '',
                'tg_chat' => !empty($fileop[11]) ? $fileop[11] : '',
                'tg_group' => !empty($fileop[12]) ? $fileop[12] : '',
                'discord' => !empty($fileop[13]) ? $fileop[13] : '',
                'reddit' => !empty($fileop[14]) ? $fileop[14] : '',
                'medium' => !empty($fileop[15]) ? $fileop[15] : '',
                'bitcointalk_forum' => !empty($fileop[16]) ? $fileop[16] : '',
            ];
            $model->email = !empty($fileop[17]) ? $fileop[17] : '';
            $model->subscribe = !empty($fileop[18]) ? $fileop[18] : '';
            $model->comments = !empty($fileop[19]) ? $fileop[19] : '';
            $model->status = 1;
            if(!$model->save()) {print_r('Строка: '.$row); print_r($model->errors);};
//            print_r($fileop);fclose($handle);die();
        }
        fclose($handle);

        return ExitCode::OK;
    }

    public function actionProjects()
    {
        ProjectData::deleteAll();
        Projects::deleteAll();
        Categories::deleteAll();
        Currencies::deleteAll();

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'projects.csv';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 0;
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
            $row++;
            if($row <= $skipRows) continue;
            if($row == 2) {
                $flds = $fileop;
                continue;
            }
            if($row == 3) {
                $fldName = $fileop;
                continue;
            }

            for($i=0; $i<=172; $i++) {
                if($fileop[$i] == 'No data') $fileop[$i] = null;
            }

            /*Category*/
            $catName = $fileop[5];
            $catId = null;
            if(!empty($catName)) {
                $catId = Categories::check($catName);
            }
            $valName = $fileop[7];
            $valId1 = null;
            if(!empty($valName)) {
                $valId1 = Currencies::check($valName);
            }

            $valName = $fileop[9];
            $valId2 = null;
            if(!empty($valName)) {
                $valId2 = Currencies::check($valName);
            }

            $fileop[6] = str_replace([',', '.', '​​ '],'',$fileop[6]);
            $fileop[6] = preg_replace("/[^0-9]/", '', $fileop[6]);
            $fileop[8] = str_replace(',','.',$fileop[8]);

            $model = new Projects();
            $data = [
                'ICO_NAME' => $fileop[0],
                'ICO_Website' => !empty($fileop[1]) ? $fileop[1] : null,
                'ICO_Description' => !empty($fileop[2]) ? $fileop[2] : null,
                'URL_Coinmarketcap' => !empty($fileop[3]) ? $fileop[3] : null,
                'URL_ICODrops' => !empty($fileop[4]) ? $fileop[4] : null,
                'Category' => $catId,
                'HARD_CAP' => !empty($fileop[6]) ? $fileop[6] : null,
                'Currency_HARD_CAP' => $valId1,
                'ICO_Price' => !empty($fileop[8]) ? $fileop[8] : null,
                'Currency_ICO_Price' => $valId2,
                'START_ICO' => !empty($fileop[10]) ? self::cnvDate($fileop[10]) : null,
                'END_ICO' => !empty($fileop[11]) ? self::cnvDate($fileop[11]) : null,
                'Scam' => !empty($fileop[12]) ? $fileop[12] : null,
            ];
            $model->setAttributes($data);

            if(!$model->save()) {print_r([$fileop[0], $fileop[6], $model->errors]); continue;}

            for($i=13; $i<172; $i=$i+2) {
                $expertName = $fldName[$i];
                $expertModel = Experts::find()->where(['=', 'name', $expertName])->one();
                if(empty($fileop[$i]) && empty($fileop[$i+1])) continue;
                if(empty($expertModel)) {print_r([$fileop[0], $expertName . " not found/n"]); continue;}
                else {
                    $prData = new ProjectData();
                    $prData->setAttributes([
                        'project_id' => $model->id,
                        'expert_id' => $expertModel->id,
                        'Score' => $fileop[$i],
                        'Report_Date' => !empty($fileop[$i+1]) ? self::cnvDate($fileop[$i+1]) : null,
                    ]);
                    if(!$prData->save()) {print_r([$fileop[0], $expertName, $prData->errors]); continue;}
                }
            }

        }

        return ExitCode::OK;
    }

    private static function cnvDate($strDate)
    {
        $strDate = explode('.', $strDate);

        if(count($strDate) != 3) return null;
        $strDate[0] = str_pad($strDate[0], 2, '0', STR_PAD_LEFT);
        $strDate[1] = str_pad($strDate[1], 2, '0', STR_PAD_LEFT);
        $strDate[2] = '20' . $strDate[2];
        if($strDate[1] > 12) {
//            $a = $strDate[1];
//            $strDate[1] = $strDate[0];
//            $strDate[0] = $a;
            $strDate[1] = 12;
        }
//        print_r($strDate[2] . '-' .
//        str_pad($strDate[1], 2, '0', STR_PAD_LEFT) . '-' .
//        str_pad($strDate[0], 2, '0', STR_PAD_LEFT));
        return strtotime(
            $strDate[2] . '-' .
            str_pad($strDate[1], 2, '0', STR_PAD_LEFT) . '-' .
            str_pad($strDate[0], 2, '0', STR_PAD_LEFT)
        );
    }
}
