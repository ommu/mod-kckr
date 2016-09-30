<?php
/**
 * MediaController
 * @var $this MediaController
 * @var $model KckrMedia
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Import
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
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class MediaController extends Controller
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
			if(in_array(Yii::app()->user->level, array(1,2))) {
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
				'actions'=>array('manage','import','add','edit','view','runaction','delete','publish'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
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
		$model=new KckrMedia('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KckrMedia'])) {
			$model->attributes=$_GET['KckrMedia'];
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

		$this->pageTitle = Yii::t('phrase', 'Kckr Medias Manage');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionImport() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$path = 'public/kckr/import';

		// Generate path directory
		if(!file_exists($path)) {
			@mkdir($path, 0755, true);

			// Add File in Article Folder (index.php)
			$newFile = $path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
		} else
			@chmod($path, 0755, true);
		
		$error = array();
		
		$kckrID = $_GET['id'];
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$kckrID));
		else
			$url = Yii::app()->controller->createUrl('manage');
		
		if(isset($_FILES['importExcel'])) {
			$fileName = CUploadedFile::getInstanceByName('importExcel');
			if(in_array(strtolower($fileName->extensionName), array('xls','xlsx'))) {
				$file = time().'_archive_'.$fileName->name;
				if($fileName->saveAs($path.'/'.$file)) {
					Yii::import('ext.excel_reader.OExcelReader');
					$xls = new OExcelReader($path.'/'.$file);
					
					for ($row = 2; $row <= $xls->sheets[0]['numRows']; $row++) {
						$category_id			= trim($xls->sheets[0]['cells'][$row][1]);
						$media_title			= trim($xls->sheets[0]['cells'][$row][2]);
						$media_desc				= trim($xls->sheets[0]['cells'][$row][3]);
						$media_publish_year		= trim($xls->sheets[0]['cells'][$row][4]);
						$media_author			= trim($xls->sheets[0]['cells'][$row][5]);
						$media_total			= trim($xls->sheets[0]['cells'][$row][6]);
						
						$model=new KckrMedia;
						$model->kckr_id = $kckrID;
						$model->category_id = $category_id != '' ? $category_id : 1;
						$model->media_title = $media_title;
						$model->media_desc = $media_desc;
						$model->media_publish_year = $media_publish_year;
						$model->media_author = $media_author;
						$model->media_total = $media_total;
						$model->save();
					}
					
					Yii::app()->user->setFlash('success', 'Import Daftar Karya Success.');
					$this->redirect($url);
					
				} else
					Yii::app()->user->setFlash('errorFile', 'Gagal menyimpan file.');
			} else
				Yii::app()->user->setFlash('errorFile', 'Hanya file .xls dan .xlsx yang dibolehkan.');
		}

		ob_end_flush();
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $url;
		$this->dialogWidth = 600;

		$this->pageTitle = 'Import Archive';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_import');
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$kckrID = $_GET['id'];
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$kckrID));
		else
			$url = Yii::app()->controller->createUrl('manage');

		$category = KckrCategory::getCategory();		
		$model=new KckrMedia;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['KckrMedia'])) {
			$model->attributes=$_POST['KckrMedia'];
			
			if(isset($kckrID))
				$model->kckr_id = $kckrID;
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
							'id' => 'partial-kckr-media',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'KckrMedia success created.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $url;
		$this->dialogWidth = 600;

		$this->pageTitle = Yii::t('phrase', 'Create Kckr Medias');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'category'=>$category,
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$category = KckrCategory::getCategory();
		$model=$this->loadModel($id);
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$model->kckr_id));
		else
			$url = Yii::app()->controller->createUrl('manage');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['KckrMedia'])) {
			$model->attributes=$_POST['KckrMedia'];
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
							'id' => 'partial-kckr-media',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'KckrMedia success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $url;
		$this->dialogWidth = 600;

		$this->pageTitle = Yii::t('phrase', 'Update Kckr Medias');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'category'=>$category,
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$model->kckr_id));
		else
			$url = Yii::app()->controller->createUrl('manage');
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $url;
		$this->dialogWidth = 550;

		$this->pageTitle = Yii::t('phrase', 'View Kckr Medias');
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
				KckrMedia::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				KckrMedia::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				KckrMedia::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				KckrMedia::model()->deleteAll($criteria);
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
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$model->kckr_id));
		else
			$url = Yii::app()->controller->createUrl('manage');
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => $url,
						'id' => 'partial-kckr-media',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'KckrMedia success deleted.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = $url;
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'KckrMedia Delete.');
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
		if(isset($_GET['type']) && $_GET['type'] == 'update')
			$url = Yii::app()->controller->createUrl('o/admin/edit', array('id'=>$model->kckr_id));
		else
			$url = Yii::app()->controller->createUrl('manage');
		
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
						'get' => $url,
						'id' => 'partial-kckr-media',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'KckrMedia success updated.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = $url;
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
		$model = KckrMedia::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kckr-media-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
