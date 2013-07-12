
<!DOCTYPE html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Beijing Baked Fish</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-navi.css" type="text/css" media="all" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.2.min.js" type="text/javascript"></script>
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
				<p>Welcome, <strong>Admin</strong> [ <a href="">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p>Last login: <strong><?php echo Date('Y-m-d h:m:s') ?></strong></p>
				</div>
			</div>
		</div>
		<div id="nav">
			<ul>
				<li class="upp"><a href="#">Main control</a>
					<ul>
						<li>&#8250; <a href="">Visit site</a></li>
						<li>&#8250; <a href="">Reports</a></li>
						<li>&#8250; <a href="">Add new page</a></li>
						<li>&#8250; <a href="">Site config</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Manage content</a>
					<ul>
						<li>&#8250; <a href="">Show all pages</a></li>
						<li>&#8250; <a href="">Add new page</a></li>
						<li>&#8250; <a href="">Add new gallery</a></li>
						<li>&#8250; <a href="">Categories</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Users</a>
					<ul>
						<li>&#8250; <a href="">Show all uses</a></li>
						<li>&#8250; <a href="">Add new user</a></li>
						<li>&#8250; <a href="">Lock users</a></li>
					</ul>
				</li>
				<li class="upp"><a href="#">Settings</a>
					<ul>
						<li>&#8250; <a href="">Site configuration</a></li>
						<li>&#8250; <a href="">Contact Form</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	
	<div id="content">
		<div id="sidebar">
			<div class="box">
				<div class="h_title">&#8250; Main control</div>
				<ul id="home">
					<li class="b2"><a class="icon report" href="">Reports</a></li>
				</ul>
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
