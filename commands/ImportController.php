<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\helpers\Categories;
use app\models\helpers\Currencies;
use app\models\helpers\Exceptions;
use app\models\helpers\Experts;
use app\models\helpers\GraduationRatingData;
use app\models\helpers\GraduationRatings;
use app\models\helpers\HystoricalData;
use app\models\helpers\ProjectData;
use app\models\helpers\ProjectSynonims;
use app\models\helpers\Projects;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;
use yii\helpers\Json;

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
        ProjectSynonims::deleteAll();
        Experts::deleteAll();

        print_r("Import Experts \n");
        $this->actionTypeRatings();

        print_r("Import Experts \n");
        $this->actionExperts();

        print_r("Import Projects \n");
        $this->actionProjects();

        print_r("Import Synonims \n");
        $this->actionProjectSynonims();

        print_r("Import Hystory \n");
        $this->actionHystorical()();
    }

    public function actionPrjClear()
    {

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'forclear.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'forclear.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        $lastProject = '';
        while (($fileop = fgetcsv($handle, 2000, ";")) !== false) {
            if($row++ % 200 == 0) echo "$row++";
            $project = Projects::getProjectByAttr($fileop[0], $fileop[0]);
            if(!empty($project)) {
                HystoricalData::updateAll([
                    'project_id' => null,
                ], '`project_id`='.$project->id
                );
            }


        }
        echo "\nUPDATING\n";
        $row = 0;
        $hysts = HystoricalData::find()
            ->select('project_id, name')
            ->where('project_id IS NULL')
//            ->andWhere(['=', 'name', 'Alchemint Standards'])
            ->groupBy('project_id, name')
            ->all();
        foreach($hysts as $hyst) {
            if($row++ % 200 == 0) echo "$row++";
            $project = Projects::getProjectByAttr($hyst->name, $hyst->name);
            if(!empty($project)) {
                HystoricalData::updateAll([
                    'project_id' => $project->id,
                ], '`name`="'.$hyst->name . '"'
                );
            }
        }
        fclose($handle);
        echo "\n";
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionHystorical()
    {
        HystoricalData::deleteAll('total_supply IS NULL');

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'hystorical1.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'hystorical.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        $lastProject = '';
        while (($fileop = fgetcsv($handle, 2000, ";")) !== false)
        {
            $row++;
            if($skipRows-- > 0) continue;
            if($row % 5000 == 0) echo "$row++";

            $curId = Currencies::check($fileop[1]);
            $modelProject = Projects::getProjectByAttr($fileop[0], $fileop[1], $fileop[2]);

            if(empty($modelProject)) {
                $project_id = null;
                if($lastProject != $fileop[0]) {
                    $message = "\nProject {$fileop[0]} not found\n";
                    $errors .= $message;
                    echo $message;
                    $lastProject = $fileop[0];
                }
//                continue;
            } else {
                $project_id = $modelProject->id;
            }

            $data = [
                'name' => $fileop[0],
                'date_added' => strtotime($fileop[3]),
                'project_id' => $project_id,
                'currency_id' => $curId,
                'price' => str_replace(',', '.', $fileop[5]),
                'volume_24h' => (double)str_replace([',', '-'], ['.', ''], $fileop[6]),
                'market_cap' => (double)str_replace([',', '-'], ['.', ''], $fileop[7]),
            ];

            HystoricalData::insertOrReplace($data);

//            print_r($fileop);die();
        }
        echo "\n";
        fclose($handle);
        file_put_contents($errorFileName, $errors);
        return ExitCode::OK;
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionTypeRatings()
    {
        GraduationRatingData::deleteAll();
        GraduationRatings::deleteAll();

        $scoreType = [];

        $skipRows = 4;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'ratings.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'ratings.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
            $isHead = false;
            $row++;
            if($skipRows-- > 0) continue;
            if($row % 2 == 0) echo "$row++";
            if( $row < 38 ) {
                if( empty($scoreType[$fileop[0]]) ) {
                    foreach($fileop as $index => $value) {
                        if($index == 0) continue;
                        if(!empty($value)) {
                            $scoreType[$fileop[0]][] = [
                                'index' => $index,
                                'value' => $value,
                                'num' => $fileop[0],
                            ];
                        }
                    }
                    $isHead = true;
                } else {
                    $model = new GraduationRatings();
                    $model->name = "type_{$row}";
                    $model->type = 1;
                    if(!$model->save()) {
                        print_r($model->errors); echo "\n";
                        $errors .= "Save Rating error " . json_encode($model->errors) . "\n";
                    }

                    /*graduation data*/
                    foreach($scoreType[$fileop[0]] as $item) {
                        $modelData = new GraduationRatingData();
                        $modelData->graduation_id = $model->id;
                        $modelData->score = strtoupper( $fileop[$item['index']] );
                        $modelData->value = str_replace(',','.', $item['value']);
                        if(!$modelData->save()) {
                            print_r($modelData->errors);
                            $errors .= "Save Rating Data error " . json_encode($modelData->errors) . "\n";
                        }
                    }
                    $isHead = false;
                }
            } else {
                $isHead = false;
                $model = new GraduationRatings();
                $model->name = "type_{$row}";
                $model->type = 2;
                $model->max_value = $fileop[0];
                if($row == 43) {
                    $model->min_star = 6;
                }
                if(!$model->save()) {
                    print_r($model->errors); echo "\n";
                    $errors .= "Save Rating error " . json_encode($model->errors) . "\n";
                }
            }

            if(!empty($model) && !$isHead) {
                $allowed = [];
                $allowed[] = '--';

                for($i=14; $i<count($fileop); $i++) {
                    if(!empty($fileop[$i])) {
                        $allowed[] = trim($fileop[$i]);
                    }
                }
                if(count($allowed) == 1) {
                    $allowed = null;
                } else {
                    $allowed[] = '--';
                    $allowed = implode(',',$allowed);
                }

                $model->allowed = $allowed;
                if(!$model->save()) {
                    print_r($model->errors); echo "\n";
                    $errors .= "Save Rating error " . json_encode($model->errors) . "\n";
                }
            }
        }

        echo "\n";
        fclose($handle);
        file_put_contents($errorFileName, $errors);
        return ExitCode::OK;
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
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'synonims.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
            $row++;
            if($skipRows-- > 0) continue;
            if($row % 10 == 0) echo "$row++";
            for($i=1; $i<4; $i++) {
                if(!empty($fileop[$i])) {

                    $model = new ProjectSynonims();
                    $model->project_name = $fileop[0];
                    $model->project_synonim = $fileop[$i];
                    $model->status = 1;
                    if(!$model->save()) {
                        $errors .= "Save Rating error ({$row})" . json_encode($model->errors) . "\n";
                        print_r($model->errors);
                    };
                }
            }
        }
        echo "\n";
        fclose($handle);
        file_put_contents($errorFileName, $errors);
        return ExitCode::OK;
    }

    public function actionExperts()
    {
        Experts::deleteAll();
        $skipRows = 1;
        $errors = '';
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'experts.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'experts.err';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        while (($fileop = fgetcsv($handle, 3000, ",")) !== false)
        {
//            print_r($fileop);fclose($handle);die();
            $row++;
            if($skipRows-- > 0) continue;
            if($row % 100 == 0) echo "$row++";
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
            if(!$model->save()) {
                print_r('Строка: '.$row); print_r($model->errors);
                $errors .= "Save Expert error ({$row})" . json_encode($model->errors) . "\n";
            };
//            print_r($fileop);fclose($handle);die();
        }
        fclose($handle);
        file_put_contents($errorFileName, $errors);
        echo "\n";

        return ExitCode::OK;
    }

    public function actionProjects()
    {
        ProjectData::deleteAll();
        Projects::deleteAll();
        Categories::deleteAll();
        Currencies::deleteAll();
        HystoricalData::updateAll(['project_id' => null]);

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'projects.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'projects.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 0;
        echo "0++";
        while (($fileop = fgetcsv($handle, 3000, ",")) !== false)
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

            if($row % 500 == 0) echo "$row++";

            for($i=0; $i<=172; $i++) {
                if(isset($fileop[$i]) && $fileop[$i] == 'No data') $fileop[$i] = null;
            }

            /*Category*/
//            if(!isset($fileop[5])) die(print_r($fileop));
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
            $sDate = !empty($fileop[10]) ? self::cnvDate($fileop[10]) : null;
            $eDate = !empty($fileop[11]) ? self::cnvDate($fileop[11]) : null;
//            print_r([$sDate, $eDate]);
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
                'START_ICO' => $sDate,
                'END_ICO' => $eDate,
                'Scam' => !empty($fileop[12]) ? $fileop[12] : null,
            ];
            $model->setAttributes($data);

            if(!$model->save()) {
                $errors .= "Save Project error ({$row})" . json_encode($model->errors) . "\n";
                print_r([$fileop[0], $fileop[6], $model->errors]);
                continue;
            }

            for($i=13; $i<172; $i=$i+2) {
                $expertName = $fldName[$i];
                $expertModel = Experts::find()->where(['=', 'name', $expertName])->one();
                if(empty($fileop[$i]) && empty($fileop[$i+1])) continue;
                if(empty($expertModel)) {
                    print_r([$fileop[0], $expertName . " not found/n"]);
                    $errors .= $expertName . " not found({$row})/n" . "\n";

                    continue;
                }
                else {
                    $prData = new ProjectData();
                    $prData->setAttributes([
                        'project_id' => $model->id,
                        'expert_id' => $expertModel->id,
                        'Score' => $fileop[$i],
                        'Report_Date' => !empty($fileop[$i+1]) ? self::cnvDate($fileop[$i+1]) : null,
                    ]);
                    if(!$prData->save()) {
                        $errors .= "Save ProjectData error ({$row})" . json_encode($prData->errors) . "\n";
                        print_r([$fileop[0], $expertName, $prData->errors]);
                        continue;
                    }
                }
            }

        }
        fclose($handle);
        file_put_contents($errorFileName, $errors);
        echo "\n";

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
//        $strDate[1] . '-' .
//        $strDate[0]);
//        echo ' :  '.strtotime(
//                $strDate[2] . '-' .
//                $strDate[1] . '-' .
//                $strDate[0]
//            ) . "\n";
        return strtotime(
            $strDate[2] . '-' .
            $strDate[1] . '-' .
            $strDate[0]
        );
    }

    public function actionExceptions()
    {
        Exceptions::deleteAll();

        $skipRows = 1;
        $loadFileName = \Yii::$app->basePath . $this->loadDir . 'exceptions.csv';
        $errorFileName = \Yii::$app->basePath . $this->loadDir . 'exceptions.err';
        $errors = '';
        $loadFileName = FileHelper::normalizePath($loadFileName);
        if(!file_exists($loadFileName)) return ExitCode::NOINPUT;
        $handle = fopen($loadFileName, "r");
        $row = 1;
        echo "0++";
        while (($fileop = fgetcsv($handle, 2000, ",")) !== false)
        {
            $row++;
            if($skipRows-- > 0) continue;
            if($row % 10 == 0) echo "$row++";
            $expert = Projects::find()->where(['=','ICO_NAME', $fileop[0]])->one();
            if(empty($expert)) {echo "project {$fileop[0]} not found\n"; continue;}
            $model = new Exceptions();
            $model->project_id = $expert->id;
            $model->site = !empty($fileop[1]) ? $fileop[1] : null;
            $model->msg_true = !empty($fileop[2]) ? $fileop[2] : null;
            $model->msg_fall = !empty($fileop[3]) ? $fileop[3] : null;
            $model->msg_fall2 = !empty($fileop[4]) ? $fileop[4] : null;

            if(!$model->save()) {
                $errors .= "Save Exceptions error ({$row})" . json_encode($model->errors) . "\n";
                print_r([$row, $model->errors]);
            };
        }
        file_put_contents($errorFileName, $errors);
        echo "\n";
        return ExitCode::OK;
    }
}
