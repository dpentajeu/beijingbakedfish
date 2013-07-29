
<!DOCTYPE html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Beijing Baked Fish</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-navi.css" type="text/css" media="all" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" />
     <script type="text/javascript">
    $(function(){
            $(".box .h_title").not(this).next("ul").hide("normal");
            $(".box .h_title").not(this).next("#home").show("normal");
            $(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
    });
    </script>
</head>
    
<body>
<div class="wrap">
	<div id="header">
		<div id="top">
			<div class="left">
				<p>Welcome, <strong><?= $this->name ?></strong> [ <a href="<?php echo Yii::app()->request->baseUrl; ?>/member/logout">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p>Last login: <strong><?php echo Date('Y-m-d h:m:s') ?></strong></p>
				</div>
			</div>
		</div>
		<div id="nav">
			<ul>
                            <?php   if (Yii::app()->user->id==1){ ?>
				<li class="upp"><a href="#">Main control</a>
					<ul>
						<li>&#8250; <a href="<?php echo Yii::app()->request->baseUrl; ?>/member/index">Member</a></li>
						<li>&#8250; <a href="">Network</a></li>
						<li>&#8250; <a href="">Transaction</a></li>
						<li>&#8250; <a href="">SMS</a></li>
					</ul>
				</li>
                            <?php } else { ?>
                                <li class="upp"><a href="#">Main control</a>
					<ul>
						<li>&#8250; <a href="<?php echo Yii::app()->request->baseUrl; ?>/member/index">Account</a></li>
						<li>&#8250; <a href="">Network</a></li>
						<li>&#8250; <a href="">Transaction History</a></li>
					</ul>
				</li>
                            <?php } ?>
			</ul>
		</div>
	</div>
	
	<div id="content">
		<div id="sidebar">
			<div class="box">
                            <?php   if (Yii::app()->user->id==1){ ?>
				<div class="h_title">&#8250; Main control</div>
				<ul id="home">
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/index">Member</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/changepassword">Change password</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/announcement">Announcement</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/network">Network</a></li>
					<li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/transaction">Transaction</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/transactionhistory">Transaction History</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/sms">SMS</a></li>
				</ul>
                            <?php } else { ?>
                                <div class="h_title">&#8250; Main control</div>
				<ul id="home">
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/index">Account</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/changepassword">Change password</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/announcement">Announcement</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/setpin">Set PIN</a></li>
                                        <li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/network">Network</a></li>
					<li class="b2"><a class="icon report" href="<?php echo Yii::app()->request->baseUrl; ?>/member/transactionhistory">Transaction History</a></li>
				</ul>
                            <?php } ?>
				
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

</body>
</html>
