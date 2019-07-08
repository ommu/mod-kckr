<?php
/**
 * AdminController
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 *
 * AdminController implements the CRUD actions for Kckrs model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *	Print
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\kckr\models\Kckrs;
use ommu\kckr\models\search\Kckrs as KckrsSearch;
use yii\web\UploadedFile;

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
					'publish' => ['POST'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
		return $this->redirect(['manage']);
	}

	/**
	 * Lists all Kckrs models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new KckrsSearch();
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

		if(($pic = Yii::$app->request->get('pic')) != null)
			$pic = \ommu\kckr\models\KckrPic::findOne($pic);
		if(($publisher = Yii::$app->request->get('publisher')) != null)
			$publisher = \ommu\kckr\models\KckrPublisher::findOne($publisher);

		$this->view->title = Yii::t('app', 'KCKR(s)');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'pic' => $pic,
			'publisher' => $publisher,
		]);
	}

	/**
	 * Creates a new Kckrs model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Kckrs();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$model->photos = UploadedFile::getInstance($model, 'photos');
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR success created.'));
				return $this->redirect(['view', 'id'=>$model->id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Create KCKR');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Kckrs model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$model->photos = UploadedFile::getInstance($model, 'photos');
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR success updated.'));
				return $this->redirect(['update', 'id'=>$model->id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->subMenu = $this->module->params['kckr_submenu'];
		$this->view->title = Yii::t('app', 'Update KCKR: {publisher-id}', ['publisher-id' => $model->publisher->publisher_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single Kckrs model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->subMenu = $this->module->params['kckr_submenu'];
		$this->view->title = Yii::t('app', 'Detail KCKR: {publisher-id}', ['publisher-id' => $model->publisher->publisher_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Kckrs model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish','modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR success deleted.'));
			return $this->redirect(['manage']);
		}
	}

	/**
	 * actionPublish an existing Kckrs model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

		if($model->save(false, ['publish','modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR success updated.'));
			return $this->redirect(['manage']);
		}
	}

	/**
	 * Finds the Kckrs model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Kckrs the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Kckrs::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}

	/**
	 * Prints an existing Kckrs model.
	 * If print is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPrint($id)
	{
		$model = $this->findModel($id);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'KCKR success generated document.'));
				return $this->redirect(['manage']);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->subMenu = $this->module->params['kckr_submenu'];
		$this->view->title = Yii::t('app', 'Print KCKR: {publisher-id}', ['publisher-id' => $model->publisher->publisher_name]);
		$this->view->description = Yii::t('app', 'Are you sure you want to generated document print?');
		$this->view->keywords = '';
		return $this->oRender('admin_print', [
			'model' => $model,
		]);
	}
}