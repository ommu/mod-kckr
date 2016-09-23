<?php
/**
 * KckrRecords
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 06:51 WIB
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
 * This is the model class for table "tbkrekam".
 *
 * The followings are the available columns in table 'tbkrekam':
 * @property integer $idsurat
 * @property integer $kodeperekam
 * @property string $nosurat
 * @property string $tglkirimpos
 * @property string $tglkirimls
 * @property string $tglterima
 * @property string $ucapan
 * @property string $cekucapan
 *
 * The followings are the available model relations:
 * @property Tbperekam $kodeperekam0
 * @property Tbrekaman[] $tbrekamen
 */
class KckrRecords extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrRecords the static model class
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
		return $matches[1].'.tbkrekam';
		//return 'tbkrekam';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodeperekam', 'numerical', 'integerOnly'=>true),
			array('nosurat', 'length', 'max'=>100),
			array('cekucapan', 'length', 'max'=>1),
			array('tglkirimpos, tglkirimls, tglterima, ucapan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idsurat, kodeperekam, nosurat, tglkirimpos, tglkirimls, tglterima, ucapan, cekucapan', 'safe', 'on'=>'search'),
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
			'kodeperekam0_relation' => array(self::BELONGS_TO, 'Tbperekam', 'kodeperekam'),
			'tbrekamen_relation' => array(self::HAS_MANY, 'Tbrekaman', 'idsurat'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idsurat' => Yii::t('attribute', 'Idsurat'),
			'kodeperekam' => Yii::t('attribute', 'Kodeperekam'),
			'nosurat' => Yii::t('attribute', 'Nosurat'),
			'tglkirimpos' => Yii::t('attribute', 'Tglkirimpos'),
			'tglkirimls' => Yii::t('attribute', 'Tglkirimls'),
			'tglterima' => Yii::t('attribute', 'Tglterima'),
			'ucapan' => Yii::t('attribute', 'Ucapan'),
			'cekucapan' => Yii::t('attribute', 'Cekucapan'),
		);
		/*
			'Idsurat' => 'Idsurat',
			'Kodeperekam' => 'Kodeperekam',
			'Nosurat' => 'Nosurat',
			'Tglkirimpos' => 'Tglkirimpos',
			'Tglkirimls' => 'Tglkirimls',
			'Tglterima' => 'Tglterima',
			'Ucapan' => 'Ucapan',
			'Cekucapan' => 'Cekucapan',
		
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

		$criteria->compare('t.idsurat',$this->idsurat);
		if(isset($_GET['kodeperekam']))
			$criteria->compare('t.kodeperekam',$_GET['kodeperekam']);
		else
			$criteria->compare('t.kodeperekam',$this->kodeperekam);
		$criteria->compare('t.nosurat',strtolower($this->nosurat),true);
		if($this->tglkirimpos != null && !in_array($this->tglkirimpos, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.tglkirimpos)',date('Y-m-d', strtotime($this->tglkirimpos)));
		if($this->tglkirimls != null && !in_array($this->tglkirimls, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.tglkirimls)',date('Y-m-d', strtotime($this->tglkirimls)));
		if($this->tglterima != null && !in_array($this->tglterima, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.tglterima)',date('Y-m-d', strtotime($this->tglterima)));
		if($this->ucapan != null && !in_array($this->ucapan, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.ucapan)',date('Y-m-d', strtotime($this->ucapan)));
		$criteria->compare('t.cekucapan',strtolower($this->cekucapan),true);

		if(!isset($_GET['KckrRecords_sort']))
			$criteria->order = 't.idsurat DESC';

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
			//$this->defaultColumns[] = 'idsurat';
			$this->defaultColumns[] = 'kodeperekam';
			$this->defaultColumns[] = 'nosurat';
			$this->defaultColumns[] = 'tglkirimpos';
			$this->defaultColumns[] = 'tglkirimls';
			$this->defaultColumns[] = 'tglterima';
			$this->defaultColumns[] = 'ucapan';
			$this->defaultColumns[] = 'cekucapan';
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
			//$this->defaultColumns[] = 'idsurat';
			$this->defaultColumns[] = 'kodeperekam';
			$this->defaultColumns[] = 'nosurat';
			$this->defaultColumns[] = 'tglkirimpos';
			$this->defaultColumns[] = 'tglkirimls';
			$this->defaultColumns[] = 'tglterima';
			$this->defaultColumns[] = 'ucapan';
			$this->defaultColumns[] = 'cekucapan';
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