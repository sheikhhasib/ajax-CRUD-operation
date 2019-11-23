<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<h1 class="text-primary text-uppercase text-center"> AJAX CRUD OPERATION </h1>

	<div class="d-flex justify-content-end">
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"> Add Member </button>
	</div>

	<h2 class="text-danger">All Records </h2>
	<div id="records_contant">

	</div>

	<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">AJAX CRUD OPERATION</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        	<label> Firstname:</label>
        	<input type="text" name="" id="firstname" class="form-control" placeholder="First Name">
        </div>
        <div class="form-group">
        	<label> Lastname:</label>
        	<input type="text" name="" id="lastname" class="form-control" placeholder="Last Name">
        </div>

        <div class="form-group">
        	<label> Email Id:</label>
        	<input type="email" name="" id="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
        	<label> Mobile:</label>
        	<input type="text" name="" id="mobile" class="form-control" placeholder="Mobile Number">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="addRecord()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- update modal -->
	
    <div class="modal" id="update_user_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">AJAX CRUD OPERATION</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        	<label for="update_firstname">Update_Firstname:</label>
        	<input type="text" name="" id="update_firstname" class="form-control" placeholder="First Name">
        </div>
        <div class="form-group">
        	<label>Update_Lastname:</label>
        	<input type="text" name="" id="update_lastname" class="form-control" placeholder="Last Name">
        </div>

        <div class="form-group">
        	<label>Utdate_Email Id:</label>
        	<input type="email" name="" id="update_email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
        	<label>Update_Mobile:</label>
        	<input type="text" name="" id="update_mobile" class="form-control" placeholder="Mobile Number">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="updateuserdetails()">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

        <input type="hidden" name="" id="hidden_user_id">   
      </div>

    </div>
  </div>
</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<script type="text/javascript">


    function addRecord(){
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();

        $.ajax({
            url : "backend1.php",
            type : 'post',
            data:{
                firstname :firstname,
                lastname : lastname,
                email : email,
                mobile : mobile
            },

            success: function(data,status){
                readRecords();
            }
        });

    }

//////data display records

    $(document).ready(function(){
        readRecords();
    })
    function readRecords(){
        var readrecords = "readrecords";
        $.ajax({
           url: "backend1.php",
           type:"POST",
           data:{readrecords:readrecords },
           success:function(data,status){
               $("#records_contant").html(data);
           },
        });
    }
    
//// delete userdetails 
    function DeleteUser(deleteid){
        var conf = confirm("Are you sure !");
        if(conf == true){
            $.ajax({
                url: "backend1.php",
                type:"POST",
                data: {deleteid :deleteid},
                success : function(data,status){
                    readRecords();
                }
            });
        }
    }
//get data from user 
function GetUserDetails(id){
    $('#hidden_user_id').val(id);
    $.post("backend1.php",{
        id:id
    },function(data,status){
        var user = JSON.parse(data);
        $('#update_firstname').val(user.firstname);
        $('#update_lastname').val(user.lastname);
        $('#update_email').val(user.email);
        $('#update_mobile').val(user.mobile);
    }

    );

    $('#update_user_modal').modal("show"); 
}


// update data from user 

function updateuserdetails(){
    var firstname = $('#update_firstname').val();
    var lastname = $('#update_lastname').val();
    var email = $('#update_email').val();
    var mobile = $('#update_mobile').val();

    var hidden_user_id = $('#hidden_user_id').val();

    $.post('backend1.php',{
        hidden_user_id:hidden_user_id,
        firstname : firstname,
        lastname :lastname,
        email : email,
        mobile : mobile,
    },function(data,status){
        $('#update_user_modal').modal("hide"); 
        readRecords();
    }
    
    );
}
</script>


</body>
</html>