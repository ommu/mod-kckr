<?php
/**
 * KckrAsset
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 11 July 2019, 21:08 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\components\assets;

class KckrAsset extends \yii\web\AssetBundle
{
	public $sourcePath = '@ommu/kckr/assets';

	public $publishOptions = [
		'forceCopy' => YII_DEBUG ? true : false,
	];
}