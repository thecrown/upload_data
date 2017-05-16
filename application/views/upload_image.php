<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>

<div id="container">
	<div id="body">
		<?php echo $error_name;
		echo "<br />";
		echo $error_image;?>

		<?php echo form_open_multipart('Mycontroller/do_upload');?>
		<label>Company Name: </label>
		<input type="text" name="Companyname" />
		<br />
		<label>Company Image: </label>
		<input type="file" name="userfile" size="20" />

		<br /><br />

		<input type="submit" value="upload" />
		<?php echo form_close() ?>

	</div>
</div>

</body>
</html>
