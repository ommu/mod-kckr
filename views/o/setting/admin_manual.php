<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this SettingController
 * @var $model KckrSetting
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 16 September 2016, 23:07 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckr Settings'=>array('manage'),
		'Manual Book',
	);
?>

<div class="dialog-content">
	<ul>
	<?php
		foreach (new DirectoryIterator($manual_path) as $fileInfo) {
			$filePath = '';
			if($fileInfo->isDot())
				continue;
			
			if($fileInfo->isFile()) {
				$extension = pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('php')))
					$filePath = $this->module->assetsUrl.'/manual/'.$fileInfo->getFilename();
			}
			if($filePath)
				echo '<li>'.CHtml::link($fileInfo->getFilename(), $filePath).'</li>';
		}
	?>
	</ul>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>