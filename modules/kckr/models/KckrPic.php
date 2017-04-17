<?php
/**
 * KckrPic
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:37 WIB
 * @link http://company.ommu.co
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
 * This is the model class for table "ommu_kckr_pic".
 *
 * The followings are the available columns in table 'ommu_kckr_pic':
 * @property integer $pic_id
 * @property integer $publish
 * @property string $pic_name
 * @property string $pic_nip
 * @property string $pic_position
 * @property string $pic_signature
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuKckrs[] $ommuKckrs
 */
class KckrPic extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_pic_signature;
	
	// Variable Search
	public $creation_search;
	public $modified_search;
	public $kckr_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrPic the static model class
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
		return 'ommu_kckr_pic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pic_name', 'required'),
			array('pic_nip, pic_position', 'required', 'on'=>'adminAdd, adminEdit'),
			array('publish, default', 'numerical', 'integerOnly'=>true),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('pic_nip', 'length', 'max'=>32),
			array('pic_name, pic_position', 'length', 'max'=>64),
			array('pic_nip, pic_position, pic_signature,
				old_pic_signature', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pic_id, publish, default, pic_name, pic_nip, pic_position, pic_signature, creation_date, creation_id, modified_date, modified_id, 
				creation_search, modified_search, kckr_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewKckrPic', 'pic_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'kckr' => array(self::HAS_MANY, 'Kckrs', 'pic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pic_id' => Yii::t('attribute', 'Pic'),
			'publish' => Yii::t('attribute', 'Publish'),
			'default' => Yii::t('attribute', 'Default'),
			'pic_name' => Yii::t('attribute', 'Person in Charge'),
			'pic_nip' => Yii::t('attribute', 'NIP'),
			'pic_position' => Yii::t('attribute', 'Position'),
			'pic_signature' => Yii::t('attribute', 'Signature'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'old_pic_signature' => Yii::t('attribute', 'Old Signature'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'kckr_search' => Yii::t('attribute', 'KCKR'),
		);
		/*
			'Pic' => 'Pic',
			'Publish' => 'Publish',
			'Pic Name' => 'Pic Name',
			'Pic Nip' => 'Pic Nip',
			'Pic Position' => 'Pic Position',
			'Creation Date' => 'Creation Date',
			'Creation' => 'Creation',
			'Modified Date' => 'Modified Date',
			'Modified' => 'Modified',
		
		*/
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

		$criteria->compare('t.pic_id',$this->pic_id);
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
		$criteria->compare('t.default',$this->default);
		$criteria->compare('t.pic_name',strtolower($this->pic_name),true);
		$criteria->compare('t.pic_nip',strtolower($this->pic_nip),true);
		$criteria->compare('t.pic_position',strtolower($this->pic_position),true);
		$criteria->compare('t.pic_signature',strtolower($this->pic_signature),true);
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
		
		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
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
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);
		$criteria->compare('view.kckrs',strtolower($this->kckr_search), true);

		if(!isset($_GET['KckrPic_sort']))
			$criteria->order = 't.pic_id DESC';

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
			//$this->defaultColumns[] = 'pic_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'default';
			$this->defaultColumns[] = 'pic_name';
			$this->defaultColumns[] = 'pic_nip';
			$this->defaultColumns[] = 'pic_position';
			$this->defaultColumns[] = 'pic_signature';
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
	protected function afterConstruct() {
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
			$this->defaultColumns[] = 'pic_name';
			$this->defaultColumns[] = 'pic_nip';
			$this->defaultColumns[] = 'pic_position';
			$this->defaultColumns[] = array(
				'name' => 'kckr_search',
				'value' => 'CHtml::link($data->view->kckrs, Yii::app()->controller->createUrl("o/admin/manage",array(\'pic\'=>$data->pic_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'default',
					'value' => '$data->default == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->pic_id)), $data->publish, 1)',
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
	 * Get PIC
	 */
	public static function getPIC($publish=null, $type=null) 
	{		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('t.publish',$publish);
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val)
					$items[$val->pic_id] = $val->pic_name.' ('.$val->pic_position.')';
				return $items;
				
			} else
				return false;
			
		} else
			return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;
			
			$pic_signature = CUploadedFile::getInstance($this, 'pic_signature');
			if($pic_signature->name != '') {
				$extension = pathinfo($pic_signature->name, PATHINFO_EXTENSION);
				$size = getimagesize($pic_signature->tempName);
				
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('photos', 'The file "'.$pic_signature->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
				else {
					if($size[0] != 250 && $size[1] != 150)
						$this->addError('pic_signature', 'The file "'.$pic_signature->name.'" cannot be uploaded. ukuran tanta tangan ('.$size[0].' x '.$size[1].') tidak sesuai seharusnya (250 x 150)');
				}
			}
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
				$pic_path = 'public/kckr/pic';
				// Generate kckr path directory
				if(!file_exists($pic_path)) {
					@mkdir($pic_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $pic_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($pic_path, 0755, true);
				
				$this->pic_signature = CUploadedFile::getInstance($this, 'pic_signature');
				if($this->pic_signature instanceOf CUploadedFile) {
					$fileName = $this->pic_id.'_'.time().'_'.Utility::getUrlTitle($this->pic_name).'.'.strtolower($this->pic_signature->extensionName);
					if($this->pic_signature->saveAs($pic_path.'/'.$fileName)) {
						if($this->old_pic_signature != '' && file_exists($pic_path.'/'.$this->old_pic_signature))
							rename($pic_path.'/'.$this->old_pic_signature, 'public/kckr/verwijderen/'.$this->old_pic_signature);
						$this->pic_signature = $fileName;
					} else
						$this->pic_signature = '';
				}
					
				if($this->pic_signature == '')
					$this->pic_signature = $this->old_pic_signature;
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		
		if($this->isNewRecord) {
			$pic_path = 'public/kckr/pic';
			// Generate kckr path directory
			if(!file_exists($pic_path)) {
				@mkdir($pic_path, 0755, true);

				// Add file in directory (index.php)
				$newFile = $pic_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($pic_path, 0755, true);
			
			$this->pic_signature = CUploadedFile::getInstance($this, 'pic_signature');
			if($this->pic_signature instanceOf CUploadedFile) {
				$fileName = $this->pic_id.'_'.time().'_'.Utility::getUrlTitle($this->pic_name).'.'.strtolower($this->pic_signature->extensionName);
				if($this->pic_signature->saveAs($pic_path.'/'.$fileName)) {
					self::model()->updateByPk($this->pic_id, array('pic_signature'=>$fileName));
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
		$pic_path = 'public/kckr/pic';
		if($this->pic_signature != '' && file_exists($pic_path.'/'.$this->pic_signature))
			rename($pic_path.'/'.$this->pic_signature, 'public/kckr/verwijderen/'.$this->pic_signature);
	}

}