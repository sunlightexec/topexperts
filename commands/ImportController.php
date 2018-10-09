<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\helpers\Experts;
use app\models\helpers\ProjectSynonims;
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
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false)
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
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false)
        {
//            print_r($fileop);fclose($handle);die();
            $row++;
            if($skipRows-- > 0) continue;
            $model = new Experts();
            $model->name = $fileop[0];
            $model->website = $fileop[1];
            $model->old_description = !empty($fileop[2]) ? $fileop[2] : '';
            $model->description = !empty($fileop[3]) ? $fileop[3] : '';
            $model->spreadsheet = !empty($fileop[4) ? $fileop[4] : ''];
            $model->count_ratings = !empty($fileop[5]) ? $fileop[5] : '';
            $model->grading_ratings = !empty($fileop[6]) ? $fileop[6] : '';
            $model->paid_ratings = !empty($fileop[7]) ? $fileop[7] : '';
            $model->address = [
                'facebook' => $fileop[8],
                'twitter' => $fileop[9],
                'youtube' => $fileop[10],
                'tg_chat' => $fileop[11],
                'tg_group' => $fileop[12],
                'discord' => $fileop[13],
                'reddit' => $fileop[14],
                'medium' => $fileop[15],
                'bitcointalk_forum' => $fileop[16],
            ];
            $model->email = $fileop[17];
            $model->subscribe = $fileop[18];
            $model->comments = !empty($fileop[19]) ? $fileop[19] : '';
            $model->status = 1;
            if(!$model->save()) {print_r('Строка: '.$row); print_r($model->errors);};
//            print_r($fileop);fclose($handle);die();
        }
        fclose($handle);

        return ExitCode::OK;
    }
}
