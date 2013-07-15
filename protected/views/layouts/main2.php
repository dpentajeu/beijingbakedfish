<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width" />
    <meta name="description" content="Beijing Baked Fish Restaurant Melaka" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" />
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

    <!--  Analytics  -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-42274384-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>

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
                <a href="/">Beijing Baked Fish Restaurant</a>
            </div><!-- end .logo -->
            <ul class="social">
		<li class="phone">58 & 60,Jalan MR 23,Taman Melaka raya,75000 Melaka. +06-2815070</li>
                <li class="twitter"><a href="http://twitter.com/">Twitter</a></li>
                <li class="facebook"><a href="http://facebook.com/">Facebook</a></li>
            </ul><!-- end .social -->
        </div><!-- end .stripe -->
        
        <div class="showcase">
           <div class="form" style="padding-top: 40px;">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'registration-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            ),
                    )); ?>
                    <?php if (!empty($this->Regmsg)): ?>
                            <a href="#" style="font-size: 14px; color:red;"><?php echo $this->Regmsg; ?></a><br/><br/>
                    <?php endif; ?>                    
                    <label class="type" style="padding-right: 15px;"><span style="color: red;">*</span>Name:</label>
                    <?php echo CHtml::textField('Registration[name]', '', array('class'=>'name required','style'=>"width:360px;")); ?>
                    <label class="type" style="padding-right: 15px;"><span style="color: red;">*</span>Phone:</label>
                    <?php echo CHtml::textField('Registration[contact]', '', array('class'=>'required', 'placeholder'=>'Example: 0121235678')); ?>
                    <label class="type" style="padding:5px 5px 2px 10px;">Date of birth:</label>
                    <?php echo CHtml::textField('Registration[dateOfBirth]', '', array('class'=>'date date-end required')); ?><br/><br/><br/><br/><br/>
                    <label class="type" style="padding-right: 15px;"><span style="color: red;">*</span>Referral phone:</label>
                    <?php echo CHtml::textField('Registration[referral]', '', array('class'=>'name required','style'=>"width:360px;", 'placeholder'=>'Phone number of referral (Example: 0121235678)')); ?>
                    <label class="type" style="padding-right: 15px;"><span style="color: red;">*</span>Package:</label>
                    <?php echo CHtml::dropDownList('Registration[packageId]', '', $this->packages, array('prompt'=>'Select a package', 'class' =>'package required','style'=>"width:370px;")); ?>
                    <label class="type" style="padding-right: 15px;"><span style="color: red;">*</span>Email:</label>
                    <?php echo CHtml::textField('Registration[email]', '', array('class'=>'email name required','style'=>"width:360px;")); ?>

                    <?php echo CHtml::submitButton('Register', array('class'=>'submit')); ?> 	
                <?php $this->endWidget(); ?>
            </div><!-- end .form -->
        </div><!-- end .showcase -->
    </div><!-- end .header -->
    <?php echo $content; ?>

	<div class="footer">
    	<ul class="columns">
        	<li class="address"><p>
				<strong>Beijing Baked Fish Restaurant</strong><br />
				58&60, Jalan MR 23, <br />
				Taman Melaka raya, <br />
				75000, Melaka.</p><p>
                Phone: +06-2815070<br />
                <!-- Email: <a href="mailto:some@email.com">hotel@yourdomain.com</a><br/> -->
                1040690-T
                </p>
            </li>
            <li class="map">
				<iframe width="420" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=58+%26+60,Jalan+melaka+raya+23,Taman+Melaka+raya&amp;aq=&amp;sll=2.213023,102.271385&amp;sspn=0.095373,0.157928&amp;ie=UTF8&amp;hq=&amp;hnear=Jalan+Melaka+Raya+23+%26+Jalan+Melaka+Raya+20,+75000+Melaka,+Malaysia&amp;ll=2.182965,102.262061&amp;spn=0.00298,0.004935&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
            </li>
        </ul>
    </div><!-- end .footer -->

</body><!-- end body -->

</html>