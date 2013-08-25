<!DOCTYPE html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Beijing Baked Fish</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-login.css" type="text/css" media="all" />
</head>
<body>
<div class="wrap">
	<div id="content" style="margin-top: 20px">
		<div id="main">
                        <div style="text-align: center; padding-bottom: 10px;">
                            <img src="<?php echo Yii::app()->request->baseUrl;?>/images/bbf.jpg" style="width:350px; height:220px;"/>
                        </div>
			<div class="full_w">
                            <div class="form">
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'login-form',
                                        'enableClientValidation'=>true,
                                        'clientOptions'=>array(
                                                'validateOnSubmit'=>true,
                                        ),
                                )); ?>
                                        <div class="row">
                                                <label for="login">Phone Number:</label>
                                                <?php echo $form->textField($model,'username',array('class'=>'text')); ?>
                                                <?php echo $form->error($model,'username'); ?>
                                        </div>

                                        <div class="row">
                                                <label for="pass">Password:</label>
                                                <?php echo $form->passwordField($model,'password',array('class'=>'text')); ?>
                                                <?php echo $form->error($model,'password'); ?>
                                        </div>

                                        <?php if(extension_loaded('gd')): ?>
                                            <div class="row">           
                                                <?php echo "Security Check" ?>
                                                <?php echo $form->textField($model,'verifyCode', array('class'=>'text')); ?>                      
                                                <div>
                                                    <?php $this->widget('CCaptcha'); ?>
                                                </div>
                                                <?php echo $form->error($model,'verifyCode'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="row buttons">
                                                <button type="submit" class="ok">Login</button> 
                                                <a class="button" href="<?php echo Yii::app()->request->baseUrl; ?>/member/resetpassword" ?>Forgotten password?</a>
                                        </div>

                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
			<div class="footer">&raquo; <a href="http://beijingbakedfish.com">beijingbakedfish.com</a></div>
		</div>
	</div>
</div>

</body>
</html>
