<?php
/**
 * KckrSetting
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 16 September 2016, 23:06 WIB
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
 * This is the model class for table "ommu_kckr_setting".
 *
 * The followings are the available columns in table 'ommu_kckr_setting':
 * @property integer $id
 * @property string $license
 * @property integer $permission
 * @property string $meta_keyword
 * @property string $meta_description
 * @property integer $photo_resize 
 * @property string $photo_resize_size
 * @property string $photo_view_size
 * @property integer $article_sync 
 * @property string $article_cat_id
 * @property string $modified_date
 * @property string $modified_id
 */
class KckrSetting extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrSetting the static model class
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
		return 'ommu_kckr_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('license, permission, meta_keyword, meta_description, photo_resize, article_sync, article_cat_id', 'required'),
			array('permission, photo_resize, article_sync', 'numerical', 'integerOnly'=>true),
			array('license', 'length', 'max'=>32),
			array('modified_id', 'length', 'max'=>11),
			array('photo_resize_size, photo_view_size', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, license, permission, meta_keyword, meta_description, photo_resize, photo_resize_size, photo_view_size, article_sync, article_cat_id, modified_date, modified_id,
				modified_search', 'safe', 'on'=>'search'),
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
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'license' => Yii::t('attribute', 'License'),
			'permission' => Yii::t('attribute', 'Permission'),
			'meta_keyword' => Yii::t('attribute', 'Meta Keyword'),
			'meta_description' => Yii::t('attribute', 'Meta Description'),
			'photo_resize' => Yii::t('attribute', 'Photo Resize'),
			'photo_resize_size' => Yii::t('attribute', 'Photo Resize Size'),
			'photo_view_size' => Yii::t('attribute', 'Photo View Size'),
			'article_sync' => Yii::t('attribute', 'Article Sync'),
			'article_cat_id' => Yii::t('attribute', 'Article Category'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
		/*
			'ID' => 'ID',
			'License' => 'License',
			'Permission' => 'Permission',
			'Meta Keyword' => 'Meta Keyword',
			'Meta Description' => 'Meta Description',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.license',strtolower($this->license),true);
		$criteria->compare('t.permission',$this->permission);
		$criteria->compare('t.meta_keyword',strtolower($this->meta_keyword),true);
		$criteria->compare('t.meta_description',strtolower($this->meta_description),true);
		$criteria->compare('t.photo_resize',$this->photo_resize);
		$criteria->compare('t.photo_resize_size',$this->photo_resize_size);
		$criteria->compare('t.photo_view_size',$this->photo_view_size);
		$criteria->compare('t.article_sync',$this->article_sync);
		$criteria->compare('t.article_cat_id',$this->article_cat_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		
		// Custom Search
		$criteria->with = array(
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);
		$criteria->compare('modified_relation.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['KckrSetting_sort']))
			$criteria->order = 't.id DESC';

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'license';
			$this->defaultColumns[] = 'permission';
			$this->defaultColumns[] = 'meta_keyword';
			$this->defaultColumns[] = 'meta_description';
			$this->defaultColumns[] = 'photo_resize';
			$this->defaultColumns[] = 'photo_resize_size';
			$this->defaultColumns[] = 'photo_view_size';
			$this->defaultColumns[] = 'article_sync';
			$this->defaultColumns[] = 'article_cat_id';
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
			$this->defaultColumns[] = 'license';
			$this->defaultColumns[] = 'permission';
			$this->defaultColumns[] = 'meta_keyword';
			$this->defaultColumns[] = 'meta_description';
			$this->defaultColumns[] = 'photo_resize';
			$this->defaultColumns[] = 'photo_resize_size';
			$this->defaultColumns[] = 'photo_view_size';
			$this->defaultColumns[] = 'article_sync';
			$this->defaultColumns[] = 'article_cat_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = array(
				'name' => 'modified_search',
				'value' => '$data->modified->displayname',
			);
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {			
			if($this->photo_resize == 1 && ($this->photo_resize_size['width'] == '' || $this->photo_resize_size['height'] == ''))
				$this->addError('photo_resize_size', Yii::t('phrase', 'Photo Resize cannot be blank.'));
			
			if($this->photo_view_size['large']['width'] == '' || $this->photo_view_size['large']['height'] == '')
				$this->addError('photo_view_size[large]', Yii::t('phrase', 'Large Size cannot be blank.'));
			
			if($this->photo_view_size['medium']['width'] == '' || $this->photo_view_size['medium']['height'] == '')
				$this->addError('photo_view_size[medium]', Yii::t('phrase', 'Medium Size cannot be blank.'));
			
			if($this->photo_view_size['small']['width'] == '' || $this->photo_view_size['small']['height'] == '')
				$this->addError('photo_view_size[small]', Yii::t('phrase', 'Small Size cannot be blank.'));
			
			$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		$controller = strtolower(Yii::app()->controller->id);
		if(parent::beforeSave()) {
			$this->photo_resize_size = serialize($this->photo_resize_size);
			$this->photo_view_size = serialize($this->photo_view_size);
		}
		return true;
	}

}