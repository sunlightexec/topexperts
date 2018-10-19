<?php

namespace app\modules\admin\controllers;

use app\models\helpers\Experts;
use app\models\helpers\GraduationRatingData;
use app\models\helpers\GraduationRatings;
use Yii;
use app\models\helpers\ProjectData;
use app\models\search\ProjectDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectDataController implements the CRUD actions for ProjectData model.
 */
class ProjectDataController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProviderExport = $searchModel->search(Yii::$app->request->queryParams, 20);
        $dataProviderExport->setTotalCount(20);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderExport' => $dataProviderExport,
        ]);
    }

    /**
     * Displays a single ProjectData model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProjectData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GraduationRatingData::applyRatingWithId($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProjectData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GraduationRatingData::applyRatingWithId($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetRatingValue()
    {
        $data = Yii::$app->request->post('ProjectData', null);
        if(empty($data)) {
            $graduation_id = Yii::$app->request->post('graduation_id', null);
            $expert_id = Yii::$app->request->post('expert_id', null);
            $projectData_id = Yii::$app->request->post('project_id', null);
        } else {
            $graduation_id = $data['graduation_id'];
            $expert_id = $data['expert_id'];
            $projectData_id = $data['project_id'];
        }

//die(print_r([$graduation_id,$expert_id,$projectData_id]));
        $modelExpert = Experts::find()->where(['=', 'id', $expert_id])->one();
//        die(print_r($modelExpert->attributes));
        if(empty($graduation_id)) {
            $ratingModel = GraduationRatings::find()
                ->where(['like', 'allowed', ',' . $modelExpert->name . ','])
                ->one();
        } else {
            $ratingModel = GraduationRatings::find()
//                ->where(['like', 'allowed', ',' . $modelExpert->name . ','])
                ->andFilterWhere(['id' => $graduation_id])
                ->one();
        }

        $model = ProjectData::find()->where(['=', 'id', $projectData_id])->one();

        $model->graduation_id = $graduation_id;
        $model->Score = '';

        /*return $this->renderAjax('ajax-rating-input', [
            'model' => !empty($projectData_id) ? ProjectData::findOne(['id' => $projectData_id]) : null,
            'ratingModel' => $ratingModel,
        ]);*/

        return $this->renderAjax('_form', [
            'model' => $model,
            'ratingModel' => $ratingModel,
        ]);
    }

    /**
     * Finds the ProjectData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectData::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/projects', 'The requested page does not exist.'));
    }
}
