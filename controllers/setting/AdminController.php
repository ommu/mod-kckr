<?php
/**
 * AdminController
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 *
 * AdminController implements the CRUD actions for KckrSetting model.
 * Reference start
 * TOC :
 *	Index
 *	Update
 *	Delete
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\controllers\setting;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\kckr\models\KckrSetting;
use ommu\kckr\models\search\KckrCategory as KckrCategorySearch;
use ommu\kckr\models\search\KckrPic as KckrPicSearch;

class AdminController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
		$this->layout = 'admin_default';

		$model = KckrSetting::findOne(1);
		if ($model === null) 
			$model = new KckrSetting(['id'=>1]);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR setting success created.'));
				return $this->redirect(['update']);
				//return $this->redirect(['view', 'id'=>$model->id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$searchModel = new KckrCategorySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$gridColumn = Yii::$app->request->get('GridColumn', null);
		$cols = [];
		if($gridColumn != null && count($gridColumn) > 0) {
			foreach($gridColumn as $key => $val) {
				if($gridColumn[$key] == 1)
					$cols[] = $key;
			}
		}
		$columns = $searchModel->getGridColumn($cols);

		$picSearchModel = new KckrPicSearch();
		$picDataProvider = $picSearchModel->search(Yii::$app->request->queryParams);

		$gridColumn = Yii::$app->request->get('GridColumn', null);
		$cols = [];
		if($gridColumn != null && count($gridColumn) > 0) {
			foreach($gridColumn as $key => $val) {
				if($gridColumn[$key] == 1)
					$cols[] = $key;
			}
		}
		$picColumns = $picSearchModel->getGridColumn($cols);

		$this->view->title = Yii::t('app', 'Deposit Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_index', [
			'model' => $model,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'picSearchModel' => $picSearchModel,
			'picDataProvider' => $picDataProvider,
			'picColumns' => $picColumns,
		]);
	}

	/**
	 * Updates an existing KckrSetting model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate()
	{
		$model = KckrSetting::findOne(1);
		if ($model === null) 
			$model = new KckrSetting(['id'=>1]);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR setting success updated.'));
				return $this->redirect(['update']);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->subMenu = $this->module->params['setting_submenu'];
		$this->view->title = Yii::t('app', 'Deposit Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
			'breadcrumb' => true,
		]);
	}

	/**
	 * Deletes an existing KckrSetting model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete()
	{
		$model = $this->findModel(1);
		$model->delete();

		Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR setting success deleted.'));
		return $this->redirect(Yii::$app->request->referrer ?: ['index']);
	}

	/**
	 * Finds the KckrSetting model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return KckrSetting the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = KckrSetting::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}