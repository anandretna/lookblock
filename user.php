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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <!-- Bootstrap -->

    <title>index</title>
    <link rel="stylesheet" href="in.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
     
    
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
                    <h3 align="center">Reading RFID TAG</h3>
                </div>
                <br>
                <!-- form2 -->

                <form id= "form2"  method="post" >
                    <div class="control-group">
                        <label class="control-label">RFID TAG</label>
                        <div class="controls">
                           <textarea id="getUID" placeholder="Please scan the Vehicle"  rows="0" cols="0" required></textarea>
                        </div>
                    </div>
                    
                     <div class="control-group">
                        <label type="text" class="control-label"> <?php echo $x ?> </label>
                        <div class="controls">
                        <input type="text" class="forminput" id="prodlocation" required>
                        </div>
                        </div>
                   
                    </div>
                    
                        <button id="mansub" type="submit">Update</button>
                    
                </form>
                
            </div>               
        </div> <!-- /container -->  
<!-- partial -->
 <div class='box'>
      <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Web3.js -->
    <script src="web3.min.js"></script>

    <!-- QR Code Library-->
    <script src="./dist/qrious.js"></script>

    <!-- QR Code Reader -->
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <script src="app.js"></script>


    <!-- Web3 Injection -->
    <script>
      // Initialize Web3
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      } else {
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      }

      // Set the Contract
    var contract = new web3.eth.Contract(contractAbi, contractAddress);



    $("#manufacturer").on("click", function(){
        $("#districard").hide("fast","linear");
        $("#manufacturercard").show("fast","linear");
    });

    $("#distributor").on("click", function(){
        $("#manufacturercard").hide("fast","linear");
        $("#districard").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });


    $('#form1').on('submit', function(event) {
        
        prodname = $('#prodname').val();
        console.log(prodname);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.newItem(prodname, thisdate).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="<h5 style='color: #53D769'><b>Item Added Successfully</b></h5><p>Product ID: "+receipt.events.Added.returnValues[0]+"</p>";
              qr.value = receipt.events.Added.returnValues[0];
              $bottom="<p style='color: #FECB2E'> You may print the QR Code if required </p>"
              $("#alertText").html(msg);
              $("#qrious").show();
              $("#bottomText").html($bottom);
              $(".customalert").show("fast","linear");
          });
          //console.log(receipt);
        });
        $("#prodname").val('');
        
    });


    // Code for detecting location
     if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    function showPosition(position) {
        var autoLocation = position.coords.latitude +", " + position.coords.longitude;
        $("#prodlocation").val(autoLocation);
    }

    $('#form2').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodid = "0";
        prodlocation = $('#prodlocation').val();
        console.log(prodid);
        console.log(prodlocation);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+" "+today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var info = "<br><br><b>Date: "+thisdate+"</b><br>Location: "+prodlocation;
        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.addState(prodid, info).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              window.alert("ok");
              var msg="Item has been updated ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          });
        });
        $("#prodid").val('');
      });


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }


  function openQRCamera(node) {
        var reader = new FileReader();
        reader.onload = function() {
            node.value = "";
            qrcode.callback = function(res) {
            if(res instanceof Error) {
                alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
            } else {
                node.parentNode.previousElementSibling.value = res;
                document.getElementById('searchButton').click();
            }
            };
            qrcode.decode(reader.result);
        };
        reader.readAsDataURL(node.files[0]);
    }

  function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    $("#aboutbtn").on("click", function(){
        showAlert("Automobile surveillance and tracking using Radio Frequency Identification (RFID) and Blockchain LOOKBLOCK");
    });

    </script>
</body>
</html>