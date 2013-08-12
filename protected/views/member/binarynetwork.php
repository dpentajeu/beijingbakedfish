<?php
$total_level = 5;
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
<table id="binary-tree">
<?php
foreach (range(1, $total_level) as $level) {
	echo CHtml::openTag('tr');
	foreach (range(0, pow(2, $level - 1) - 1) as $index) {
		$content_index = 0;
		$content = array("/images/i_ok.png", "/images/i_delete.png");

		// pow(2, $total_level - $level) determines how many
		// cells do we need to span through
		echo CHtml::openTag('td', array('colspan'=>pow(2, $total_level - $level), 'align'=>'center'));
		
		// determine the availability of the binary lot.
		if (empty($model[$level][$index]))
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
			echo CHtml::tag('div', array('class'=>'vline'), '');
		}

		// the image of the node.
		echo CHtml::image($baseUrl . $content[$content_index]);

		// draw a line down if it is not the last level.
		if ($level < $total_level)
			echo CHtml::tag('div', array('class'=>'vline'), '', true);

		echo CHtml::closeTag('td');
	}
	echo CHtml::closeTag('tr');
}
?>
</table>