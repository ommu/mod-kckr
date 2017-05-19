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
 *	Print
 *	Generate
 *	Article
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
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
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
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
				'actions'=>array('manage','add','edit','view','runaction','delete','publish','print','generate','article'),
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
	 * Lists all models.
	 */
	public function actionPrint($id) 
	{
		$model=$this->loadModel($id);
		$condition = in_array($model->thanks_date, array('0000-00-00', '1970-01-01')) && $model->thanks_document == '' ? false : true;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(!$model->getErrors()) {
			$thanks_document = $model->thanks_document;
		}
		
		if(isset($_POST['Kckrs'])) {
			$model->attributes=$_POST['Kckrs'];
			$model->scenario = 'generateDocument';
			
			if($model->save()) {
				ini_set('max_execution_time', 0);
				ob_start();
				
				if($condition == false || ($condition == true && $model->regenerate_input == 1)) {
					$documentArray = array();
					
					$letter_template = 'document_letter';
					$letter_path = YiiBase::getPathOfAlias('webroot.public.kckr.document_pdf');
					// Add directory
					if(!file_exists($letter_path)) {
						@mkdir($letter_path, 0755, true);

						// Add file in directory (index.php)
						$newFile = $letter_path.'/index.php';
						$FileHandle = fopen($newFile, 'w');
					} else
						@chmod($letter_path, 0755, true);
					
					$letter_documentName = Utility::getUrlTitle($model->kckr_id.' '.$model->publisher->publisher_name.' '.$model->receipt_date);
					
					$letters = new KckrUtility();
					$fileName = $letters->getPdf($model, false, $letter_template, $letter_path, $letter_documentName, null, false);
					array_push($documentArray, $fileName);
					
					$attachment = $model->media_publish;
					if(!empty($attachment)) {
						$attachment_template = 'document_lampiran';
						$attachment_path = YiiBase::getPathOfAlias('webroot.public.kckr.document_pdf');
						$attachment_documentName = Utility::getUrlTitle($model->kckr_id.' lampiran '.$model->publisher->publisher_name.' '.$model->receipt_date);
						
						$attachments = new KckrUtility();
						$fileName = $attachments->getPdf($attachment, false, $attachment_template, $attachment_path, $attachment_documentName, 'L', false);
						array_push($documentArray, $fileName);
					}
					
					if(Kckrs::model()->updateByPk($model->kckr_id, array(
						'thanks_document'=>serialize($documentArray),
						'thanks_user_id'=>Yii::app()->user->id,
					))) {
						$letter_path = 'public/kckr/document_pdf';		
						$data = unserialize($thanks_document);
						
						if(!empty($data)) {
							foreach($data as $key => $val) {
								if(file_exists($letter_path.'/'.$val))
									rename($letter_path.'/'.$val, 'public/kckr/verwijderen/'.$model->kckr_id.'_'.$val);
							}
						}
					}
				}
				
				Yii::app()->user->setFlash('success', 'Generate document print success.');
				$this->redirect(Yii::app()->controller->createUrl('print', array('id'=>$model->kckr_id)));
	
				ob_end_flush();
			}
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 550;

		$this->pageTitle = Yii::t('phrase', 'Print Kckrs');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_print',array(
			'model'=>$model,
			'condition'=>$condition,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionGenerate() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$criteria=new CDbCriteria;
		$criteria->addNotInCondition('thanks_date', array('0000-00-00', '1970-01-01'));
		$model = Kckrs::model()->findAll($criteria);
		
		if($model != null) {
			foreach($model as $key => $item) {		
				if($item->thanks_document != '') {
					$thanks_document = $item->thanks_document;
				}
				
				$documentArray = array();
				
				$letter_template = 'document_letter';
				$letter_path = YiiBase::getPathOfAlias('webroot.public.kckr.document_pdf');
				$letter_documentName = Utility::getUrlTitle($item->kckr_id.' '.$item->publisher->publisher_name.' '.$item->receipt_date);
				
				$letters = new KckrUtility();
				$fileName = $letters->getPdf($item, false, $letter_template, $letter_path, $letter_documentName, null, false);
				array_push($documentArray, $fileName);
				
				$attachment = $item->media_publish;
				if(!empty($attachment)) {
					$attachment_template = 'document_lampiran';
					$attachment_path = YiiBase::getPathOfAlias('webroot.public.kckr.document_pdf');
					// Add directory
					if(!file_exists($attachment_path)) {
						@mkdir($attachment_path, 0755, true);

						// Add file in directory (index.php)
						$newFile = $attachment_path.'/index.php';
						$FileHandle = fopen($newFile, 'w');
					} else
						@chmod($attachment_path, 0755, true);
					
					$attachment_documentName = Utility::getUrlTitle($item->kckr_id.' lampiran '.$item->publisher->publisher_name.' '.$item->receipt_date);
					
					$attachments = new KckrUtility();
					$fileName = $attachments->getPdf($attachment, false, $attachment_template, $attachment_path, $attachment_documentName, 'L', false);
					array_push($documentArray, $fileName);
				}
				
				if(Kckrs::model()->updateByPk($item->kckr_id, array(
					'thanks_document'=>serialize($documentArray),
					'thanks_user_id'=>Yii::app()->user->id,
				))) {
					$letter_path = 'public/kckr/document_pdf';		
					$data = unserialize($thanks_document);
					
					if(!empty($data)) {
						foreach($data as $key => $val) {
							if(file_exists($letter_path.'/'.$val))
								rename($letter_path.'/'.$val, 'public/kckr/verwijderen/'.$item->kckr_id.'_'.$val);
						}
					}
				}
			}
		}
		
		echo Yii::t('phrase', 'Generated document print success.');

		ob_end_flush();
	}
	
	/**
	 * Lists all models.
	 */
	public function actionArticle() 
	{
		Yii::import('application.modules.article.models.ArticleCategory');
		Yii::import('application.modules.article.models.ArticleMedia');
		Yii::import('application.modules.article.models.Articles');
		Yii::import('application.modules.article.models.ArticleSetting');
		Yii::import('application.modules.article.models.ArticleTag');
		Yii::import('application.modules.article.models.ViewArticleCategory');
		Yii::import('application.modules.article.models.ViewArticles');
		
		$id = $_GET['id'];
		$articleId = $_GET['aid'];
		
		$articleSetting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'meta_keyword, type_active, headline, media_limit, media_file_type, upload_file_type',
		));
		$media_file_type = unserialize($articleSetting->media_file_type);
		if(empty($media_file_type))
			$media_file_type = array();
		$upload_file_type = unserialize($articleSetting->upload_file_type);
		if(empty($upload_file_type))
			$upload_file_type = array();
		$kckrSetting = KckrSetting::model()->findByPk(1,array(
			'select' => 'article_cat_id',
		));
		
		if(!isset($articleId))
			$model=new Articles;
		else
			$model = Articles::model()->findByPk($articleId);		
		$kckr = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Articles'])) {
			$model->attributes=$_POST['Articles'];
			$model->scenario = 'formStandard';

			if($model->save()) {
				if($model->isNewRecord)
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'KCKR Article success created.'));
				else
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'KCKR Article success updated.'));
				
				Kckrs::model()->updateByPk($kckr->kckr_id, array(
					'article_id'=>$model->article_id,
				));
					
				$this->redirect(array('article','id'=>$kckr->kckr_id,'aid'=>$model->article_id));
			}
		}

		$this->pageTitle = $model->isNewRecord ? Yii::t('phrase', 'Create Article: {title}', array('{title}'=>$kckr->publisher->publisher_name)) : Yii::t('phrase', 'Update Article: {title}', array('{title}'=>$model->title));
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_article',array(
			'model'=>$model,
			'kckr'=>$kckr,
			'articleSetting'=>$articleSetting,
			'kckrSetting'=>$kckrSetting,
			'media_file_type'=>$media_file_type,
			'upload_file_type'=>$upload_file_type,
		));		
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
