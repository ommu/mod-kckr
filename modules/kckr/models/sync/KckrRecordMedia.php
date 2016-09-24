<?php
/**
 * KckrRecordMedia
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
 * This is the model class for table "tbrekaman".
 *
 * The followings are the available columns in table 'tbrekaman':
 * @property integer $idrekaman
 * @property integer $idsurat
 * @property string $judul
 * @property string $tahunrekam
 * @property string $pencipta
 * @property integer $jml
 * @property integer $kodejenis
 *
 * The followings are the available model relations:
 * @property Tbkrekam $idsurat0
 * @property Tbjeniskrekam $kodejenis0
 */
class KckrRecordMedia extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrRecordMedia the static model class
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
		return $matches[1].'.tbrekaman';
		//return 'tbrekaman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsurat, jml, kodejenis', 'numerical', 'integerOnly'=>true),
			array('judul', 'length', 'max'=>250),
			array('tahunrekam', 'length', 'max'=>4),
			array('pencipta', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idrekaman, idsurat, judul, tahunrekam, pencipta, jml, kodejenis', 'safe', 'on'=>'search'),
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
			'kckr' => array(self::BELONGS_TO, 'KckrRecords', 'idsurat'),
			'category' => array(self::BELONGS_TO, 'KckrRecordCategory', 'kodejenis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idrekaman' => Yii::t('attribute', 'Idrekaman'),
			'idsurat' => Yii::t('attribute', 'Idsurat'),
			'judul' => Yii::t('attribute', 'Judul'),
			'tahunrekam' => Yii::t('attribute', 'Tahunrekam'),
			'pencipta' => Yii::t('attribute', 'Pencipta'),
			'jml' => Yii::t('attribute', 'Jml'),
			'kodejenis' => Yii::t('attribute', 'Kodejenis'),
		);
		/*
			'Idrekaman' => 'Idrekaman',
			'Idsurat' => 'Idsurat',
			'Judul' => 'Judul',
			'Tahunrekam' => 'Tahunrekam',
			'Pencipta' => 'Pencipta',
			'Jml' => 'Jml',
			'Kodejenis' => 'Kodejenis',
		
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

		$criteria->compare('t.idrekaman',$this->idrekaman);
		if(isset($_GET['idsurat']))
			$criteria->compare('t.idsurat',$_GET['idsurat']);
		else
			$criteria->compare('t.idsurat',$this->idsurat);
		$criteria->compare('t.judul',strtolower($this->judul),true);
		$criteria->compare('t.tahunrekam',strtolower($this->tahunrekam),true);
		$criteria->compare('t.pencipta',strtolower($this->pencipta),true);
		$criteria->compare('t.jml',$this->jml);
		if(isset($_GET['kodejenis']))
			$criteria->compare('t.kodejenis',$_GET['kodejenis']);
		else
			$criteria->compare('t.kodejenis',$this->kodejenis);

		if(!isset($_GET['KckrRecordMedia_sort']))
			$criteria->order = 't.idrekaman DESC';

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
			//$this->defaultColumns[] = 'idrekaman';
			$this->defaultColumns[] = 'idsurat';
			$this->defaultColumns[] = 'judul';
			$this->defaultColumns[] = 'tahunrekam';
			$this->defaultColumns[] = 'pencipta';
			$this->defaultColumns[] = 'jml';
			$this->defaultColumns[] = 'kodejenis';
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
			$this->defaultColumns[] = 'idsurat';
			$this->defaultColumns[] = 'judul';
			$this->defaultColumns[] = 'tahunrekam';
			$this->defaultColumns[] = 'pencipta';
			$this->defaultColumns[] = 'jml';
			$this->defaultColumns[] = 'kodejenis';
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