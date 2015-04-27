<?php

namespace frontend\controllers;

use Yii;
use common\models\Menu;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class ManagerController extends Controller
{

    var $disableCreateBtn = false;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['restaurant'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function init(){
        if(empty($this->modelName)){
            throw new Exception("Please Override 'getModelName' function");
        }
        if(empty($this->modelSearchName)){
            throw new Exception("Please Override 'getModelName' function");
        }
    }

    /**
     * Lists all models and allow to edit on same page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = 0)
    {

        // return edit form
        if(Yii::$app->request->isAjax && !empty($id)){
            $model = $this->findModel($id);
            return $this->renderAjax('form', [
                'model' => $model,
                'isIndex' => false,
            ]);
        }

        // providers for gridview
        $isIndex = true;
        $searchModel = new $this->modelSearchName;
        $dataProvider = $searchModel->search($this->getSearchParams());
        // if GET with id, then will display edit form, else add form
        if(empty($id)) {
            $model = new $this->modelName;
        }else{
            $model= $this->findModel($id);
            $isIndex = false;
        }

        $this->update($model, $id);

        // display gridview and form
        return $this->render("//managerIndex",[
            "table" => $this->renderPartial('table', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]),
            "form"  => $this->renderPartial('form', [
                'model' => $model,
                'isIndex' => $isIndex,
            ]),
            'disableCreateBtn' => $this->disableCreateBtn,
        ]);
    }

    /**
     * @param $model
     * @return \yii\web\Response
     */
    public function update($model, $id){

        //delete
        if(isset($_POST["remove"])){
            $model->delete();
            return $this->redirect(['index']);
        }

        //copy
        if(isset($_POST["copy"])){
            $model = new $this->modelName;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index',  'id' => $id]);
            }
        }

        //create new or update records
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',  'id' => $id]);
        }

    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelName=$this->modelName;
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string
     */
    public function getModelName(){
        return "";
    }

    /**
     * @return string
     */
    public function getModelSearchName(){
        return "";
    }

    /**
     * @return array|mixed
     */
    public function getSearchParams()
    {
        return Yii::$app->request->queryParams;
    }
}
