<?php session_start(); ?>
<!doctype html>
<html lang="en">

<?php include 'header.php'; ?>

    <style type="text/css">
        #nameErr,
        #add1Err,
        #cityErr,
        #cityErr,
        #pinErr,
        #stateErr,
        #mobErr {
            color: #d50000;
            position: absolute;
            font-size: 12px;
            margin-top: 3px;
            visibility: visible;
            display: block;
        }
    </style>

    <body>
        <?php include 'navigation.php'; 
     include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){
    $vendor_master='';
    $name          = (isset($_GET['vendorName']) ? $_GET['vendorName'] : null);
    $mob           = (isset($_GET['Mobile']) ? $_GET['Mobile'] : null);
    $add1          = (isset($_GET['add1']) ? $_GET['add1'] : null);
     if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }else{
		
    include 'check_page_access.php';
        $sql_ven_dup_check = $conn->query("SELECT * FROM vendor_master WHERE VEN_NAME='$name' OR VEN_MOB_NO='$mob' OR VEN_ADD1='$add1'");
      }
         if(($sql_ven_dup_check->num_rows > 0) && (!isset($_GET['rec-confirm']))) {
        ?>
            <br>
            <br>
            <br>          
            <br>           
            <br>            
            <br>
            <div class="moz-margin" align="center">
                
                <span style="color:red; font-size:20px;">The Vendor Name or Mobile Number or Address  You have entered is already exist in the Database.<br>Do You want to continue?</span>
                <BR>
                <a href="<?php echo basename($_SERVER['REQUEST_URI']).'&rec-confirm=Yes'?>">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Yes</button>
                </a>
                <a href="vendor-master.php">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">No</button>
                </a>
            </div>
            <br>
            <br>
            <br>
            <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--numeric">Vendor Id</th>
                            <th class="mdl-data-table__cell--numeric">Vendor Name</th>
                            <th class="mdl-data-table__cell--numeric">Contact Person</th>
                            <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
                            <th class="mdl-data-table__cell--numeric">Address 1</th>
                            <th class="mdl-data-table__cell--numeric">Address 2</th>
                            <th class="mdl-data-table__cell--numeric">City</th>
                            <th class="mdl-data-table__cell--numeric">State</th>
                            <th class="mdl-data-table__cell--numeric">Pincode</th>
                            <th class="mdl-data-table__cell--numeric">Mobile No</th>
                            <th class="mdl-data-table__cell--numeric">Telephone</th>
                            <th class="mdl-data-table__cell--numeric">Email</th>
                            <th class="mdl-data-table__cell--numeric">PAN</th>
                            <th class="mdl-data-table__cell--numeric">VAT Regn</th>
                            <th class="mdl-data-table__cell--numeric">STX</th>
                            <th class="mdl-data-table__cell--numeric">Quote Type</th>
                            <th class="mdl-data-table__cell--numeric">Payment Term</th>
                            <th class="mdl-data-table__cell--numeric">Company Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($sql_ven_dup = $sql_ven_dup_check->fetch_assoc()) { ?>
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_PKID'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_NAME'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_CP'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_CON_BRN'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_ADD1'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_ADD2'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_CITY'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_STATE']; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_PINCD'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_MOB_NO'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_TELE_PH'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_EMAIL_ID']; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_PAN'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_VAT'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_STX'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_QUOTE_TYPE'];?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_PAYMENT_TERM']; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_ven_dup['VEN_COMPANY_STATUS'];?></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
            <?php }  
else {
// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} 

 $sql_settings="SELECT Vendor_Master FROM settings";
    $sql_branch = $conn->query($sql_settings);

  if($sql_branch->num_rows > 0){
    while ($sql_bra = $sql_branch->fetch_assoc()) {
      $vendor_master=$sql_bra["Vendor_Master"];
    }
  } 

 if(isset($_GET['submit'])){

  $CB_Name=$_GET['CB_Name'];

$name          = (isset($_GET['vendorName']) ? $_GET['vendorName'] : null);
$name=rtrim(ltrim(preg_replace('/\s+/',' ',$name)));
$add1          = (isset($_GET['add1']) ? $_GET['add1'] : null);
$add1=rtrim(ltrim(preg_replace('/\s+/',' ',$add1)));
$add2          = (isset($_GET['add2']) ? $_GET['add2'] : null);
$add2=rtrim(ltrim(preg_replace('/\s+/',' ',$add2)));
$City          = (isset($_GET['City']) ? $_GET['City'] : null);
$state         = (isset($_GET['State']) ? $_GET['State'] : null);
$pincode       = (isset($_GET['Pincode']) ? $_GET['Pincode'] : null);
$pincode=rtrim(ltrim(preg_replace('/\s+/',' ',$pincode)));
$teleph        = (isset($_GET['telephone']) ? $_GET['telephone'] : null);
$teleph=rtrim(ltrim(preg_replace('/\s+/',' ',$teleph)));
$mob           = (isset($_GET['Mobile']) ? $_GET['Mobile'] : null);
$mob=rtrim(ltrim(preg_replace('/\s+/',' ',$mob)));
$email         = (isset($_GET['email']) ? $_GET['email'] : null);
$email=rtrim(ltrim(preg_replace('/\s+/',' ',$email)));
$contbranch    = (isset($_GET['contbranch']) ? $_GET['contbranch'] : null);

$contpers      = (isset($_GET['conpers']) ? $_GET['conpers'] : null);
$contpers=rtrim(ltrim(preg_replace('/\s+/',' ',$contpers)));
$PAN           = (isset($_GET['PAN']) ? $_GET['PAN'] : null);
$PAN=rtrim(ltrim(preg_replace('/\s+/',' ',$PAN)));
$VAT           = (isset($_GET['VAT']) ? $_GET['VAT'] : null);
$VAT=rtrim(ltrim(preg_replace('/\s+/',' ',$VAT)));
$STX           = (isset($_GET['STX']) ? $_GET['STX'] : null);
$STX=rtrim(ltrim(preg_replace('/\s+/',' ',$STX)));
$CFORM         = (isset($_GET['cform']) ? $_GET['cform'] : null);
$qutote_type   = (isset($_GET['quotetype']) ? $_GET['quotetype'] : null);
$qutote_type=rtrim(ltrim(preg_replace('/\s+/',' ',$qutote_type)));
$payment       = (isset($_GET['paymentterm']) ? $_GET['paymentterm'] : null);
$payment=rtrim(ltrim(preg_replace('/\s+/',' ',$payment)));
$companyStatus = (isset($_GET['companyStatus']) ? $_GET['companyStatus'] : null);

$OLD_VEN_ID    = $_GET['OLD_VEN_ID'];
$vendorid    = $_GET['VEN_ID'];

$Today=date("Y-m-d H:i:s");

$sql="INSERT INTO vendor_master(VEN_PKID,VEN_NAME,VEN_ADD1,VEN_ADD2,VEN_CITY,VEN_STATE,VEN_PINCD,VEN_TELE_PH,VEN_MOB_NO,VEN_EMAIL_ID,VEN_CON_BRN,VEN_CP,VEN_PAN,VEN_VAT,VEN_STX,VEN_CFORM,VEN_QUOTE_TYPE,VEN_PAYMENT_TERM,VEN_COMPANY_STATUS,VEN_CREATED_DATE)
VALUES ('$vendorid','$name','$add1','$add2','$City','$state','$pincode','$teleph','$mob','$email','$contbranch','$contpers','$PAN','$VAT','$STX','$CFORM','$qutote_type','$payment','$companyStatus','$Today')";

$sql1 = "UPDATE settings set Vendor_Master='$vendorid' where Vendor_Master='$OLD_VEN_ID'";

 if (mysqli_query($conn, $sql)) { ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="moz-margin" align="center" style="color: #A6192E ;font-size: 20px;">
                    <?php echo "Vendor" ?> <font color="green"><?php echo $vendorid ?></font>
                        <?php echo "Created successfully"; ?>
                </div>
                <br>
                <br>
                <div style="margin-left:40px;margin-right:40px;overflow-x: scroll;">
                    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--numeric">Vendor Id</th>
                                <th class="mdl-data-table__cell--numeric">Vendor Name</th>
                                <th class="mdl-data-table__cell--numeric">Contact Person</th>
                                <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
                                <th class="mdl-data-table__cell--numeric">Address 1</th>
                                <th class="mdl-data-table__cell--numeric">Address 2</th>
                                <th class="mdl-data-table__cell--numeric">City</th>
                                <th class="mdl-data-table__cell--numeric">State</th>
                                <th class="mdl-data-table__cell--numeric">Pincode</th>
                                <th class="mdl-data-table__cell--numeric">Mobile No</th>
                                <th class="mdl-data-table__cell--numeric">Telephone</th>
                                <th class="mdl-data-table__cell--numeric">Email</th>
                                <th class="mdl-data-table__cell--numeric">PAN</th>
                                <th class="mdl-data-table__cell--numeric">VAT Regn</th>
                                <th class="mdl-data-table__cell--numeric">STX</th>
                                <th class="mdl-data-table__cell--numeric">Quote Type</th>
                                <th class="mdl-data-table__cell--numeric">Payment Term</th>
                                <th class="mdl-data-table__cell--numeric">Company Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $vendorid; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $name; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $contpers; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $CB_Name; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $add1; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $add2; ?> </td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $City; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $state; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"> <?php echo $pincode; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $mob; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $teleph; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $email; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $PAN; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $VAT; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $STX; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $qutote_type; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $payment; ?></td>
                                <td class="mdl-data-table__cell--non-numeric"><?php echo $companyStatus; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <br>
                <div align="center">
                    <a href="viewVendorDetails.php">
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
                    </a>
                </div>

                <?php  } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

      if (mysqli_query($conn, $sql1)) { ?>
                    <?php  } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }
 //  header("location: vendor-master.php");
 // exit;
}
$conn->close();
  }
 } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
    </body>

</html>