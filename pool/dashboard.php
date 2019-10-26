<?include_once("../global.php");?>
<!DOCTYPE html>
<html lang="en">

<?include("../phpParts/head.php")?>
<body class="">

<?
function logout() {
    session_destroy();
  }
  if (isset($_GET['logout'])) {
    logout();
    $logged=0;
  }
  
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if ($session_role!="pool"){
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}


if(isset($_POST["studentId"])){
    $studentId = $_POST["studentId"];

    $timeTaken = time();//strval(date("d-m-Y"))+strval(date("h:i:sa")) ;

if((!$studentId)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
    
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    $bookingId = generateRandomString();
    
    $sql="INSERT INTO `wel_bookings`(`studentId`, `startTime`, `bookingId`, `category`) VALUES ('$studentId', '$timeTaken',  '$bookingId', 'pool')";
    
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
//get flagged students:



//free room
if(isset($_GET["bookingId"])){
    $bookingId = $_GET["bookingId"]; 

if((!$bookingId)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
    $endTime = time();
    $sql="update wel_bookings set endTime='$endTime' where bookingId = '$bookingId'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        ?>
   
    <?
        
}}


//number of rooms booked uptil now
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nRoomsBookedTillNow= $row['amount'];
    }
}


//free rooms
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where endTime='' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $inPool= $row['amount'];
    }
}

//booked rooms
$da =date("d-m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nBookedRooms= $row['amount'];
    }
}

//months signin
$da = "1-".date("m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(endTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='pool'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $monthsSignin= $row['amount'];
    }
}

//free rooms list for booking
$query_freeRoomsListBooking = "select*from wel_students s inner join wel_bookings b on s.cardnumber = b.studentId where b.endTime='' and b.category='pool' order by b.id desc
"; 
$result_freeRoomListBooking = $con->query($query_freeRoomsListBooking); 

?>
<script>
    var students_id_lst = [];
    var students_name_lst = [];
</script>
<?
$query = "SELECT * from wel_students order by id desc
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            students_id_lst[<?echo $i?>] = "<?echo $row['cardnumber']?>"
            students_name_lst[<?echo $i?>] = "<?echo $row['firstname']." ".$row['surname']?>"
        </script>
        <?
        $i +=1;
    }
}

?>
  <div class="wrapper">
    <?include("./phpParts/leftBar.php")?>
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
          <div class="collapse navbar-collapse justify-content-end">
           
            <ul class="navbar-nav">
            
              
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="./dashboard.php?logout=true">Log out</a>
                </div>
              </li>
            </ul>
          </div>
          
        </div>
      </nav>
        
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
            <div class="alert alert-primary" role="alert" style="display:none;" id="pageReloadPop">
            Update detected. Page reloading...
        </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">pool</i>
                  </div>
                  <p class="card-category">People in Pool</p>
                  <h3 class="card-title"><?echo $inPool?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of people currently in pool
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">calendar_today</i>
                  </div>
                  <p class="card-category">Today's signins</p>
                  <h3 class="card-title" id="nBookedRooms"><?echo $nBookedRooms?>                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed in today
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Month's signins</p>
                  <h3 class="card-title" id="nExpiredRooms"><?echo $monthsSignin?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who signed in this month
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">library_books</i>
                  </div>
                  <p class="card-category">Total Signins</p>
                  <h3 class="card-title"><?echo $nRoomsBookedTillNow?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of students who have signed up till now
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            
            <div class="col-lg-6 col-lg-12">
                            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Signing Panel</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="add students to the queue when all rooms are busy">
                          <a class="nav-link active" href="#bookingQueue" data-toggle="tab">
                            Signed in
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#book" data-toggle="tab">
                            Signin
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="bookingQueue">
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-success">
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Time</th>
                      <th>Action</th>
                    </thead>
                        <tbody>
                      <?
                      date_default_timezone_set("Asia/Karachi");
                      if ($result_freeRoomListBooking->num_rows > 0)
                            { 
                                while($row = $result_freeRoomListBooking->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['firstname']." ".$row['surname']."</td>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".date('H:i',$row['startTime'])."</td>";
                                    echo '<td data-toggle="tooltip" data-placement="right" title="book room">
                                    <a href="./dashboard.php?bookingId='.$row['bookingId'].'"><button class="btn btn-success btn-sm">Finish!<div class="ripple-container">
                                    </div></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                      ?>
                    
                    </tbody>
                      </table>
                  
                    <tr>
                    
                  </tr>
                </div>

                    </div>
                    <div class="tab-pane" id="book">
                      <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <ul class="nav nav-tabs" data-tabs="tabs">
                        <form action="" method="post">
                        <li class="nav-item">
                          <a class="nav-link">
                            <input id="studentIdBox" onkeyup="showFlaggedStudents()" name="studentId" type="text" class="form-control" placeholder="Student Id" required style="color:black;">
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link">
                            <input id="studentNameBox" name="studentname" type="text" class="form-control" placeholder="" required style="color:black;background-color:#bcfdde;padding:5px;" readonly>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link">
                              <button type="submit" class="btn btn-success" id="submitBtn" style="background-color:green"disabled>Sign in!</button>
                          </a>
                        </li>
                        </form>
                      </ul>
                      </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
            <?//include("../phpParts/footer.php")?>
             
 <script src="https://hu.anomoz.com/wellness/assets/js/core/jquery.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/core/popper.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="https://hu.anomoz.com/wellness/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
<!--
  <script src="https://hu.anomoz.com/wellness/assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  -->
</body>
<script>
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
                    document.getElementById("submitBtn").disabled = false;
                    
                }
                if(count!=1){
                    document.getElementById("studentNameBox").value = "";
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
        
    //console.log("students_id_lst" , students_id_lst);
</script>
</html>
