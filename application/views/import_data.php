<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('headdata') ?>
<title>Upload File</title>
</head>
<body>
<form enctype="multipart/form-data" method="post" role="form">
<div class="form-group">
<label for="exampleInputFile">File Upload</label>
<input type="file" name="file" id="file" size="150">
<p class="help-block">Only CSV File Import.</p>
</div>
<button type="submit" class="btn btn-info" name="submit" value="submit">Upload</button>

</form>
<br>
<a href="<?php echo base_url()?>"><button  class="btn btn-primary" >Back</button>
</body>
</html>