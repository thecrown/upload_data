<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to </title>
</head>
<body>

<div id="container">
	<div id="body">
		<?php echo $error_name;
		echo "<br />";
		echo $error_image;?>
<!--<?php
  var_dump($data_company);
?>-->
<?php foreach ($data_company as $row) {?>
    <?php echo form_open_multipart('Mycontroller/do_update/'.$row->id);?>

			<label>Company Name: </label>
  		<input type="text" name="Companyname" value="<?php echo $row->companyname;?>"/>
  		<br />
  		<label>Company Image: </label>
      <img src="<?php echo base_url('/uploads/thumb/').$row->companyimage; ?>" width="70px" height="50px">
  		<input type="file" name="userfile" size="20" />
  		<br /><br />
  		<input type="submit" value="upload" />

		<?php echo form_close();?>
<?php }?>

	</div>
</div>

</body>
</html>
