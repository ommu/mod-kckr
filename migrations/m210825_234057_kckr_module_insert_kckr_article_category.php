<?php
/**
 * m210825_234057_kckr_module_insert_kckr_article_category
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 25 August 2021, 23:42 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use app\models\SourceMessage;

class m210825_234057_kckr_module_insert_kckr_article_category extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_article_category';
		if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['publish', 'parent_id', 'name', 'desc', 'single_photo', 'single_file', 'creation_id'], [
				['1', null, SourceMessage::setMessage('KCKR', 'kckr category title'), SourceMessage::setMessage('KCKR', 'kckr category description'), '1', '1', Yii::$app->user->id],
			]);
		}
	}
}
