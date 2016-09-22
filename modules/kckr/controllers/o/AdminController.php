<?php
/**
 * AdminController
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Edit
 *	View
 *	RunAction
 *	Delete
 *	Publish
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class AdminController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(Yii::app()->user->level == 1) {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else {
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		} else {
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','edit','view','runaction','delete','publish'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('manage'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new Kckrs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Kckrs'])) {
			$model->attributes=$_GET['Kckrs'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = Yii::t('phrase', 'Kckrs Manage');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new Kckrs;
		$pic=new KckrPic;
		$publisher=new KckrPublisher;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$this->performAjaxValidation($pic);
		$this->performAjaxValidation($publisher);

		if(isset($_POST['Kckrs'])) {
			$model->attributes=$_POST['Kckrs'];
			$pic->attributes=$_POST['KckrPic'];
			$publisher->attributes=$_POST['KckrPublisher'];
			$pic->validate();
			$publisher->validate();
			
			if($model->validate() && $pic->validate() && $publisher->validate()) {
				//if($model->publisher_id != '' && $model->publisher_id != 0) {
					$publisherFind = KckrPublisher::model()->find(array(
						'select' => 'publisher_id, publisher_name',
						'condition' => 'publisher_name = :publisher',
						'params' => array(
							':publisher' => $publisher->publisher_name,
						),
					));
					if($publisherFind != null)
						$model->publisher_id = $publisherFind->publisher_id;
					else {
						if($publisher->save())
							$model->publisher_id = $publisher->publisher_id;
					}
				//}
				
				//if($model->pic_id != '' && $model->pic_id != 0) {
					$picFind = KckrPic::model()->find(array(
						'select' => 'pic_id, pic_name',
						'condition' => 'pic_name = :pic',
						'params' => array(
							':pic' => $pic->pic_name,
						),
					));
					if($picFind != null)
						$model->pic_id = $picFind->pic_id;
					else {
						if($pic->save())
							$model->pic_id = $pic->pic_id;
					}
				//}
				
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'Kckrs success created.'));
					$this->redirect(array('edit','id'=>$model->kckr_id));
				}
				
			}
		}

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = Yii::t('phrase', 'Create Kckrs');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'model'=>$model,
			'pic'=>$pic,
			'publisher'=>$publisher,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model = $this->loadModel($id);
		$pic = KckrPic::model()->findByPk($model->pic_id);
		$publisher = KckrPublisher::model()->findByPk($model->publisher_id);	
		
		$media=new KckrMedia('searchKckrEdit');
		$media->unsetAttributes();  // clear any default values
		if(isset($_GET['KckrMedia'])) {
			$media->attributes=$_GET['KckrMedia'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $media->getGridColumn($columnTemp);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$this->performAjaxValidation($pic);
		$this->performAjaxValidation($publisher);
			
		if(!$model->getErrors()) {
			$pic_id = $model->pic_id;
			$pic_name = $pic->pic_name;
			$publisher_id = $model->publisher_id;
			$publisher_name = $publisher->publisher_name;
		}

		if(isset($_POST['Kckrs'])) {
			$model->attributes=$_POST['Kckrs'];
			$pic->attributes=$_POST['KckrPic'];
			$publisher->attributes=$_POST['KckrPublisher'];
			$pic->validate();
			$publisher->validate();

			if($model->validate() && $pic->validate() && $publisher->validate()) {				
				if($publisher_id != $model->publisher_id || $publisher_name != $publisher->publisher_name) {
					//if($model->publisher_id != '' && $model->publisher_id != 0) {
						$publisherFind = KckrPublisher::model()->find(array(
							'select' => 'publisher_id, publisher_name',
							'condition' => 'publisher_name = :publisher',
							'params' => array(
								':publisher' => $publisher->publisher_name,
							),
						));
						if($publisherFind != null)
							$model->publisher_id = $publisherFind->publisher_id;
						else {
							$publishers=new KckrPublisher;
							$publishers->publisher_name = $publisher->publisher_name;
							if($publishers->save())
								$model->publisher_id = $publishers->publisher_id;
						}
					//}
				}
				
				if($pic_id != $model->pic_id || $pic_name != $pic->pic_name) {
					//if($model->pic_id != '' && $model->pic_id != 0) {
						$picFind = KckrPic::model()->find(array(
							'select' => 'pic_id, pic_name',
							'condition' => 'pic_name = :pic',
							'params' => array(
								':pic' => $pic->pic_name,
							),
						));
						if($picFind != null)
							$model->pic_id = $picFind->pic_id;
						else {
							$pics=new KckrPic;
							$pics->pic_name = $pic->pic_name;
							if($pics->save())
								$model->pic_id = $pics->pic_id;
						}
					//}
				}
				
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'Kckrs success updated.'));
					$this->redirect(array('manage'));
				}				
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Update Kckrs');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
			'pic'=>$pic,
			'publisher'=>$publisher,
			'media'=>$media,
			'columns' => $columns,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);

		$this->pageTitle = Yii::t('phrase', 'View Kckrs');
		$this->pageDescription = '';
		$this->pageMeta = $setting->meta_keyword;
		$this->render('admin_view',array(
			'model'=>$model,
		));
	}	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunAction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = $_GET['action'];

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				Kckrs::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				Kckrs::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				Kckrs::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				Kckrs::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-kckrs',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Kckrs success deleted.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Kckrs Delete.');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id) 
	{
		$model=$this->loadModel($id);
		
		if($model->publish == 1) {
			$title = Yii::t('phrase', 'Unpublish');
			$replace = 0;
		} else {
			$title = Yii::t('phrase', 'Publish');
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->publish = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-kckrs',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Kckrs success updated.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = $title;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_publish',array(
				'title'=>$title,
				'model'=>$model,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = Kckrs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='kckrs-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
