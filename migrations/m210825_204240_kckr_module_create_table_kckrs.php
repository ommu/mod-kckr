<?php
/**
 * m210825_204240_kckr_module_create_table_kckrs
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 20:42 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use yii\db\Schema;

class m210825_204240_kckr_module_create_table_kckrs extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckrs';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'publish' => Schema::TYPE_TINYINT . '(1) NOT NULL DEFAULT \'1\'',
				'article_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'pic_id' => Schema::TYPE_SMALLINT . '(11) UNSIGNED',
				'publisher_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'letter_number' => Schema::TYPE_STRING . '(64) NOT NULL',
				'send_type' => Schema::TYPE_STRING . ' NOT NULL',
				'send_date' => Schema::TYPE_DATE . ' NOT NULL',
				'receipt_date' => Schema::TYPE_DATE . ' NOT NULL',
				'thanks_date' => Schema::TYPE_DATE . ' NOT NULL',
				'thanks_document' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'serialize\'',
				'thanks_user_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED COMMENT \'user\'',
				'photos' => Schema::TYPE_TEXT . ' COMMENT \'file\'',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'updated_date' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'trigger\'',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_kckrs_ibfk_1 FOREIGN KEY ([[pic_id]]) REFERENCES ommu_kckr_pic ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
				'CONSTRAINT ommu_kckrs_ibfk_2 FOREIGN KEY ([[publisher_id]]) REFERENCES ommu_kckr_publisher ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);

			$this->createIndex(
				'article_id',
				$tableName,
				'article_id'
			);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckrs';
		$this->dropTable($tableName);
	}
}
