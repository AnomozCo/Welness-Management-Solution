<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}


if(isset($_GET["changeRoleId"])){
    $email = $_GET["changeRoleId"];
    $role = $_GET["role"];
    
     $sql="update wel_users set role='$role' where email='$email'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}


if(isset($_GET["removeUser"])){
    $email = $_GET["removeUser"];
    
    $sql="delete from wel_users where email='$email'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}

if(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    
     $sql="insert into wel_users(name, email, password, role) values('$name', '$email', '$password', 'gym')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}


if(isset($_POST["oldPassword"])){
    $newPassword = md5($_POST["newPassword"]);
    $oldPassword = md5($_POST["oldPassword"]);

if((!$newPassword)||(!$oldPassword)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="update wel_users  set password='$newPassword' where password='$oldPassword' and email='$session_email '";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <?
        
}}


$query_users = "select * from wel_users"; 


?>
<!DOCTYPE html>
<html lang="en">
<?include_once("./phpParts/head.php");?>


<body class="">
  <div class="wrapper ">
      <?include"./phpParts/leftBar.php"?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Settings</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              
              
              <div class="card" style="margin-top: 40px;">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Change Password</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Old Password</label>
                          <input id="studentIdBox"  name="oldPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                       <div class="form-group col-md-6">
                          <label for="inputEmail4">New Password</label>
                          <input id="studentIdBox"  name="newPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        
        </div>
        
        
        
        <?if(true){?>
                <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Users</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    
                    <table class="table">
                        <thead class=" text-primary">
                        <th>
                          Name
                        </th>
                        <th class="text-primary">
                          Email
                        </th>
                        <th>
                          Role
                        </th>
                        <th>
                          Action
                        </th>
                        <th>
                          Remove
                        </th>
                        
                      </thead>
                        <tbody>
                          <?php
                          $result_users = $con->query($query_users); 
                            if ($result_users->num_rows > 0)
                            { 
                                while($row = $result_users->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".$row['role']."</td>";
                                    if($row['role']=="admin"){
                                        echo '<td><a href="./settings.php?changeRoleId='.$row['email'].'&role=gym"><button class="btn btn-social btn-just-icon btn-google" style="background-color:orange;"><i class="material-icons">arrow_downward</i></button></a></td>';
                                    }
                                    else if($row['role']=="pool"){
                                        echo '<td><a href="./settings.php?changeRoleId='.$row['email'].'&role=admin"><button class="btn btn-social btn-just-icon btn-google" style="background-color:green;"><i class="material-icons">arrow_upward</i></button></a></td>';
                                    }
                                    else if($row['role']=="gym"){
                                        echo '<td><a href="./settings.php?changeRoleId='.$row['email'].'&role=pool"><button class="btn btn-social btn-just-icon btn-google" style="background-color:green;"><i class="material-icons">arrow_upward</i></button></a></td>';
                                    }
                                    echo '<td><a href="./settings.php?removeUser='.$row['email'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                          ?>
                          
                        </tbody>
                      </table>
                      <tr>
                    <td>
                        <form method="post" action="" style="background-color:#f5eef6;padding:10px;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Name</label>
                                  <input name="name" type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Email</label>
                                  <input name="email" type="email" class="form-control" placeholder="" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Password</label>
                                  <input name="password" type="password" class="form-control" placeholder="" required>
                                </div>
                               
                              </div>
                            
                            <button type="submit" class="btn btn-primary">Insert User</button>
                        </form>
                    </td>
                  </tr>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?}?>

      </div>
     <?include_once("./phpParts/footer.php");?>
     <script>
     var count = 0;
         function showFlaggedStudents(){
            var search = document.getElementById("studentIdBox").value;
            if (search!= '')
            {
                //show studentname
                count = 0;
                var countI = 0;
                //search = Number(search)
                for (var i = 0; i < students_id_lst.length; i++) {
                    if(students_id_lst[i].indexOf(search) != -1)
                    {
                        //console.log("students_id_lst[i]", students_id_lst[i], students_name_lst[i]);
                        count +=1;
                        countI=i;
                    }
                }
                if(count==1){
                    document.getElementById("studentNameBox").value = (students_name_lst[countI]).toString();
                    document.getElementById("oldPhoneBox").value = (students_mobile_lst[countI]).toString();
                }
                if(count!=1){
                    document.getElementById("studentNameBox").value = "";
                    document.getElementById("oldPhoneBox").value = "";
                    document.getElementById("submitBtn").disabled = true;

                }
                
            }
            if (search== '')
            {
                document.getElementById("flaggedStudentsBox").innerHTML = " ";
                document.getElementById("flaggedStudentsBox").style.display = "none";
                document.getElementById("studentNameBox").value = "";
                document.getElementById("submitBtn").disabled = true;
            }
            
        }

    function validNumber(){
        if(document.getElementById("newPhoneBox").value.length==12){
            document.getElementById("submitBtn").disabled = false;
                
            }else{
                document.getElementById("submitBtn").disabled = true;
            }
    }
     </script>
     
</body>

</html>
