<?php
/**
 * KckrBookPublisher
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 06:55 WIB
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
 * This is the model class for table "tbpenerbit".
 *
 * The followings are the available columns in table 'tbpenerbit':
 * @property integer $kodepenerbit
 * @property string $penerbit
 * @property integer $kodekota
 * @property string $alamat
 * @property string $telepon
 *
 * The followings are the available model relations:
 * @property Tbkcetak[] $tbkcetaks
 * @property Tbkota $kodekota0
 */
class KckrBookPublisher extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrBookPublisher the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->kckr;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'.tbpenerbit';
		//return 'tbpenerbit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodekota', 'numerical', 'integerOnly'=>true),
			array('penerbit, alamat', 'length', 'max'=>200),
			array('telepon', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kodepenerbit, penerbit, kodekota, alamat, telepon', 'safe', 'on'=>'search'),
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
			'kckrs' => array(self::HAS_MANY, 'KckrBooks', 'kodepenerbit'),
			'location' => array(self::BELONGS_TO, 'KckrLocations', 'kodekota'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kodepenerbit' => Yii::t('attribute', 'Kodepenerbit'),
			'penerbit' => Yii::t('attribute', 'Penerbit'),
			'kodekota' => Yii::t('attribute', 'Kodekota'),
			'alamat' => Yii::t('attribute', 'Alamat'),
			'telepon' => Yii::t('attribute', 'Telepon'),
		);
		/*
			'Kodepenerbit' => 'Kodepenerbit',
			'Penerbit' => 'Penerbit',
			'Kodekota' => 'Kodekota',
			'Alamat' => 'Alamat',
			'Telepon' => 'Telepon',
		
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

		$criteria->compare('t.kodepenerbit',$this->kodepenerbit);
		$criteria->compare('t.penerbit',strtolower($this->penerbit),true);
		if(isset($_GET['kodekota']))
			$criteria->compare('t.kodekota',$_GET['kodekota']);
		else
			$criteria->compare('t.kodekota',$this->kodekota);
		$criteria->compare('t.alamat',strtolower($this->alamat),true);
		$criteria->compare('t.telepon',strtolower($this->telepon),true);

		if(!isset($_GET['KckrBookPublisher_sort']))
			$criteria->order = 't.kodepenerbit DESC';

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
			//$this->defaultColumns[] = 'kodepenerbit';
			$this->defaultColumns[] = 'penerbit';
			$this->defaultColumns[] = 'kodekota';
			$this->defaultColumns[] = 'alamat';
			$this->defaultColumns[] = 'telepon';
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
			$this->defaultColumns[] = 'penerbit';
			$this->defaultColumns[] = 'kodekota';
			$this->defaultColumns[] = 'alamat';
			$this->defaultColumns[] = 'telepon';
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