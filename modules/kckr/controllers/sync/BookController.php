<?php
/**
 * BookController
 * @var $this BookController
 * @var $model KckrBooks
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Indexing
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 16:44 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class BookController extends Controller
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
				'actions'=>array('indexing'),
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
		$this->redirect(Yii::app()->controller->createUrl('o/admin/index'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndexing() 
	{
		$id = $_GET['id'];
		ini_set('max_execution_time', 0);
		ob_start();
		
		$criteria=new CDbCriteria;
		if(isset($id)) {
			$criteria->condition = 'idsurat > :surat';
			$criteria->params = array(':surat'=>$id);
		}
		$model = KckrBooks::model()->findAll($criteria);
		echo '<pre>';
		//print_r($model);
		echo '</pre>';
		//exit();
		
		if($model != null) {
			$i;
			foreach($model as $key => $val) {
				$i++;
				if($val->kodepenerbit != null && $val->kodepenerbit != '') {
					$kckr=new Kckrs;
					$kckr->pic_id = 1;				
					
					//find publisher
					$publisherFind = KckrPublisher::model()->find(array(
						'select' => 'publisher_id, publisher_name',
						'condition' => 'publisher_name = :publisher',
						'params' => array(
							':publisher' => $val->publisher->penerbit,
						),
					));
					if($publisherFind == null) {
						$publisher=new KckrPublisher;
						$publisher->publisher_name = $val->publisher->penerbit;
						$publisher->publisher_area = $val->publisher->kodekota == 1 ? 1 : 0;
						if($val->publisher->alamat != null && $val->publisher->alamat != '')
							$publisher->publisher_address = $val->publisher->alamat;
						if($val->publisher->telepon != null && $val->publisher->telepon != '')
							$publisher->publisher_phone = $val->publisher->telepon;
						if($publisher->save())
							$kckr->publisher_id = $publisher->publisher_id;
					} else
						$kckr->publisher_id = $publisherFind->publisher_id;
					
					$kckr->letter_number = $val->nosurat != null && $val->nosurat != '' ? $val->nosurat : '-';
					if(($val->tglkirimpos != null && !in_array($val->tglkirimpos, array('0000-00-00 00:00:00', '1990-01-01 00:00:00'))) || ($val->tglkirimls != null && !in_array($val->tglkirimls, array('0000-00-00 00:00:00', '1990-01-01 00:00:00')))) {
						if($val->tglkirimpos != null && $val->tglkirimpos != '') {
							$kckr->send_type = 'pos';
							$kckr->send_date = date('Y-m-d', strtotime($val->tglkirimpos));
						} else {
							$kckr->send_type = 'langsung';
							$kckr->send_date = date('Y-m-d', strtotime($val->tglkirimls));
						}
					}
					$kckr->receipt_date = date('Y-m-d', strtotime($val->tglterima));
					if($val->ucapan != null && !in_array($val->ucapan, array('0000-00-00 00:00:00', '1990-01-01 00:00:00')))
						$kckr->thanks_date = date('Y-m-d', strtotime($val->ucapan));
					
					if($kckr->save()) {
						$books = $val->medias;
						if(!empty($books)) {
							foreach($books as $key => $row) {
								$media=new KckrMedia;
								$media->kckr_id = $kckr->kckr_id;
								if($row->kodejenis != null && $row->kodejenis != '')
									$media->category_id = $row->kodejenis;
								else
									$media->category_id = 1;
								$media->media_title = $row->judul != null && $row->judul != '' ? $row->judul : '-';
								$media->media_desc = $row->edisi_cet != null && $row->edisi_cet != '' ? $row->edisi_cet : '';
								$media->media_publish_year = $row->tahunterbit != null && $row->tahunterbit != '' ? $row->tahunterbit : '';
								$media->media_author = $row->pengarang1 != null && $row->pengarang1 != '' ? $row->pengarang1 : '';
								$media->media_total = $row->jml;
								$media->save();							
							}		
						}
						echo '<pre>';
						//print_r($books);
						echo '</pre>';
					}
				}
			}
			echo '<pre>';
			//print_r($model);
			echo '</pre>';
		}
		
		ob_end_flush();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = KckrBooks::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kckr-books-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
