<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Router Details</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
	
	
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" />
  
 
  <link href="https://webdamn.com/demo/datatables-add-edit-delete-codeigniter-ajax-demo/assets/css/style.css" rel="stylesheet">

	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
</head>
<style>
   .duplicate {
      background-color: red;
}
</style>

<body>

	<div class="container">

	    <div class="row">
	      	<div class="col-md-12">
	        	

		        <form id="form" action="" method="post" enctype="multipart/form-data">

		           	<div class="form-group">
		              	<label for="file">File:</label>                   

		              	<input type="file" class="form-control" id="csv_file" name="csv_file" />

		           	</div>
				
		           	<input type="submit" class="btn btn-success" id="import" name="submit" value="Import CSV">
		        </form>
	      	</div>
	    </div>

	    <div class="row">

	    	<!-- Users list -->
			<div class="col-md-12 mt-4" >

				<h3 class="mb-4">Router List</h3>
				<table  id="item-list" class="table table-bordered table-striped table-hover" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>SAP ID</th>
							<th>Hostname</th>
							<th>Loopback</th>
							<th>Mac Address</th>
                     <th>Comments</th>
							<th>Action</th>
							
						</tr>
					</thead>
					<tbody id="tBody"> </tbody>
				</table>
			</div>

	    </div>
  	</div>
	  

<script languge="javascript" type="text/javascript">


    $(document).ready(function() {  
		
        var userDataTable = $('#item-list').DataTable({
     'processing': true,
     'serverSide': true,
     'serverMethod': 'post',
     'ajax': {
        'url':'Welcome/get_items'
     },
     "columns": [
		{
			"bVisible": false, "aTargets": [0]
		},
		{
			mRender: function (data, type, row) {
				var bindHtml = '';
				bindHtml += '<input id ="sap'+row[0]+'" type="text" value ="'+row[1]+'">';
				return bindHtml;
			}
		},
		{
			mRender: function (data, type, row) {
				var bindHtml = '';
				bindHtml += '<input id ="host'+row[0]+'" type="text" value ="'+row[2]+'">';
				return bindHtml;
			}
		},
		{
			mRender: function (data, type, row) {
				var bindHtml = '';
				bindHtml += '<input id ="loop'+row[0]+'" type="text" value ="'+row[3]+'">';
				return bindHtml;
			}
		},
		{
			mRender: function (data, type, row) {
				var bindHtml = '';
				bindHtml += '<input id ="mac'+row[0]+'" type="text" value ="'+row[4]+'">';
				return bindHtml;
			}
		},
      {
			mRender: function (data, type, row) {
            var bindHtml = '';
            if(row[1] == ''){
						bindHtml += 'sap id missing';
            }
            if(row[2] == ''){
						bindHtml += ', hostname missing';
            }
            if(row[3] == ''){
						bindHtml += ', Loopback missing';
            }
            if(row[4] == ''){
						bindHtml += ', Mac address missing';
            }
				return bindHtml;
			}
		},
		{
			mRender: function (data, type, row) {
				var bindHtml = '';
				bindHtml += '<button  data-staffid="' + row[0] + '" type="button" class="btn rkmd-btn btn-warning" id="update-staff"><i class="fas fa-edit"></i></button>';
				bindHtml += '<button  data-staffid="' + row[0] + '" type="button" class="btn rkmd-btn btn-success" id="delete-staff"><i class="fas fa-times"></i></button>';
				return bindHtml;
			}
		},

	 ],
    "rowCallback": function( row, data, index ) {
      for(var i=0; i<=4; i++){
         
         //console.log(i) ;
          var allData = this.api().column(i).data().toArray();
          if (allData.indexOf(data[i]) != allData.lastIndexOf(data[i])) {
            j= i-1;
            $('td:eq("'+j+'")', row).css('background-color', 'grey');
            // $('td:eq(0)', row).css('background-color', 'Red');
            //console.log(j) ;
            //console.log('("'+i+'")');
          }}
          
    }

  });

  // Update record
  $('#item-list').on('click','#update-staff',function(){
     
   var id = $(this).attr('data-staffid');
   var sap = $('#sap'+id).val();
   var host = $('#host'+id).val();
   var loop = $('#loop'+id).val();
   var mac = $('#mac'+id).val();
   
  // alert(sap)
     // AJAX request
     $.ajax({
        url: 'Welcome/updatedata',
        type: 'post',
        data: {id: id,sap:sap,host:host,loop:loop,mac:mac},
        dataType: 'json',
        success: function(response){
           //if(response.status == 1){

            alert("Record updated.");
             userDataTable.ajax.reload();
           //}else{
             //alert("Invalid ID.");
           //}
        }
     });

  });

  // Save user 
  $('#btn_save').click(function(){
     var id = $('#txt_userid').val();

     var name = $('#name').val().trim();
     var email = $('#email').val().trim();
     var gender = $('#gender').val().trim();
     var city = $('#city').val().trim();

     if(name !='' && email != '' && city != ''){

       // AJAX request
       $.ajax({
         url: 'ajaxfile.php',
         type: 'post',
         data: {request: 3, id: id,name: name, email: email, gender: gender, city: city},
         dataType: 'json',
         success: function(response){
            if(response.status == 1){
               alert(response.message);

               // Empty and reset the values
               $('#name','#email','#city').val('');
               $('#gender').val('male');
               $('#txt_userid').val(0);

               // Reload DataTable
               userDataTable.ajax.reload();

               // Close modal
               $('#updateModal').modal('toggle');
            }else{
               alert(response.message);
            }
         }
      });

    }else{
       alert('Please fill all fields.');
    }
  });

  // Delete record
  $('#item-list').on('click','#delete-staff',function(){
     var id = $(this).attr('data-staffid');
	 //alert(id)

     var deleteConfirm = confirm("Are you sure?");
     if (deleteConfirm == true) {
        // AJAX request
        $.ajax({
          url: 'Welcome/deletedata',
          type: 'post',
          data: {id: id},
          success: function(response){
            // if(response == 1){
                alert("Record deleted.");

                // Reload DataTable
                userDataTable.ajax.reload();
            // }else{
               // alert("Invalid ID.");
            // }
          }
        });
     } 

  });
});
</script>  
   
</body>
</html>