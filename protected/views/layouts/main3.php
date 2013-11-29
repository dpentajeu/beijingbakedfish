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
				<p><?php echo Yii::t('memberpanel', 'Welcome'); ?>, <strong><?php echo $this->name ?></strong> [ <a href="<?php echo $this->createUrl('member/logout'); ?>"><?php echo Yii::t('memberpanel', 'Logout'); ?></a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p><?php echo Yii::t('memberpanel', 'LastLogin'); ?> <strong><?php echo Date('Y-m-d h:m:s') ?></strong></p>
				</div>
			</div>
		</div>
		<div id="nav">
			<?php $this->widget('zii.widgets.CMenu', array(
				'itemCssClass' => 'upp',
				'encodeLabel' => false,
				'items' => array(
                                        array('label' => '<a href="#">Languages / 选择语言</a>', 'items' => array(
						array('label'=>'English', 'url'=>array("/member/lang?_lang=en")),
						array('label'=>'中文', 'url'=>array("/member/lang?_lang=cn")),
						)),
					),
				)); ?>
		</div>
	</div>

	<div id="content">
		<div id="sidebar">
			<div class="box">
				<div class="h_title">&#8250; <?php echo Yii::t('memberpanel', 'MainControl'); ?></div>
				<?php $this->widget('zii.widgets.CMenu', array(
					'id' => 'home',
					// 'activateItems' => true, // uncomment this line if you need it.
					// 'activeCssClass' => 'current', // uncomment this line if you need it.
					'itemCssClass' => 'b2',
					'items' => array(
						array('label'=>Yii::app()->user->roles == 'admin' ? Yii::t('memberpanel', 'Member') : Yii::t('memberpanel', 'Account'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'icon report')),
						array('label'=>Yii::t('memberpanel', 'ChangePassword'), 'url'=>array('member/changepassword'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'Announcement'), 'url'=>array('member/announcement'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'Network'), 'url'=>array('member/network'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'Binarynetwork'), 'url'=>array('member/binarynetwork'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'ReferMember'), 'url'=>array('member/refermember'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'Transaction'), 'url'=>array('member/transaction'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>in_array(Yii::app()->user->roles, array('admin', 'staff'))),
						array('label'=>Yii::t('memberpanel', 'ManualTransaction'), 'url'=>array('member/manualtransaction'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>Yii::t('memberpanel', 'SMS'), 'url'=>array('member/sms'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>Yii::t('memberpanel', 'PIN'), 'url'=>array('member/setpin'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles =='user'),
						array('label'=>Yii::t('memberpanel', 'TransferPoint'), 'url'=>array('member/transfercp'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'PurchaseCredit'), 'url'=>array('member/purchase'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles =='user'),
						array('label'=>Yii::t('memberpanel', 'Withdrawal'), 'url'=>array('member/withdraw'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles =='user'),
						array('label'=>Yii::t('memberpanel', 'Payment'), 'url'=>array('member/payment'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles =='user'),
						array('label'=>Yii::t('memberpanel', 'Topup'), 'url'=>array('member/topup'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						)
					)); ?>
			</div>
			<div class="box">
				<div class="h_title">&#8250; <?php echo Yii::t('memberpanel', 'Report'); ?></div>
				<?php $this->widget('zii.widgets.CMenu', array(
					'id' => 'home',
					// 'activateItems' => true, // uncomment this line if you need it.
					// 'activeCssClass' => 'current', // uncomment this line if you need it.
					'itemCssClass' => 'b2',
					'items' => array(
						array('label'=>Yii::t('memberpanel', 'TransactionHistory'), 'url'=>array('member/transactionhistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles!='staff'),
						array('label'=>Yii::t('memberpanel', 'PurchaseHistory'), 'url'=>array('member/purchasehistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
                        array('label'=>Yii::t('memberpanel', 'WithdrawalHistory'), 'url'=>array('member/withdrawhistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
						array('label'=>Yii::t('memberpanel', 'Paymenthistory'), 'url'=>array('member/paymenthistory'), 'linkOptions'=>array('class'=>'icon report'), 'visible'=>Yii::app()->user->roles=='admin'),
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