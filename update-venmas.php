<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php'; 
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { 

      $CB_Name=$_GET['CB_Name'];

            $name          = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['vendorName'])));
            $add1          =rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['add1']))); 
            $add2          =rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['add2']))); 
            $City          = $_GET['City'];
            $state         = $_GET['State'];
            $pincode       = $_GET['Pincode'];
            $teleph        = $_GET['telephone'];
            $mob           = $_GET['Mobile'];
            $email         = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['email'])));   
            $contbranch    = $_GET['contbranch'];
            $contpers      = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['conpers'])));  
            $PAN           = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['PAN'])));  
            $VAT           = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['VAT'])));   
            $STX           = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STX'])));
            $qutote_type   = $_GET['quotetype'];
            $payment       = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['paymentterm'])));
            $companyStatus = $_GET['companyStatus'];


        $vendorid    = $_GET['VEN_ID'];

        $Today=date("Y-m-d H:i:s");
  
    ?>

    <?php
   include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
	
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
		
    include 'check_page_access.php';
      echo "<br><br><br><br><br>";

      $sql = "UPDATE vendor_master set VEN_PKID='$vendorid',VEN_NAME='$name',VEN_ADD1='$add1',VEN_ADD2='$add2',VEN_CITY='$City',VEN_STATE='$state',VEN_PINCD='$pincode',VEN_TELE_PH='$teleph',VEN_MOB_NO='$mob',VEN_EMAIL_ID='$email',VEN_CON_BRN='$contbranch',VEN_CP='$contpers',VEN_PAN='$PAN',VEN_VAT='$VAT',VEN_STX='$STX',VEN_QUOTE_TYPE='$qutote_type',VEN_PAYMENT_TERM='$payment',VEN_COMPANY_STATUS='$companyStatus',UPDATED_DATE='$Today' where VEN_PKID='$vendorid'";

      $sql1 = "UPDATE vendor_master set VEN_APPROVAL='PENDING' where VEN_PKID='$vendorid'";

      if (mysqli_query($conn, $sql)) { ?>
        <div  class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Vendor" ?> <font color="green"><?php echo $vendorid ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
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
          <td class="mdl-data-table__cell--non-numeric"><?php echo $add2; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $City; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $state; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $pincode; ?></td>
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
     <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewVendorDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
      <?php } } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

    if (mysqli_query($conn, $sql1)) {
     } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }
      
    }
    ?>
     
<?php } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>   
</div>
</body>
</html>