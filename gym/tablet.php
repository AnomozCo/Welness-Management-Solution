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
if ($session_role!="gym"){
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if(isset($_POST["studentId"])){
    $studentId = $_POST["studentId"];

    $timeTaken = time();//strval(date("d-m-Y"))+strval(date("h:i:sa")) ;
?><script>console.log("--")</script>
    <?
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
    
    $sql="INSERT INTO `wel_bookings`(`studentId`, `startTime`, `bookingId`, `category`) VALUES ('$studentId', '$timeTaken',  '$bookingId', 'gym')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        ?>
    <script type="text/javascript">
            window.location = "./tablet.php?suc=1";
        </script>
    <?
        
}}
//get flagged students:


//number of rooms booked uptil now
$query = "select 
	(count(startTime)) as 'amount'
from wel_bookings where category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nRoomsBookedTillNow= $row['amount'];
    }
}

//updating rooms in case of expiry
$query_makingRoomsExpire = "select 
*
from lib_bookings where status = 'booked'
"; 
$result_makingRoomsExpire = $con->query($query_makingRoomsExpire);
if ($result_makingRoomsExpire->num_rows > 0)
{ 
    while($row = $result_makingRoomsExpire->fetch_assoc()) 
    { 
        if($row['expiry']<time()){
            $room = $row['room'];
            $sql="update lib_room set status='expired' where room='$room'";
        
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
            
            $sql="update lib_bookings set status='expired' where room='$room'";
        
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
            
        }
    }
}

//free rooms
$query = "select 
	(count(startTime)) as 'amount'
from wel_bookings where startTime='' and category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $ingym= $row['amount'];
    }
}

//booked rooms
$da =date("d-m")."-20".date("y");
$da = strtotime($da);
$query = "select 
	(count(startTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='gym'
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
	(count(startTime)) as 'amount'
from wel_bookings where startTime>'$da' and category='gym'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $monthsSignin= $row['amount'];
    }
}

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
    <div class="main-panel">
      <!-- Navbar -->
     
        
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
            

          <div class="row">
            
            <div class="col-lg-6 col-lg-12">
                <?if(isset($_GET['suc'])){?>
                <div class="alert alert-success" role="alert">
            Your entry was added successfully!
          </div>
                <?}?>
                            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Signing Panel</span>
                      
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="bookingQueue">
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <ul class="nav nav-tabs" data-tabs="tabs">
                        <form action="./tablet.php" method="post">
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
                      <p>Type your ID in numbers, example, 2908</p>
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
