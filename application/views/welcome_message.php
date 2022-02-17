<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Router Details</title>
	
</head>
<style>
   .duplicate {
      background-color: red;
}
.btn{padding:5px !important;margin: 2px;}
</style>

<body>

	<div class="container">

	    <div class="row">
	      	<div class="col-md-12">
            <?php $this->load->view('headdata') ?>
	        	<h2>Upload CSV file</h2>
              <a href="<?php echo base_url().'welcome/importdata'?>"><button class="btn btn-primary"> Upload Data</button></a>
            <br><br>
	      	</div>
	    </div>

	    <div class="row">

	    	<!-- Router list -->
			<div class="col-md-12 mt-4" >

				<h3 class="mb-4">Router List</h3>
				<table  id="item-list" class="table table-bordered table-hover" width="100%">
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
                  var bindHtml = '<span style="color:red;">';
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
                  bindHtml +='</span>';
                  return bindHtml;
               }
            },
            {
               mRender: function (data, type, row) {
                  var bindHtml = '';
                  bindHtml += '<button  data-staffid="' + row[0] + '" type="button" class="btn rkmd-btn" id="update-staff"><i class="fas fa-edit"></i></button>';
                  bindHtml += '<button  data-staffid="' + row[0] + '" type="button" class="btn rkmd-btn" id="delete-staff"><i class="fas fa-times"></i></button>';
                  return bindHtml;
               }
            },

         ],
         "rowCallback": function( row, data, index ) {
            //Logic for Duplicate Entries 
            for(var i=0; i<4; i++){
               //console.log(i) ;
               var allData = this.api().column(i).data().toArray();
               if (allData.indexOf(data[i]) != allData.lastIndexOf(data[i])) {
                  j= i-1;
                  $(row).css('background-color', 'grey');
                  
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
            var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
            


            if(sap.length !='18'){ 
               alert("Sapid is not as per the format");
            }
            else if(host.length !='14'){ 
               alert("Hostname is not as per the format");
            }
            else if(!(ipformat.test(loop))){ 
               alert("Loopback is not as per the format");
            }
            else if(mac.length !='17'){ 
               alert("Mac address is not as per the format");
            }else{
               // AJAX request
               $.ajax({
               url: 'Welcome/updatedata',
               type: 'post',
               data: {id: id,sap:sap,host:host,loop:loop,mac:mac},
               success: function(response){
                     alert("Record updated.");
                     userDataTable.ajax.reload();
               }
               });

            }
            
      });

  // Delete record
      $('#item-list').on('click','#delete-staff',function(){
         var id = $(this).attr('data-staffid');
         
         var deleteConfirm = confirm("Are you sure?");
         if (deleteConfirm == true) {
            // AJAX request
            $.ajax({
               url: 'Welcome/deletedata',
               type: 'post',
               data: {id: id},
               success: function(response){
                     alert("Record deleted.");
                     // Reload DataTable
                     userDataTable.ajax.reload();
               }
            });
         } 

      });
   });
</script>  
   
</body>
</html>