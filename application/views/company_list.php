<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ini company list</title>
  </head>
  <body>

    <table border="1">
        <thead>
          <tr>
            <th>Company ID</th>
            <th>Company Name</th>
            <th>company Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php isset($company); ?>
          <?php foreach ($company as $data) {?>
            <tr>
              <th><?php echo $data->id;  ?></th>
              <th><?php echo $data->companyname;  ?></th>
              <th><img src="<?php echo base_url('/uploads/thumb/').$data->companyimage; ?>"/></th>
              <th>
                <a href="<?php echo base_url('mycontroller/edit_image/').$data->id; ?>">edit</a>
                <a href="<?php echo base_url('mycontroller/delete_data/').$data->id; ?>">delete</a>
              </th>
            </tr>

          <?php } ?>
          </tbody>
    </table>
  </body>
</html>
