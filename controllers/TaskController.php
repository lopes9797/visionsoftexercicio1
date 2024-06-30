<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tasks = Task::find()->all();
        $taskModel = new Task();

        if (Yii::$app->request->isPjax) {
            return $this->renderPartial('_taskTable', ['tasks' => $tasks]);
        }
        return $this->render('index', ['tasks' => $tasks, 'taskModel' => $taskModel]);
    }

    /**
     * Displays a single Task model.
     * @param int $id ID
     * @return Task
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $task = Task::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }
        return $task;
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string[]
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $task = new Task();
        if ($task->load(Yii::$app->request->post())) {
            $task->created_at = date('Y-m-d H:i:s');
            if ($task->status_id == 3) {
                $task->conclusion_at = date('Y-m-d H:i:s');
            }
            if ($task->save()) {
                return ['status' => 'success'];
            }
        }
        return ['status' => 'error', 'errors' => $task->errors];
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string[]
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $task = Task::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }
        if ($task->load(Yii::$app->request->post())) {
            if ($task->status_id == 3 && $task->conclusion_at == null) {
                $task->conclusion_at = date('Y-m-d H:i:s');
            }
            if ($task->save()) {
                return ['status' => 'success'];
            }
        }
        return ['status' => 'error', 'errors' => $task->errors];
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return string[]
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $task = Task::findOne($id);
        if ($task && $task->delete()) {
            return ['status' => 'success'];
        }
        return ['status' => 'error'];
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
