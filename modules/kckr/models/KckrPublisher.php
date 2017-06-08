<?php
/**
 * KckrPublisher
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
 * This is the model class for table "ommu_kckr_publisher".
 *
 * The followings are the available columns in table 'ommu_kckr_publisher':
 * @property string $publisher_id
 * @property integer $publish
 * @property string $publisher_name
 * @property integer $publisher_area
 * @property string $publisher_address
 * @property string $publisher_phone
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuKckrs[] $ommuKckrs
 */
class KckrPublisher extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $creation_search;
	public $modified_search;
	public $kckr_search;
	public $media_search;
	public $item_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrPublisher the static model class
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
		return 'ommu_kckr_publisher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publisher_name', 'required'),
			array('publisher_area', 'required', 'on'=>'adminAdd, adminEdit'),
			array('publisher_address, publisher_phone', 'required', 'on'=>'adminEdit'),
			array('publish, publisher_area', 'numerical', 'integerOnly'=>true),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('publisher_area, publisher_address, publisher_phone', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('publisher_id, publish, publisher_name, publisher_area, publisher_address, publisher_phone, creation_date, creation_id, modified_date, modified_id, 
				creation_search, modified_search, kckr_search, media_search, item_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewKckrPublisher', 'publisher_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'kckr' => array(self::HAS_MANY, 'Kckrs', 'publisher_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'publish' => Yii::t('attribute', 'Publish'),
			'publisher_name' => Yii::t('attribute', 'Publisher'),
			'publisher_area' => Yii::t('attribute', 'Area'),
			'publisher_address' => Yii::t('attribute', 'Address'),
			'publisher_phone' => Yii::t('attribute', 'Phone'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'kckr_search' => Yii::t('attribute', 'KCKR'),
			'media_search' => Yii::t('attribute', 'Karya'),
			'item_search' => Yii::t('attribute', 'Item'),
		);
		/*
			'Publisher' => 'Publisher',
			'Publish' => 'Publish',
			'Publisher Name' => 'Publisher Name',
			'Publisher Area' => 'Publisher Area',
			'Publisher Address' => 'Publisher Address',
			'Publisher Phone' => 'Publisher Phone',
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

		$criteria->compare('t.publisher_id',$this->publisher_id);
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
		$criteria->compare('t.publisher_name',strtolower($this->publisher_name),true);
		$criteria->compare('t.publisher_area',$this->publisher_area);
		$criteria->compare('t.publisher_address',strtolower($this->publisher_address),true);
		$criteria->compare('t.publisher_phone',strtolower($this->publisher_phone),true);
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
		
		$criteria->compare('creation.displayname',strtolower($this->creation_search),true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search),true);
		$criteria->compare('view.kckrs',$this->kckr_search);
		$criteria->compare('view.medias',$this->media_search);
		$criteria->compare('view.media_items',$this->item_search);

		if(!isset($_GET['KckrPublisher_sort']))
			$criteria->order = 't.publisher_id DESC';

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
			//$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'publisher_name';
			$this->defaultColumns[] = 'publisher_area';
			$this->defaultColumns[] = 'publisher_address';
			$this->defaultColumns[] = 'publisher_phone';
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
			$this->defaultColumns[] = 'publisher_name';
			$this->defaultColumns[] = array(
				'name' => 'publisher_area',
				'value' => '$data->publisher_area == 1 ? Yii::t(\'phrase\', \'Yogyakarta\') : Yii::t(\'phrase\', \'Luar Yogyakarta\')',
				'filter'=>array(
					1=>Yii::t('phrase', 'Yogyakarta'),
					0=>Yii::t('phrase', 'Luar Yogyakarta'),
				),
				'type' => 'raw',
			);
			//$this->defaultColumns[] = 'publisher_address';
			//$this->defaultColumns[] = 'publisher_phone';
			$this->defaultColumns[] = array(
				'name' => 'kckr_search',
				'value' => 'CHtml::link($data->view->kckrs ? $data->view->kckrs : 0, Yii::app()->controller->createUrl("o/admin/manage",array(\'publisher\'=>$data->publisher_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'media_search',
				'value' => 'CHtml::link($data->view->medias ? $data->view->medias : 0, Yii::app()->controller->createUrl("o/media/manage",array(\'publisher\'=>$data->publisher_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'item_search',
				'value' => '$data->view->media_items ? $data->view->media_items : 0',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->publisher_id)), $data->publish, 1)',
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
	 * Get Publisher
	 */
	public static function getPublisher($publish=null, $type=null) 
	{		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('publish',$publish);
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val)
					$items[$val->publisher_id] = $val->publisher_name;
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
		}
		return true;
	}

}