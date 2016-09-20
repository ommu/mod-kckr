<?php
/**
 * Kckrs
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 July 2016, 07:38 WIB
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
 * This is the model class for table "ommu_kckrs".
 *
 * The followings are the available columns in table 'ommu_kckrs':
 * @property string $kckr_id
 * @property integer $publish
 * @property integer $pic_id
 * @property string $publisher_id
 * @property integer $category_id
 * @property string $letter_number
 * @property string $receipt_type
 * @property string $receipt_date
 * @property string $thanks_date
 * @property string $photos
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuKckrMedia[] $ommuKckrMedias
 * @property OmmuKckrPic $pic
 * @property OmmuKckrPublisher $publisher
 * @property OmmuKckrCategory $category
 */
class Kckrs extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $creation_search;
	public $modified_search;

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
			array('pic_id, publisher_id, category_id, letter_number, receipt_type, receipt_date', 'required'),
			array('publish, pic_id, category_id', 'numerical', 'integerOnly'=>true),
			array('publisher_id, creation_id, modified_id', 'length', 'max'=>11),
			array('letter_number', 'length', 'max'=>64),
			array('thanks_date, photos', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kckr_id, publish, pic_id, publisher_id, category_id, letter_number, receipt_type, receipt_date, thanks_date, photos, creation_date, creation_id, modified_date, modified_id, 
				creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'media' => array(self::HAS_MANY, 'KckrMedia', 'kckr_id'),
			'pic' => array(self::BELONGS_TO, 'KckrPic', 'pic_id'),
			'publisher' => array(self::BELONGS_TO, 'KckrPublisher', 'publisher_id'),
			'category' => array(self::BELONGS_TO, 'KckrCategory', 'category_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
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
			'pic_id' => Yii::t('attribute', 'Pic'),
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'category_id' => Yii::t('attribute', 'Category'),
			'letter_number' => Yii::t('attribute', 'Letter Number'),
			'receipt_type' => Yii::t('attribute', 'Receipt Type'),
			'receipt_date' => Yii::t('attribute', 'Receipt Date'),
			'thanks_date' => Yii::t('attribute', 'Thanks Date'),
			'photos' => Yii::t('attribute', 'Photo'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
		/*
			'Kckr' => 'Kckr',
			'Publish' => 'Publish',
			'Pic' => 'Pic',
			'Publisher' => 'Publisher',
			'Category' => 'Category',
			'Letter Number' => 'Letter Number',
			'Receipt Date' => 'Receipt Date',
			'Thanks Date' => 'Thanks Date',
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
		if(isset($_GET['pic']))
			$criteria->compare('t.pic_id',$_GET['pic']);
		else
			$criteria->compare('t.pic_id',$this->pic_id);
		if(isset($_GET['publisher']))
			$criteria->compare('t.publisher_id',$_GET['publisher']);
		else
			$criteria->compare('t.publisher_id',$this->publisher_id);
		if(isset($_GET['category']))
			$criteria->compare('t.category_id',$_GET['category']);
		else
			$criteria->compare('t.category_id',$this->category_id);
		$criteria->compare('t.letter_number',strtolower($this->letter_number),true);
		$criteria->compare('t.receipt_type',$this->receipt_type);
		if($this->receipt_date != null && !in_array($this->receipt_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.receipt_date)',date('Y-m-d', strtotime($this->receipt_date)));
		if($this->thanks_date != null && !in_array($this->thanks_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.thanks_date)',date('Y-m-d', strtotime($this->thanks_date)));
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
		
		// Custom Search
		$criteria->with = array(
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
			$this->defaultColumns[] = 'pic_id';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'category_id';
			$this->defaultColumns[] = 'letter_number';
			$this->defaultColumns[] = 'receipt_type';
			$this->defaultColumns[] = 'receipt_date';
			$this->defaultColumns[] = 'thanks_date';
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
			$this->defaultColumns[] = 'publisher_id';
			if(!isset($_GET['category'])) {
				$this->defaultColumns[] = array(
					'name' => 'category_id',
					'value' => '$data->category->category_name',
					'filter'=> KckrCategory::getCategory(),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = 'letter_number';
			$this->defaultColumns[] = 'pic_id';
			$this->defaultColumns[] = array(
				'name' => 'receipt_type',
				'value' => '$data->receipt_type == \'pos\' ? Yii::t(\'phrase\', \'Pos\') : Yii::t(\'phrase\', \'Langsung\')',
				'filter'=>array(
					'pos'=>Yii::t('phrase', 'Pos'),
					'langsung'=>Yii::t('phrase', 'Langsung'),
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'receipt_date',
				'value' => '!in_array($data->receipt_date, array(\'0000-00-00 00:00:00\', \'0000-00-00\')) ? Utility::dateFormat($data->receipt_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'receipt_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
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
				'name' => 'thanks_date',
				'value' => '!in_array($data->thanks_date, array(\'0000-00-00 00:00:00\', \'0000-00-00\')) ? Utility::dateFormat($data->thanks_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'thanks_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'thanks_date_filter',
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
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
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