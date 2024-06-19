<?php
/**
 * m210825_221146_kckr_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 25 August 2021, 22:11 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use Yii;
use mdm\admin\components\Configs;
use app\models\Menu;

class m210825_221146_kckr_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
        $menuTable = Configs::instance()->menuTable;
		$tableName = Yii::$app->db->tablePrefix . $menuTable;

        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['KCKR', ',kckr', 'fa-book', null, '/#', null, null],
			]);

			$this->batchInsert($tableName, ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['Deposit', 'kckr', null, Menu::getParentId('KCKR#kckr'), '/kckr/admin/index', null, null],
				['Publisher', 'kckr', null, Menu::getParentId('KCKR#kckr'), '/kckr/publisher/admin/index', null, null],
				['Settings', 'kckr', null, Menu::getParentId('KCKR#kckr'), '/kckr/setting/admin/index', null, null],
			]);
		}
	}
}
