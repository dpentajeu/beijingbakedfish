<?php
$baseUrl = Yii::app()->request->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCss('binary-tree', "
	#binary-tree, #binary-tree td {
		padding: 0;
	}
	#binary-tree .vline {
		height: 5px;
		margin: 0 50%;
		border-left: 1px solid black;
	}
	#binary-tree .lline, #binary-tree .rline {
		border-top: 1px solid black;
	}
	#binary-tree .lline {
		margin: 0 50% 0 0;
	}
	#binary-tree .rline {
		margin: 0 0 0 50%;
	}
	");
?>
<?php if(Yii::app()->user->roles == 'admin') { ?>
<div class="full_w">
	<div class="h_title"><?php echo Yii::t('memberpanel', 'Binarysearch'); ?></div>
	<?php $form = $this->beginWidget('CActiveForm', array(
		'action'=>array('member/binarynetwork'),
		'method'=>'GET',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			),
		)); ?>
		<div style="margin: 0 0 .5em;">
			<label for="search_id"><?php echo Yii::t('memberpanel', 'username'); ?> :</label>
			<?php echo CHtml::dropDownList('search_id', $selector, $member_list, array('prompt'=>'Select a customer')); ?>
		</div>
		<button>Search</button>
	<?php $this->endWidget(); ?>
</div>
<?php } ?>
<!--
<div class="full_w">
	<div class="h_title">Create new binary node</div>
	<?php $form = $this->beginWidget('CActiveForm', array(
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			),
		)); ?>
		<div style="margin: 0 0 .5em;">
			<label for="insert_id">Customer :</label>
			<?php echo CHtml::dropDownList('insert_id', null, $member_list, array('prompt'=>'Select a customer')); ?>
		</div>
		<div style="margin: 0 0 .5em;">
			<label for="insert_num">Number of nodes :</label>
			<?php echo CHtml::textField('insert_num', null); ?>
		</div>
		<button>Create</button>
	<?php $this->endWidget(); ?>
</div>
-->
<div class="full_w">
<div class="h_title"><?php echo Yii::t('memberpanel', 'Binarytree'); ?></div>
<p>You are now viewing <?php echo $view_model->user->name; ?>'s binary network: </p>
<p><?php echo $view_model->user->name; ?> owns <?php echo count($view_model->user->binaryNodes) . ' ' . Yii::t('plural', 'unit|units', count($view_model->user->binaryNodes)); ?>. Click on the following to view his/her binary network.</p>
<ol>
	<?php
	$param = array('search_id'=>$selector);
	foreach ($view_model->user->binaryNodes as $index => $m) {
		$param['node_index'] = $index;
		$link = CHtml::link($view_model->user->name, array_merge(array(''), $param));
		if ($node_index == $index)
			$link .= " (You are now viewing here)";
		echo CHtml::tag('li', array(), $link);
	}
	?>
</ol>
<p>Legend:</p>
<ul style="list-style-type: none; margin-left: 15px;">
	<li><?php echo CHtml::image($baseUrl . "/images/i_ok.png", '', array('style'=>'float: left;')); ?><span style="padding: 2px; float: left;">Taken unit</span></li>
	<li><?php echo CHtml::image($baseUrl . "/images/i_delete.png", '', array('style'=>'float: left;')); ?><span style="padding: 2px; float: left;">Empty unit</span></li>
</ul>
<table id="binary-tree">
<?php
// Only view the network when the customer is in the binary tree.
if (!empty($tree)) {
	foreach (range(1, $total_level) as $level) {
		echo CHtml::openTag('tr');
		foreach (range(0, pow(2, $level - 1) - 1) as $index) {
			$content_index = 0;
			$content = array("/images/i_ok.png", "/images/i_delete.png");
			$before_img = array('htmlOptions'=>array(), 'content'=>'');

			// pow(2, $total_level - $level) determines how many
			// cells do we need to span through
			echo CHtml::openTag('td', array('colspan'=>pow(2, $total_level - $level), 'align'=>'center'));
			
			// determine the availability of the binary lot.
			if (empty($tree[$level][$index]))
				$content_index = 1;

			// draw line path to show the relationship of the nodes.
			if ($level > 1) {
				// draw a line towards the right if it is an even node.
				// otherwise, draw a left line.
				if ($index%2 == 0)
					echo CHtml::tag('div', array('class'=>'rline'), '');
				else
					echo CHtml::tag('div', array('class'=>'lline'), '');

				// draws a vertical line down for each node.
				$before_img['htmlOptions'] = array('class'=>'vline');
				$before_img['content'] = '';
			} else if ($content_index == 0 && $tree[$level][$index]->level > $view_model->user->binaryNodes[$node_index]->level) {
				Yii::trace($tree[$level][$index]->id / 2, "application.controllers.MemberController");
				$parent = floor($tree[$level][$index]->id / 2);
				$link = CHtml::link('up', array('member/binarynetwork', 'id'=>$parent, 'search_id'=>$selector, 'node_index'=>$node_index));
				$before_img['content'] = $link;
			}

			if ($level == 1)
				Yii::trace($tree[$level][$index]->id, "application.controllers.MemberController");
			echo CHtml::tag('div', $before_img['htmlOptions'], $before_img['content']);

			// the image of the node.
			echo CHtml::image($baseUrl . $content[$content_index]);

			// draw a line down if it is not the last level.
			if ($level < $total_level)
				echo CHtml::tag('div', array('class'=>'vline'), '', true);

			if ($level == $total_level && $content_index == 0) {
				$link = CHtml::link('more', array('member/binarynetwork', 'id'=>$tree[$level][$index]->id, 'search_id'=>$selector, 'node_index'=>$node_index));
				echo CHtml::tag('div', array(), $link);
			}

			echo CHtml::closeTag('td');
		}
		echo CHtml::closeTag('tr');
	}
} else {
	echo CHtml::openTag('tr');
	echo CHtml::tag('td', array(), $model->user->name . " is not in the binary network.");
	echo CHtml::closeTag('tr');
}
?>
</table>
</div>