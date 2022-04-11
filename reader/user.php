<?php
require("config.php");
session_start();
$username=$_SESSION['usr'];
$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
    file_put_contents('UIDContainer.php',$Write);
    $vtb=mysqli_query($mysqli,"select * from tbllogin where username='$username'");
    $r=mysqli_fetch_row($vtb);
    $x=$r[2];

?>


<!DOCTYPE html>
<html>
<head>
    <title>index</title>
    <link rel="stylesheet" href="in.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
        <script src="jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                 $("#getUID").load("UIDContainer.php");
                setInterval(function() {
                    $("#getUID").load("UIDContainer.php");  
                }, 500);
            });
        </script>
</head>
<body>

    <div class="aheader">
     <a href="login.php">HOME</a>  
     <a href="logout.php">LOGOUT</a>
    </div>

   <!-- partial:index.partial.html -->
        <div class="ulogin">
            <br>
            <div class="center" style="margin: 0 auto; width:495px;">
                <div class="row">
                    <h3 align="center">Reading RFID</h3>
                </div>
                <br>
                <form class="form-horizontal" action="insertDB.php" method="post" >
                    <div class="control-group">
                        <label class="control-label">RFID TAG</label>
                        <div class="controls">
                            <textarea name="id" id="getUID" placeholder="Please scan the Vehicle" rows="1" cols="1" required></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Checkpont location </label>
                        <div class="controls">
                            <table align="center" ><tr><?php echo $x ?></tr></table>
                        </div>
                    </div>
                    
                    
                    <div class="control-group">
                         <table >
                            <tr>
                              <label class="control-label">Timestamp </label> 
                        <div class="controls">
                           <?php $t=time(); echo $t ?></table>
                        </div>
                    </div>
                    
                   
                    
                    
                </form>
                
            </div>               
        </div> <!-- /container -->  
<!-- partial -->

</body>
</html>