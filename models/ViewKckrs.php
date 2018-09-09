<?php
/**
 * ViewKckrs
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 24 September 2016, 22:38 WIB
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
 * This is the model class for table "_view_kckrs".
 *
 * The followings are the available columns in table '_view_kckrs':
 * @property string $kckr_id
 * @property integer $publish
 * @property string $publisher_id
 * @property string $medias
 * @property string $media_all
 * @property string $media_items
 * @property string $media_item_all
 */
class ViewKckrs extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewKckrs the static model class
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
		return '_view_kckrs';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'kckr_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publisher_id', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('kckr_id, publisher_id', 'length', 'max'=>11),
			array('medias, media_all', 'length', 'max'=>21),
			array('media_items, media_item_all', 'length', 'max'=>27),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kckr_id, publish, publisher_id, medias, media_all, media_items, media_item_all', 'safe', 'on'=>'search'),
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
			'kckr_id' => Yii::t('attribute', 'Kckr'),
			'publish' => Yii::t('attribute', 'Publish'),
			'publisher_id' => Yii::t('attribute', 'Publisher'),
			'medias' => Yii::t('attribute', 'Medias'),
			'media_all' => Yii::t('attribute', 'Media All'),
			'media_items' => Yii::t('attribute', 'Media Items'),
			'media_item_all' => Yii::t('attribute', 'Media Item All'),
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

		$criteria->compare('t.kckr_id', $this->kckr_id);
		$criteria->compare('t.publish', $this->publish);
		$criteria->compare('t.publisher_id', $this->publisher_id);
		$criteria->compare('t.medias', $this->medias);
		$criteria->compare('t.media_all', $this->media_all);
		$criteria->compare('t.media_items', $this->media_items);
		$criteria->compare('t.media_item_all', $this->media_item_all);

		if(!Yii::app()->getRequest()->getParam('ViewKckrs_sort'))
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
			$this->defaultColumns[] = 'kckr_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'medias';
			$this->defaultColumns[] = 'media_all';
			$this->defaultColumns[] = 'media_items';
			$this->defaultColumns[] = 'media_item_all';
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
			//$this->defaultColumns[] = 'kckr_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'medias';
			$this->defaultColumns[] = 'media_all';
			$this->defaultColumns[] = 'media_items';
			$this->defaultColumns[] = 'media_item_all';
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

}