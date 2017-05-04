<?php $login_date = date('d-M-Y');?>
<div id="login_form">
<p><?php echo CI_VERSION ;?></p>
<p>
	<strong>Ireland At Home administration system<br />
	<?=$login_date;?></strong>
</p>

<p><?= $heading; ?></p>
<?php
echo form_open('login/validate_credentials');
$name_attributes = array('name' => 'username', 'value' => 'Username', 'size' => '21');
echo form_input($name_attributes);
$password_attributes = array('name' => 'password', 'value' => 'Password', 'size' => '21');
echo form_password($password_attributes);
echo form_submit('submit', 'Log in');
?>

<div style="text-align: center;">
    <script type="text/javascript" src="https://clef.io/v3/clef.js" class="clef-button" data-app-id="7411ab15c63d68602f56fecd141773c7" data-color="white" data-style="flat" data-redirect-url="http://www.corporaterentalseurope.com/iahadmin/index.php/login/clef_validation" data-type="login"></script>
</div>
</div>