<?php
/**
 * m210825_204000_kckr_module_create_table_setting
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 20:40 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use yii\db\Schema;

class m210825_204000_kckr_module_create_table_setting extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_setting';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_TINYINT . '(1) UNSIGNED NOT NULL AUTO_INCREMENT',
				'license' => Schema::TYPE_STRING . '(32) NOT NULL',
				'permission' => Schema::TYPE_TINYINT . '(1) NOT NULL',
				'meta_description' => Schema::TYPE_TEXT . ' NOT NULL',
				'meta_keyword' => Schema::TYPE_TEXT . ' NOT NULL',
				'photo_resize' => Schema::TYPE_TINYINT . '(1) NOT NULL',
				'photo_resize_size' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'serialize\'',
				'photo_view_size' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'serialize\'',
				'photo_file_type' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'serialize\'',
				'import_file_type' => Schema::TYPE_TEXT . ' NOT NULL COMMENT \'json\'',
				'article_cat_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED NOT NULL',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[id]])',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_kckr_setting';
		$this->dropTable($tableName);
	}
}
