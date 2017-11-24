<?php
/**
 * Kckrs
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:38 WIB
 * @link https://github.com/ommu/mod-kckr
 * @contact (+62)856-299-4114
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_kckrs".
 *
 * The followings are the available columns in table 'ommu_kckrs':
 * @property string $kckr_id
 * @property integer $publish
 * @property string $article_id
 * @property integer $pic_id
 * @property string $publisher_id
 * @property string $letter_number
 * @property string $send_type
 * @property string $send_date
 * @property string $receipt_date
 * @property string $thanks_date
 * @property string $thanks_document
 * @property string $thanks_user_id
 * @property string $photos
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property KckrMedia[] $KckrMedias
 * @property KckrPic $pic
 * @property KckrPublisher $publisher
 * @property KckrCategory $category
 */
class Kckrs extends CActiveRecord
{
	public $defaultColumns = array();
	public $photo_old_input;
	public $regenerate_input;
	
	// Variable Search
	public $pic_search;
	public $publisher_search;
	public $creation_search;
	public $modified_search;
	public $media_search;
	public $item_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kckrs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_kckrs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('letter_number, send_type, send_date, receipt_date', 'required'),
			array('thanks_date', 'required', 'on'=>'generateDocument'),
			array('publish, article_id, pic_id, publisher_id, thanks_user_id, creation_id, modified_id', 'numerical', 'integerOnly'=>true),
			array('article_id, pic_id, publisher_id, thanks_user_id, creation_id, modified_id', 'length', 'max'=>11),
			array('letter_number', 'length', 'max'=>64),
			array('article_id, pic_id, publisher_id, thanks_date, photos,
				photo_old_input, regenerate_input', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kckr_id, publish, article_id, pic_id, publisher_id, letter_number, send_type, send_date, receipt_date, thanks_date, thanks_document, thanks_user_id, photos, creation_date, creation_id, modified_date, modified_id, 
				pic_search, publisher_search, creation_search, modified_search, media_search, item_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'view' => array(self::BELONGS_TO, 'ViewKckrs', 'kckr_id'),
			'pic' => array(self::BELONGS_TO, 'KckrPic', 'pic_id'),
			'publisher' => array(self::BELONGS_TO, 'KckrPublisher', 'publisher_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'medias' => array(self::HAS_MANY, 'KckrMedia', 'kckr_id'),
			'media_publish' => array(self::HAS_MANY, 'KckrMedia', 'kckr_id', 'on'=>'media_publish.publish = 1'),
			'media_unpublish' => array(self::HAS_MANY, 'KckrMedia', 'kckr_id', 'on'=>'media_unpublish.publish = 0'),
			'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kckr_id' => Yii::t('attribute', 'Kckr'),
			'publish' => Yii::t('attribute', 'Publish'),
			'article_id' => Yii::t('attribute', 'Article'),
			'pic_id' => Yii::t('attribute', 'Pic'),
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'letter_number' => Yii::t('attribute', 'Letter Number'),
			'send_type' => Yii::t('attribute', 'Send Type'),
			'send_date' => Yii::t('attribute', 'Send Date'),
			'receipt_date' => Yii::t('attribute', 'Receipt Date'),
			'thanks_date' => Yii::t('attribute', 'Thanks Date'),
			'thanks_document' => Yii::t('attribute', 'Thanks Document'),
			'thanks_user_id' => Yii::t('attribute', 'Thanks User'),
			'photos' => Yii::t('attribute', 'Photo'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'pic_search' => Yii::t('attribute', 'Pic'),
			'publisher_search' => Yii::t('attribute', 'Publisher'),
			'photo_old_input' => Yii::t('attribute', 'Photo Old'),
			'regenerate_input' => Yii::t('attribute', 'Regenerate Document'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'media_search' => Yii::t('attribute', 'Karya'),
			'item_search' => Yii::t('attribute', 'Item'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'pic' => array(
				'alias'=>'pic',
				'select'=>'pic_name'
			),
			'publisher' => array(
				'alias'=>'publisher',
				'select'=>'publisher_name'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

		$criteria->compare('t.kckr_id',strtolower($this->kckr_id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		$criteria->compare('t.article_id',$this->article_id);
		if(isset($_GET['pic']))
			$criteria->compare('t.pic_id',$_GET['pic']);
		else
			$criteria->compare('t.pic_id',$this->pic_id);
		if(isset($_GET['publisher']))
			$criteria->compare('t.publisher_id',$_GET['publisher']);
		else
			$criteria->compare('t.publisher_id',$this->publisher_id);
		$criteria->compare('t.letter_number',strtolower($this->letter_number),true);
		$criteria->compare('t.send_type',$this->send_type);
		if($this->send_date != null && !in_array($this->send_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.send_date)',date('Y-m-d', strtotime($this->send_date)));
		if($this->receipt_date != null && !in_array($this->receipt_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.receipt_date)',date('Y-m-d', strtotime($this->receipt_date)));
		if($this->thanks_date != null && !in_array($this->thanks_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.thanks_date)',date('Y-m-d', strtotime($this->thanks_date)));
		$criteria->compare('t.thanks_document',strtolower($this->thanks_document),true);
		if(isset($_GET['thanks']))
			$criteria->compare('t.thanks_user_id',$_GET['thanks']);
		else
			$criteria->compare('t.thanks_user_id',$this->thanks_user_id);
		$criteria->compare('t.photos',strtolower($this->photos),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('pic.pic_name',strtolower($this->pic_search),true);
		$criteria->compare('publisher.publisher_name',strtolower($this->publisher_search),true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search),true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search),true);
		$criteria->compare('view.medias',$this->media_search);
		$criteria->compare('view.media_items',$this->item_search);

		if(!isset($_GET['Kckrs_sort']))
			$criteria->order = 't.kckr_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'kckr_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'article_id';
			$this->defaultColumns[] = 'pic_id';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'letter_number';
			$this->defaultColumns[] = 'send_type';
			$this->defaultColumns[] = 'send_date';
			$this->defaultColumns[] = 'receipt_date';
			$this->defaultColumns[] = 'thanks_date';
			$this->defaultColumns[] = 'thanks_document';
			$this->defaultColumns[] = 'thanks_user_id';
			$this->defaultColumns[] = 'photos';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() 
	{
		$setting = KckrSetting::model()->findByPk(1, array(
			'select' => 'gridview_column',
		));
		$gridview_column = unserialize($setting->gridview_column);		
		if(empty($gridview_column))
			$gridview_column = array();
		
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!isset($_GET['publisher'])) {
				$this->defaultColumns[] = array(
					'name' => 'publisher_search',
					'value' => '$data->publisher->publisher_name',
				);
			}
			if(in_array('letter_number', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'letter_number',
					'value' => '$data->letter_number',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'send_type',
				'value' => '$data->send_type == \'\' ? \'-\' : ($data->send_type == \'pos\' ? Yii::t(\'phrase\', \'Pos\') : Yii::t(\'phrase\', \'Langsung\'))',				
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					'pos'=>Yii::t('phrase', 'Pos'),
					'langsung'=>Yii::t('phrase', 'Langsung'),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'send_date',
				'value' => '!in_array($data->send_date, array(\'0000-00-00\', \'1970-01-01\')) ? Utility::dateFormat($data->send_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'send_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'receipt_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = array(
				'name' => 'receipt_date',
				'value' => '!in_array($data->receipt_date, array(\'0000-00-00\', \'1970-01-01\')) ? Utility::dateFormat($data->receipt_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'receipt_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'receipt_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(in_array('creation_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname',
				);
			}
			if(in_array('creation_date', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'creation_date',
					'value' => 'Utility::dateFormat($data->creation_date)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
						'model'=>$this,
						'attribute'=>'creation_date',
						'language' => 'en',
						'i18nScriptFile' => 'jquery-ui-i18n.min.js',
						//'mode'=>'datetime',
						'htmlOptions' => array(
							'id' => 'creation_date_filter',
						),
						'options'=>array(
							'showOn' => 'focus',
							'dateFormat' => 'dd-mm-yy',
							'showOtherMonths' => true,
							'selectOtherMonths' => true,
							'changeMonth' => true,
							'changeYear' => true,
							'showButtonPanel' => true,
						),
					), true),
				);
			}
			if(in_array('media_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'media_search',
					'value' => 'CHtml::link($data->view->medias ? $data->view->medias : 0, Yii::app()->controller->createUrl("o/media/manage",array(\'kckr\'=>$data->kckr_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if(in_array('item_search', $gridview_column)) {
				$this->defaultColumns[] = array(
					'name' => 'item_search',
					'value' => '$data->view->media_items ? $data->view->media_items : 0',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'header' => Yii::t('phrase', 'Print'),
				'value' =>  'CHtml::link(!in_array($data->thanks_date, array(\'0000-00-00\', \'1970-01-01\')) ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Yii::t(\'phrase\', \'Print\'), Yii::app()->controller->createUrl("print",array(\'id\'=>$data->kckr_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'article_id',
				'value' =>  'CHtml::link($data->article_id != 0 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Yii::t(\'phrase\', \'Article\'), $data->article_id != 0 ? Yii::app()->controller->createUrl(\'article\',array(\'id\'=>$data->kckr_id, \'aid\'=>$data->article_id)) : Yii::app()->controller->createUrl(\'article\',array(\'id\'=>$data->kckr_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->kckr_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

	/**
	 * Get Article
	 */
	public static function resizePhoto($photos, $size) {
		Yii::import('ext.phpthumb.PhpThumbFactory');
		$photoImg = PhpThumbFactory::create($photos, array('jpegQuality' => 90, 'correctPermissions' => true));
		if($size['height'] == 0)
			$photoImg->resize($size['width']);
		else
			$photoImg->adaptiveResize($size['width'], $size['height']);
		$photoImg->save($photos);
		
		return true;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {			
			$photo = CUploadedFile::getInstance($this, 'photos');
			if($photo->name != '') {
				$extension = pathinfo($photo->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('photos', 'The file "'.$photo->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
			
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {			
			$action = strtolower(Yii::app()->controller->action->id);
			if(!$this->isNewRecord && $action == 'edit') {
				//Update kckr photo
				$kckr_path = 'public/kckr';
				// Generate kckr path directory
				if(!file_exists($kckr_path)) {
					@mkdir($kckr_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $kckr_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($kckr_path, 0755, true);
				
				$this->photos = CUploadedFile::getInstance($this, 'photos');
				if($this->photos instanceOf CUploadedFile) {
					$fileName = $this->kckr_id.'_'.time().'_'.Utility::getUrlTitle($this->publisher->publisher_name).'.'.strtolower($this->photos->extensionName);
					if($this->photos->saveAs($kckr_path.'/'.$fileName)) {
						$setting = KckrSetting::getInfo(1);
						if($setting->photo_resize == 1)
							self::resizePhoto($kckr_path.'/'.$fileName, unserialize($setting->photo_resize_size));
						if($this->photo_old_input != '' && file_exists($kckr_path.'/'.$this->photo_old_input))
							rename($kckr_path.'/'.$this->photo_old_input, 'public/kckr/verwijderen/'.$this->kckr_id.'_'.$this->photo_old_input);
						$this->photos = $fileName;
					} else
						$this->photos = '';
				}
					
				if($this->photos == '')
					$this->photos = $this->photo_old_input;
			}
			$this->send_date = date('Y-m-d', strtotime($this->send_date));
			$this->receipt_date = date('Y-m-d', strtotime($this->receipt_date));
			$this->thanks_date = date('Y-m-d', strtotime($this->thanks_date));
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		
		if($this->isNewRecord) {
			$kckr_path = 'public/kckr';
			// Generate kckr path directory
			if(!file_exists($kckr_path)) {
				@mkdir($kckr_path, 0755, true);

				// Add file in directory (index.php)
				$newFile = $kckr_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($kckr_path, 0755, true);
			
			$this->photos = CUploadedFile::getInstance($this, 'photos');
			if($this->photos instanceOf CUploadedFile) {
				$fileName = $this->kckr_id.'_'.time().'_'.Utility::getUrlTitle($this->publisher->publisher_name).'.'.strtolower($this->photos->extensionName);
				if($this->photos->saveAs($kckr_path.'/'.$fileName)) {
					$setting = KckrSetting::getInfo(1);
					if($setting->photo_resize == 1)
						self::resizePhoto($kckr_path.'/'.$fileName, unserialize($setting->photo_resize_size));
					self::model()->updateByPk($this->kckr_id, array('photos'=>$fileName));
				}
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete kckr image
		$kckr_path = 'public/kckr';
		if($this->photos != '' && file_exists($kckr_path.'/'.$this->photos))
			rename($kckr_path.'/'.$this->photos, 'public/kckr/verwijderen/'.$this->kckr_id.'_'.$this->photos);
	}

}