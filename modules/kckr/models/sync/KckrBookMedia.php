<?php
/**
 * KckrBookMedia
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 06:53 WIB
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
 * This is the model class for table "tbbuku".
 *
 * The followings are the available columns in table 'tbbuku':
 * @property integer $idbuku
 * @property integer $idsurat
 * @property string $judul
 * @property string $tahunterbit
 * @property string $pengarang1
 * @property integer $jml
 * @property string $edisi_cet
 * @property integer $kodejenis
 *
 * The followings are the available model relations:
 * @property Tbjeniskcetak $kodejenis0
 * @property Tbkcetak $idsurat0
 */
class KckrBookMedia extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KckrBookMedia the static model class
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
		return $matches[1].'.tbbuku';
		//return 'tbbuku';
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
			array('tahunterbit', 'length', 'max'=>4),
			array('pengarang1', 'length', 'max'=>150),
			array('edisi_cet', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idbuku, idsurat, judul, tahunterbit, pengarang1, jml, edisi_cet, kodejenis', 'safe', 'on'=>'search'),
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
			'kodejenis0_relation' => array(self::BELONGS_TO, 'Tbjeniskcetak', 'kodejenis'),
			'idsurat0_relation' => array(self::BELONGS_TO, 'Tbkcetak', 'idsurat'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbuku' => Yii::t('attribute', 'Idbuku'),
			'idsurat' => Yii::t('attribute', 'Idsurat'),
			'judul' => Yii::t('attribute', 'Judul'),
			'tahunterbit' => Yii::t('attribute', 'Tahunterbit'),
			'pengarang1' => Yii::t('attribute', 'Pengarang1'),
			'jml' => Yii::t('attribute', 'Jml'),
			'edisi_cet' => Yii::t('attribute', 'Edisi Cet'),
			'kodejenis' => Yii::t('attribute', 'Kodejenis'),
		);
		/*
			'Idbuku' => 'Idbuku',
			'Idsurat' => 'Idsurat',
			'Judul' => 'Judul',
			'Tahunterbit' => 'Tahunterbit',
			'Pengarang1' => 'Pengarang1',
			'Jml' => 'Jml',
			'Edisi Cet' => 'Edisi Cet',
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

		$criteria->compare('t.idbuku',$this->idbuku);
		if(isset($_GET['idsurat']))
			$criteria->compare('t.idsurat',$_GET['idsurat']);
		else
			$criteria->compare('t.idsurat',$this->idsurat);
		$criteria->compare('t.judul',strtolower($this->judul),true);
		$criteria->compare('t.tahunterbit',strtolower($this->tahunterbit),true);
		$criteria->compare('t.pengarang1',strtolower($this->pengarang1),true);
		$criteria->compare('t.jml',$this->jml);
		$criteria->compare('t.edisi_cet',strtolower($this->edisi_cet),true);
		if(isset($_GET['kodejenis']))
			$criteria->compare('t.kodejenis',$_GET['kodejenis']);
		else
			$criteria->compare('t.kodejenis',$this->kodejenis);

		if(!isset($_GET['KckrBookMedia_sort']))
			$criteria->order = 't.idbuku DESC';

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
			//$this->defaultColumns[] = 'idbuku';
			$this->defaultColumns[] = 'idsurat';
			$this->defaultColumns[] = 'judul';
			$this->defaultColumns[] = 'tahunterbit';
			$this->defaultColumns[] = 'pengarang1';
			$this->defaultColumns[] = 'jml';
			$this->defaultColumns[] = 'edisi_cet';
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
			$this->defaultColumns[] = 'tahunterbit';
			$this->defaultColumns[] = 'pengarang1';
			$this->defaultColumns[] = 'jml';
			$this->defaultColumns[] = 'edisi_cet';
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