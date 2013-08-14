<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('navi-menu', "
	$('.box .h_title').not(this).next('ul').hide('normal');
	$('.box .h_title').not(this).next('#home').show('normal');
	$('.box').children('.h_title').click( function() { $(this).next('ul').slideToggle(); });
	");
?>
<!DOCTYPE html >
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Beijing Baked Fish</title>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-navi.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" />
</head>
<body>
<div class="wrap">
	<div id="header">
		<div id="top">
			<div class="left">
				<p>Welcome, <strong><?php echo $this->name ?></strong> [ <a href="<?php echo $this->createUrl('member/logout'); ?>">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p>Last login: <strong><?php echo Date('Y-m-d h:m:s') ?></strong></p>
				</div>
			</div>
		</div>
		<div id="nav">
			<?php $this->widget('zii.widgets.CMenu', array(
				'itemCssClass' => 'upp',
				'encodeLabel' => false,
				'items' => array(
					array('label' => 'Main control', 'items' => array(
						array('label' => '&#8250; ' . (Yii::app()->user->roles=='admin' ? 'Member' : 'Account'), 'url'=>array('member/index')),
						array('label' => '&#8250; Network', 'url'=>'#'),
						array('label' => '&#8250; Transaction', 'url'=>'#', 'visible'=>Yii::app()->user->roles=='admin'),
						array('label' => '&#8250; Transaction History', 'url'=>'#', 'visible'=>Yii::app()->user->roles!='admin'),
						array('label' => '&#8250; SMS', 'url'=>'#', 'visible'=>Yii::app()->user->roles=='admin'),
						)),
					),
				)); ?>
		</div>
	</div>

	<div id="content">
		<div id="sidebar">
			<div class="box">
				<div class="h_title">&#8250; Main control</div>
				<?php $this->widget('zii.widgets.CMenu', array(
					'id' => 'home',
					// 'activateItems' => true, // uncomment this line if you need it.
					// 'activeCssClass' => 'current', // uncomment this line if you need it.
					'itemCssClass' => 'b2',
					'items' => array(
						array('label'=>Yii::app()->user->roles == 'admin' ? 'Member' : 'Account', 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'icon report')),
						array('label'=>'Change password', 'url'=>array('member/changepassword'), 'linkOptions'=>array('class'=>'icon report')),
						array('label'=>'Announcement', 'url'=>array('member/announcement'), 'linkOptions'=>array('class'=>'icon report')),
						array('label'=>'Network', 'url'=>array('member/network'), 'linkOptions'=>array('class'=>'icon report')),
						// array('label'=>'Binary Network', 'url'=>array('member/binarynetwork'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>'Transaction', 'url'=>array('member/transaction'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>'Transaction history', 'url'=>array('member/transactionhistory'), 'linkOptions'=>array('class'=>'icon report')),
						array('label'=>'Purchase history', 'url'=>array('member/purchasehistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
                                                array('label'=>'Withdraw history', 'url'=>array('member/withdrawhistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>'SMS', 'url'=>array('member/sms'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>'Set PIN', 'url'=>array('member/setpin'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
						array('label'=>'Refer a member', 'url'=>array('member/refermember'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
						array('label'=>'Transfer point', 'url'=>array('member/transfercp'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
						array('label'=>'Transfer CP to FP', 'url'=>array('member/transfercptofp'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
                                                array('label'=>'Purchase credit', 'url'=>array('member/purchase'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
						array('label'=>'Withdrawal', 'url'=>array('member/withdraw'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='admin'),
						)
					)); ?>
			</div>
		</div>
		<div id="main">
			<?php echo $content; ?>
		</div>

		<div id="footer">
			<div class="left">
				<p>&copy; 2013 Beijing Baked Fish Restaurant - All rights reserved.</p>
			</div>
			<div class="right">
				<p><a href="http://beijingbakedfish.com">beijingbakedfish.com</a></p>
			</div>
		</div>
	</div>
</div><!-- .wrap -->
</body>
</html>