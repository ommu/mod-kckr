<?php
/**
 * MediaController
 * @var $this ommu\kckr\controllers\o\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 *
 * MediaController implements the CRUD actions for KckrMedia model.
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
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\controllers\o;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\kckr\models\KckrMedia;
use ommu\kckr\models\search\KckrMedia as KckrMediaSearch;

class MediaController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();
		if(Yii::$app->request->get('id'))
			$this->subMenu = $this->module->params['kckr_submenu'];
		if(Yii::$app->request->get('publisher'))
			$this->subMenu = $this->module->params['publisher_submenu'];
	}

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
	 * Lists all KckrMedia models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new KckrMediaSearch();
		if(($id = Yii::$app->request->get('id')) != null)
			$searchModel = new KckrMediaSearch(['kckr_id'=>$id]);
		if(($publisher = Yii::$app->request->get('publisher')) != null)
			$searchModel = new KckrMediaSearch(['publisherId'=>$publisher]);
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

		if(($kckr = Yii::$app->request->get('kckr')) != null || ($kckr = Yii::$app->request->get('id')) != null)
			$kckr = \ommu\kckr\models\Kckrs::findOne($kckr);
		if(($category = Yii::$app->request->get('category')) != null)
			$category = \ommu\kckr\models\KckrCategory::findOne($category);
		if($publisher != null) {
			$this->subMenuParam = $publisher;
			$publisher = \ommu\kckr\models\KckrPublisher::findOne($publisher);
		}

		$this->view->title = Yii::t('app', 'Medias');
		if($category)
			$this->view->title = Yii::t('app', 'Medias: Category {category-name}', ['category-name'=>$category->category_name_i]);
		if($publisher)
			$this->view->title = Yii::t('app', 'Medias: Publisher {publisher-name}', ['publisher-name'=>$publisher->publisher_name]);

		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'kckr' => $kckr,
			'category' => $category,
			'publisher' => $publisher,
		]);
	}

	/**
	 * Creates a new KckrMedia model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		if(($id = Yii::$app->request->get('id')) == null)
			throw new \yii\web\NotAcceptableHttpException(Yii::t('app', 'The requested page does not exist.'));

		$model = new KckrMedia(['kckr_id'=>$id]);
		$this->subMenuParam = $model->kckr_id;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success created.'));
				return $this->redirect(['manage', 'id'=>$model->kckr_id]);
				//return $this->redirect(['view', 'id'=>$model->id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Create Media');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing KckrMedia model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->subMenuParam = $model->kckr_id;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success updated.'));
				if(!Yii::$app->request->isAjax)
					return $this->redirect(['update', 'id'=>$model->id]);
				return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'id'=>$model->kckr_id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Update Media: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single KckrMedia model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$this->subMenuParam = $model->kckr_id;

		$this->view->title = Yii::t('app', 'Detail Media: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing KckrMedia model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish','modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success deleted.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'id'=>$model->kckr_id]);
		}
	}

	/**
	 * actionPublish an existing KckrMedia model.
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
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success updated.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'id'=>$model->kckr_id]);
		}
	}

	/**
	 * Finds the KckrMedia model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return KckrMedia the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = KckrMedia::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}