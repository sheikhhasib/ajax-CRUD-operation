<?php

$conn = mysqli_connect('localhost','root','','crudajax');

extract($_POST);
if(isset($_POST['readrecord'])){

}

if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile']) )
{
	$query = " INSERT INTO `crudtable`(`firstname`, `lastname`, `email`, `mobile`) VALUES ( '$firstname',  '$lastname', '$email', '$mobile'  ) ";
	mysqli_query($conn,$query);

}

//data show statement
if(isset($_POST['readrecords'])){
    $data = '<table class="table table-bordered table-striped">
                <tr class="bg-dark text-white">
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Edit Action</th>
                    <th>Delete Action</th>
                </tr>';

    $displayquery = "SELECT * FROM crudtable";
    $result = mysqli_query($conn,$displayquery);

    if(mysqli_num_rows($result)>0){
        $number = 1;
        while($row = mysqli_fetch_array($result)){
            $data.='<tr>
                        <td>'.$number.'</td>
                        <td>'.$row['firstname'].'</td>
                        <td>'.$row['lastname'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['mobile'].'</td>

                        <td>
                            <button onclick="GetUserDetails('.$row['id'].')" class = "btn btn-success"> Edit</button>
                        </td>
                        <td>
                            <button onclick="DeleteUser('.$row['id'].')" class = "btn btn-danger">Delete</button>
                        </td>
                    </tr>';
                    $number++;      
        }
    }
    $data .='</table>';
        echo $data;
}

//data show statement finish
if(isset($_POST['deleteid']))
{
    $user_id = $_POST['deleteid'];

    $deletequery = "delete from crudtable where id = '$user_id' ";
    if(!$result = mysqli_query($conn,$deletequery)){
        exit(mysqli_error());
    }
}



//get user id for update
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $user_id = $_POST['id'];
    $query = "SELECT * FROM crudtable WHERE id = '$user_id'";
    if (!$result = mysqli_query($conn,$query)) {
        exit(mysqli_error());
    }
    
    $response = array();

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
       
            $response = $row;
        }
    }else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
  //     PHP has some built-in functions to handle JSON.
// Objects in PHP can be converted into JSON by using the PHP function json_encode(): 
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}


// update table
if(isset($_POST['hidden_user_id'])){
    $hidden_user_id = $_POST['hidden_user_id']; 
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $query = "UPDATE `crudtable` SET   `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`mobile`='$mobile' WHERE id = '$hidden_user_id' ";

    mysqli_query($conn,$query); 

}
?>