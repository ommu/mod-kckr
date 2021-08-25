<?php
/**
 * m210825_221104_kckr_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 25 August 2021, 22:11 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m210825_221104_kckr_module_insert_role extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

	public function up()
	{
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;

        // route
		$tableName = Yii::$app->db->tablePrefix . $authManager->itemTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'type', 'data', 'created_at'], [
				['kckrModLevelAdmin', '2', '', time()],
				['kckrModLevelModerator', '2', '', time()],
				['/kckr/admin/*', '2', '', time()],
				['/kckr/admin/index', '2', '', time()],
				['/kckr/publisher/admin/*', '2', '', time()],
				['/kckr/publisher/admin/index', '2', '', time()],
				['/kckr/publisher/media/*', '2', '', time()],
				['/kckr/publisher/obligation/*', '2', '', time()],
				['/kckr/setting/admin/index', '2', '', time()],
				['/kckr/setting/admin/update', '2', '', time()],
				['/kckr/setting/admin/delete', '2', '', time()],
				['/kckr/setting/category/*', '2', '', time()],
				['/kckr/setting/pic/*', '2', '', time()],
			]);
		}

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemChildTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
            // permission
			$this->batchInsert($tableName, ['parent', 'child'], [
				['kckrModLevelAdmin', 'kckrModLevelModerator'],
				['kckrModLevelAdmin', '/kckr/setting/admin/update'],
				['kckrModLevelAdmin', '/kckr/setting/admin/delete'],
				['kckrModLevelAdmin', '/kckr/setting/category/*'],
				['kckrModLevelModerator', '/kckr/setting/admin/index'],
				['kckrModLevelModerator', '/kckr/admin/*'],
				['kckrModLevelModerator', '/kckr/publisher/admin/*'],
				['kckrModLevelModerator', '/kckr/publisher/media/*'],
				['kckrModLevelModerator', '/kckr/publisher/obligation/*'],
				['kckrModLevelModerator', '/kckr/setting/pic/*'],
			]);

            // role
			$this->batchInsert($tableName, ['parent', 'child'], [
				['userAdmin', 'kckrModLevelAdmin'],
				['userModerator', 'kckrModLevelModerator'],
			]);
		}
	}
}
