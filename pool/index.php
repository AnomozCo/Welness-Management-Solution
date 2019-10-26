<?include_once("../global.php");
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "../";
        </script>
    <?
}
if ($logged==1){ 
    if($session_role=="pool"){
       ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <? 
    }
    else{
         ?>
    <script type="text/javascript">
            window.location = "../";
        </script>
    <? 
    }
}

?>
