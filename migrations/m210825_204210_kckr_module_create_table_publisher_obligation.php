<?php
/**
 * m210825_204210_kckr_module_create_table_publisher_obligation
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 20:42 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use Yii;
use yii\db\Schema;

class m210825_204210_kckr_module_create_table_publisher_obligation extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_publisher_obligation';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'publish' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'publisher_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'cat_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED',
				'isbn' => Schema::TYPE_STRING . '(32) NOT NULL',
				'media_title' => Schema::TYPE_TEXT . ' NOT NULL',
				'media_desc' => Schema::TYPE_TEXT . ' NOT NULL',
				'media_publish_year' => Schema::TYPE_DATE . '(4) NOT NULL',
				'media_author' => Schema::TYPE_TEXT . ' NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'trigger\'',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_kckr_publisher_obligation_ibfk_1 FOREIGN KEY ([[publisher_id]]) REFERENCES ommu_kckr_publisher ([[id]]) ON DELETE SET NULL ON UPDATE CASCADE',
				'CONSTRAINT ommu_kckr_publisher_obligation_ibfk_2 FOREIGN KEY ([[cat_id]]) REFERENCES ommu_kckr_category ([[id]]) ON DELETE SET NULL ON UPDATE CASCADE',
			], $tableOptions);

			$this->createIndex(
				'isbn',
				$tableName,
				'isbn'
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_publisher_obligation';
		$this->dropTable($tableName);
	}
}
