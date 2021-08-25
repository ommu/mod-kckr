<?php
/**
 * m210825_204306_kckr_module_create_table_media
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 20:43 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use yii\db\Schema;

class m210825_204306_kckr_module_create_table_media extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_media';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'publish' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'kckr_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'cat_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED NOT NULL',
				'isbn' => Schema::TYPE_STRING . '(32) NOT NULL',
				'media_title' => Schema::TYPE_TEXT . ' NOT NULL',
				'media_desc' => Schema::TYPE_TEXT . ' NOT NULL',
				'media_publish_year' => Schema::TYPE_DATE . '(4) NOT NULL',
				'media_author' => Schema::TYPE_TEXT . ' NOT NULL',
				'media_item' => Schema::TYPE_SMALLINT . '(5) NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'trigger\'',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_kckr_media_ibfk_1 FOREIGN KEY ([[kckr_id]]) REFERENCES ommu_kckrs ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT ommu_kckr_media_ibfk_2 FOREIGN KEY ([[cat_id]]) REFERENCES ommu_kckr_category ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
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
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_media';
		$this->dropTable($tableName);
	}
}
