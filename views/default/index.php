<?php
/**
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\DefaultController
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 28 February 2019, 13:26 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
?>

<p>
	This is the view content for action "<?php echo $this->context->action->id ?>".
	The action belongs to the controller "<?php echo get_class($this->context) ?>"
	in the "<?php echo $this->context->module->id ?>" module.
</p>
<p>
	You may customize this page by editing the following file:<br>
	<code><?php echo __FILE__ ?></code>
</p>

<div class="kckr-default-index"></div>