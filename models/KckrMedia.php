<?php
/**
 * KckrMedia
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:37 WIB
 * @link https://bitbucket.org/ommu/kckr
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
 * This is the model class for table "ommu_kckr_media".
 *
 * The followings are the available columns in table 'ommu_kckr_media':
 * @property string $media_id
 * @property integer $publish
 * @property string $kckr_id
 * @property integer $category_id
 * @property string $media_title
 * @property string $media_desc
 * @property string $media_publish_year
 * @property string $media_author
 * @property integer $media_item
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property Kckrs $kckr
 * @property KckrCategory $category
 */
class KckrMedia extends CActiveRecord
{
	use GridViewTrait;

	public $defaultColumns = array();
	
	// Variable Search
	public $publisher_search;
	public $letter_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrMedia the static model class
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
		return 'ommu_kckr_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kckr_id, category_id, media_title, media_item', 'required'),
			array('publish, category_id, media_item', 'numerical', 'integerOnly'=>true),
			array('media_publish_year', 'length', 'max'=>4),
			array('kckr_id, creation_id, modified_id', 'length', 'max'=>11),
			array('media_desc, media_publish_year, media_author', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('media_id, publish, kckr_id, category_id, media_title, media_desc, media_publish_year, media_author, media_item, creation_date, creation_id, modified_date, modified_id, 
				publisher_search, letter_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'kckr' => array(self::BELONGS_TO, 'Kckrs', 'kckr_id'),
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
			'media_id' => Yii::t('attribute', 'Media'),
			'publish' => Yii::t('attribute', 'Publish'),
			'kckr_id' => Yii::t('attribute', 'Kckr'),
			'category_id' => Yii::t('attribute', 'Category'),
			'media_title' => Yii::t('attribute', 'Title'),
			'media_desc' => Yii::t('attribute', 'Description'),
			'media_publish_year' => Yii::t('attribute', 'Publish Year'),
			'media_author' => Yii::t('attribute', 'Author'),
			'media_item' => Yii::t('attribute', 'Item'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'publisher_search' => Yii::t('attribute', 'Publisher'),
			'letter_search' => Yii::t('attribute', 'Letter Number'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
			'kckr' => array(
				'alias' => 'kckr',
				'select' => 'publisher_id, letter_number'
			),
			'kckr.publisher' => array(
				'alias' => 'kckr_publisher',
				'select' => 'publisher_name'
			),
			'creation' => array(
				'alias' => 'creation',
				'select' => 'displayname'
			),
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname'
			),
		);

		$criteria->compare('t.media_id', $this->media_id);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		if(Yii::app()->getRequest()->getParam('kckr'))
			$criteria->compare('t.kckr_id', Yii::app()->getRequest()->getParam('kckr'));
		else
			$criteria->compare('t.kckr_id', $this->kckr_id);
		if(Yii::app()->getRequest()->getParam('type')) {
			$parent = Yii::app()->getRequest()->getParam('type');
			$categoryFind = KckrCategory::model()->findAll(array(
				'condition' => 'category_type = :type',
				'params' => array(
					':type' => $parent,
				),
			));
			$items = array();
			if($categoryFind != null) {
				foreach($categoryFind as $key => $val)
					$items[] = $val->category_id;
			}
			$criteria->addInCondition('t.category_id',$items);	
			$criteria->compare('t.category_id', $this->category_id);			
		} else {
			if(Yii::app()->getRequest()->getParam('category'))
				$criteria->compare('t.category_id', Yii::app()->getRequest()->getParam('category'));
			else
				$criteria->compare('t.category_id', $this->category_id);			
		}
		$criteria->compare('t.media_title', strtolower($this->media_title), true);
		$criteria->compare('t.media_desc', strtolower($this->media_desc), true);
		$criteria->compare('t.media_publish_year', strtolower($this->media_publish_year), true);
		$criteria->compare('t.media_author', strtolower($this->media_author), true);
		$criteria->compare('t.media_item', $this->media_item);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		if(Yii::app()->getRequest()->getParam('modified'))
			$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified'));
		else
			$criteria->compare('t.modified_id', $this->modified_id);
		
		if(Yii::app()->getRequest()->getParam('publisher'))
			$criteria->compare('kckr.publisher_id', Yii::app()->getRequest()->getParam('publisher'));			
		$criteria->compare('kckr.letter_number', strtolower($this->letter_search), true);
		$criteria->compare('kckr_publisher.publisher_name', strtolower($this->publisher_search), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('KckrMedia_sort'))
			$criteria->order = 't.media_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
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
	public function searchKckrEdit()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'creation' => array(
				'alias' => 'creation',
				'select' => 'displayname'
			),
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname'
			),
		);

		$criteria->compare('t.media_id', strtolower($this->media_id), true);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		if(Yii::app()->getRequest()->getParam('id'))
			$criteria->compare('t.kckr_id', Yii::app()->getRequest()->getParam('id'));
		if(Yii::app()->getRequest()->getParam('category'))
			$criteria->compare('t.category_id', Yii::app()->getRequest()->getParam('category'));
		else
			$criteria->compare('t.category_id', $this->category_id);
		$criteria->compare('t.media_title', strtolower($this->media_title), true);
		$criteria->compare('t.media_desc', strtolower($this->media_desc), true);
		$criteria->compare('t.media_publish_year', strtolower($this->media_publish_year), true);
		$criteria->compare('t.media_author', strtolower($this->media_author), true);
		$criteria->compare('t.media_item', $this->media_item);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		if(Yii::app()->getRequest()->getParam('modified'))
			$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified'));
		else
			$criteria->compare('t.modified_id', $this->modified_id);
		
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('KckrMedia_sort'))
			$criteria->order = 't.media_id DESC';

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
			//$this->defaultColumns[] = 'media_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'kckr_id';
			$this->defaultColumns[] = 'category_id';
			$this->defaultColumns[] = 'media_title';
			$this->defaultColumns[] = 'media_desc';
			$this->defaultColumns[] = 'media_publish_year';
			$this->defaultColumns[] = 'media_author';
			$this->defaultColumns[] = 'media_item';
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
		$controller = strtolower(Yii::app()->controller->id);
		
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
			if($controller != 'o/admin') {
				if(!Yii::app()->getRequest()->getParam('publisher') && !Yii::app()->getRequest()->getParam('kckr')) {
					$this->defaultColumns[] = array(
						'name' => 'publisher_search',
						'value' => '$data->kckr->publisher->publisher_name',
					);
				}
				if(!Yii::app()->getRequest()->getParam('kckr')) {
					$this->defaultColumns[] = array(
						'name' => 'letter_search',
						'value' => '$data->kckr->letter_number',
					);
				}
			}
			if(!Yii::app()->getRequest()->getParam('category')) {
				if(Yii::app()->getRequest()->getParam('type'))
					$parent = Yii::app()->getRequest()->getParam('type');
				else
					$parent = null;
				$this->defaultColumns[] = array(
					'name' => 'category_id',
					'value' => '$data->category->category_name',
					'filter' =>KckrCategory::getCategory(null, $parent),
					'type' => 'raw',
				);				
			}
			$this->defaultColumns[] = array(
				'name' => 'media_title',
				'value' => '$data->media_title',
			);
			$this->defaultColumns[] = array(
				'name' => 'media_author',
				'value' => '$data->media_author',
			);
			$this->defaultColumns[] = array(
				'name' => 'media_publish_year',
				'value' => '$data->media_publish_year != \'0000\' ? $data->media_publish_year : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->defaultColumns[] = array(
				'name' => 'media_item',
				'value' => '$data->media_item',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			if(!Yii::app()->getRequest()->getParam('type') && $controller != 'o/admin') {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish", array("id"=>$data->media_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
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
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
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