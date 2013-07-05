<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width" />
    <meta name="description" content="Beijing Baked Fish Restaurant" />

	<title>Beijing Baked Fish Restaurant</title>

	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-1.9.0.custom.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox-1.3.4.css" type="text/css" media="all" />

	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.9.0.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bnb.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.js" type="text/javascript"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2473517-29']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>

	<div class="header">
    	<div class="stripe">
        	<div class="logo">
            	<a href="#">Beijing Baked Fish Restaurant</a>
            </div><!-- end .logo -->
            <ul class="social">
				<li class="phone">8 Jalan ABC, Melaka. +6017-8888888</li>
                <li class="twitter"><a href="http://twitter.com/">Twitter</a></li>
                <li class="facebook"><a href="http://facebook.com/">Facebook</a></li>
            </ul><!-- end .social -->
        </div><!-- end .stripe -->
        
            <div class="showcase">
            <div class="form">
                <form class="booking" action="#" name="booking">
                    <label class="type">Name:</label>
                    <input type="text" name="name" class="name required" />   
                    <label class="from">Phone:</label>
                    <input type="text" name="from" class="date-start required" />
                    <label class="to">D.O.B:</label>
                    <input type="text" name="to" class="date date-end required" />
                    <label class="type">Address:</label>
                    <input type="text" name="address" class="name required" />
                    <label class="for-email">Email:</label>
                    <input type="text" name="email" class="email required" />
                    <input type="submit" class="submit" name="submit" value="Register" />
                </form>
            </div><!-- end .form -->
        </div><!-- end .showcase -->
    </div><!-- end .header -->
    <?php echo $content; ?>

	<div class="footer">
    	<ul class="columns">
        	<li class="address"><p>
				<strong>Beijing Baked Fish Restaurant</strong><br />
				8 Jalan ABC<br />
				Tmn EFG, Melaka<br />
				LA12 8NN</p><p>
                Phone: +6017-8888888<br />
                Email: <a href="mailto:some@email.com">hotel@yourdomain.com</a>
                </p>
            </li>
            <li class="map">
				<iframe width="420" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=fell+foot+park&amp;aq=&amp;sll=54.273469,-2.95455&amp;sspn=0.019295,0.055747&amp;ie=UTF8&amp;hq=&amp;hnear=Fell+Foot+Park,+Newby+Bridge,+Windermere,+Cumbria+LA12+8NN,+United+Kingdom&amp;ll=54.274027,-2.95261&amp;spn=0.019295,0.055747&amp;t=m&amp;z=14&amp;output=embed"></iframe>
            </li>
        </ul>
    </div><!-- end .footer -->

</body><!-- end body -->

</html>