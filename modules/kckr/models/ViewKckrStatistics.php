<?php
/**
 * ViewKckrStatistics
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 24 September 2016, 22:38 WIB
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
 * This is the model class for table "_view_kckr_statistics".
 *
 * The followings are the available columns in table '_view_kckr_statistics':
 * @property string $date_key
 * @property string $setting_update
 * @property string $category_insert
 * @property string $category_update
 * @property string $category_delete
 * @property string $pic_insert
 * @property string $pic_update
 * @property string $pic_delete
 * @property string $publisher_insert
 * @property string $publisher_update
 * @property string $publisher_delete
 * @property string $kckr_insert
 * @property string $kckr_update
 * @property string $kckr_delete
 * @property string $media_insert
 * @property string $media_update
 * @property string $media_delete
 * @property string $media_record
 * @property string $media_book
 */
class ViewKckrStatistics extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewKckrStatistics the static model class
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
		return '_view_kckr_statistics';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'date_key';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setting_update, category_insert, category_update, category_delete, pic_insert, pic_update, pic_delete, publisher_insert, publisher_update, publisher_delete, kckr_insert, kckr_update, kckr_delete, media_insert, media_update, media_delete, media_record, media_book', 'length', 'max'=>23),
			array('date_key', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('date_key, setting_update, category_insert, category_update, category_delete, pic_insert, pic_update, pic_delete, publisher_insert, publisher_update, publisher_delete, kckr_insert, kckr_update, kckr_delete, media_insert, media_update, media_delete, media_record, media_book', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'date_key' => Yii::t('attribute', 'Date Key'),
			'setting_update' => Yii::t('attribute', 'Setting Update'),
			'category_insert' => Yii::t('attribute', 'Category Insert'),
			'category_update' => Yii::t('attribute', 'Category Update'),
			'category_delete' => Yii::t('attribute', 'Category Delete'),
			'pic_insert' => Yii::t('attribute', 'Pic Insert'),
			'pic_update' => Yii::t('attribute', 'Pic Update'),
			'pic_delete' => Yii::t('attribute', 'Pic Delete'),
			'publisher_insert' => Yii::t('attribute', 'Publisher Insert'),
			'publisher_update' => Yii::t('attribute', 'Publisher Update'),
			'publisher_delete' => Yii::t('attribute', 'Publisher Delete'),
			'kckr_insert' => Yii::t('attribute', 'Kckr Insert'),
			'kckr_update' => Yii::t('attribute', 'Kckr Update'),
			'kckr_delete' => Yii::t('attribute', 'Kckr Delete'),
			'media_insert' => Yii::t('attribute', 'Media Insert'),
			'media_update' => Yii::t('attribute', 'Media Update'),
			'media_delete' => Yii::t('attribute', 'Media Delete'),
			'media_record' => Yii::t('attribute', 'Media Record'),
			'media_book' => Yii::t('attribute', 'Media Book'),
		);
		/*
			'Date Key' => 'Date Key',
			'Setting Update' => 'Setting Update',
			'Category Insert' => 'Category Insert',
			'Category Update' => 'Category Update',
			'Category Delete' => 'Category Delete',
			'Pic Insert' => 'Pic Insert',
			'Pic Update' => 'Pic Update',
			'Pic Delete' => 'Pic Delete',
			'Publisher Insert' => 'Publisher Insert',
			'Publisher Update' => 'Publisher Update',
			'Publisher Delete' => 'Publisher Delete',
			'Kckr Insert' => 'Kckr Insert',
			'Kckr Update' => 'Kckr Update',
			'Kckr Delete' => 'Kckr Delete',
			'Media Insert' => 'Media Insert',
			'Media Update' => 'Media Update',
			'Media Delete' => 'Media Delete',
			'Media Record' => 'Media Record',
			'Media Book' => 'Media Book',
		
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

		if($this->date_key != null && !in_array($this->date_key, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.date_key)',date('Y-m-d', strtotime($this->date_key)));
		$criteria->compare('t.setting_update',strtolower($this->setting_update),true);
		$criteria->compare('t.category_insert',strtolower($this->category_insert),true);
		$criteria->compare('t.category_update',strtolower($this->category_update),true);
		$criteria->compare('t.category_delete',strtolower($this->category_delete),true);
		$criteria->compare('t.pic_insert',strtolower($this->pic_insert),true);
		$criteria->compare('t.pic_update',strtolower($this->pic_update),true);
		$criteria->compare('t.pic_delete',strtolower($this->pic_delete),true);
		$criteria->compare('t.publisher_insert',strtolower($this->publisher_insert),true);
		$criteria->compare('t.publisher_update',strtolower($this->publisher_update),true);
		$criteria->compare('t.publisher_delete',strtolower($this->publisher_delete),true);
		$criteria->compare('t.kckr_insert',strtolower($this->kckr_insert),true);
		$criteria->compare('t.kckr_update',strtolower($this->kckr_update),true);
		$criteria->compare('t.kckr_delete',strtolower($this->kckr_delete),true);
		$criteria->compare('t.media_insert',strtolower($this->media_insert),true);
		$criteria->compare('t.media_update',strtolower($this->media_update),true);
		$criteria->compare('t.media_delete',strtolower($this->media_delete),true);
		$criteria->compare('t.media_record',strtolower($this->media_record),true);
		$criteria->compare('t.media_book',strtolower($this->media_book),true);

		if(!isset($_GET['ViewKckrStatistics_sort']))
			$criteria->order = 't.date_key DESC';

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
			$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'setting_update';
			$this->defaultColumns[] = 'category_insert';
			$this->defaultColumns[] = 'category_update';
			$this->defaultColumns[] = 'category_delete';
			$this->defaultColumns[] = 'pic_insert';
			$this->defaultColumns[] = 'pic_update';
			$this->defaultColumns[] = 'pic_delete';
			$this->defaultColumns[] = 'publisher_insert';
			$this->defaultColumns[] = 'publisher_update';
			$this->defaultColumns[] = 'publisher_delete';
			$this->defaultColumns[] = 'kckr_insert';
			$this->defaultColumns[] = 'kckr_update';
			$this->defaultColumns[] = 'kckr_delete';
			$this->defaultColumns[] = 'media_insert';
			$this->defaultColumns[] = 'media_update';
			$this->defaultColumns[] = 'media_delete';
			$this->defaultColumns[] = 'media_record';
			$this->defaultColumns[] = 'media_book';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'date_key',
				'value' => 'Utility::dateFormat($data->date_key)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'date_key',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js'
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'date_key_filter',
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
			$this->defaultColumns[] = 'setting_update';
			$this->defaultColumns[] = 'category_insert';
			$this->defaultColumns[] = 'category_update';
			$this->defaultColumns[] = 'category_delete';
			$this->defaultColumns[] = 'pic_insert';
			$this->defaultColumns[] = 'pic_update';
			$this->defaultColumns[] = 'pic_delete';
			$this->defaultColumns[] = 'publisher_insert';
			$this->defaultColumns[] = 'publisher_update';
			$this->defaultColumns[] = 'publisher_delete';
			$this->defaultColumns[] = 'kckr_insert';
			$this->defaultColumns[] = 'kckr_update';
			$this->defaultColumns[] = 'kckr_delete';
			$this->defaultColumns[] = 'media_insert';
			$this->defaultColumns[] = 'media_update';
			$this->defaultColumns[] = 'media_delete';
			$this->defaultColumns[] = 'media_record';
			$this->defaultColumns[] = 'media_book';
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

}