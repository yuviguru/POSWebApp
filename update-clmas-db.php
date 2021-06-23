<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { 

    $ID=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['ID'])));
    
    $Name_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Name'])));
    $Name=addslashes($Name_View);

    $Address1_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address1'])));
    $Address1=addslashes($Address1_View);

    $Address2_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address2'])));
    $Address2=addslashes($Address2_View);

    $City=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['City'])));
    $Pincode=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Pincode'])));
    $State=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['State'])));
    $Mobile=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Mobile'])));
    $Telephone=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Telephone'])));
    $GST=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['GST'])));
    $PAN=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['PAN'])));
    $VAT=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['VAT'])));
    $STX=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['STX'])));
    $CLT_CONTACT_PERSON = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['CPname'])));
    $CLT_MOB_NUM        = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['CPmob'])));
    $CLT_CP_MAIL        = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['CPmail'])));
    
   if(isset($_GET['companystatus'])) {
      $CLT_COMPANY = rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['companystatus'])));
      $CLT_COMPANY_STATUS='"'.$CLT_COMPANY.'"';
      $CLT_COMPANY_STATUS_VIEW=$CLT_COMPANY;
    } else {
       $CLT_COMPANY_STATUS = "NULL";
       $CLT_COMPANY_STATUS_VIEW="";
    }
    $Today=date("Y-m-d H:i:s");
	
	include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
      echo "<br><br><br><br><br>";
    include 'check_page_access.php';

      $sql = "UPDATE client_master set CLT_CLIENT_ID='$ID',CLT_NAME='$Name',CLT_ADDRESS1='$Address1',CLT_ADDRESS2='$Address2',CLT_STATE='$State',CLT_CITY='$City',CLT_PIN='$Pincode',CLT_PHONE1='$Mobile',CLT_PHONE2='$Telephone',CLT_CONTACT_PERSON='$CLT_CONTACT_PERSON',CLT_CP_MOB_NUM='$CLT_MOB_NUM',CLT_CP_MAIL='$CLT_CP_MAIL',CLT_COMPANY_STATUS=$CLT_COMPANY_STATUS ,CLT_PAN='$PAN',CLT_GST_REG='$GST',CLT_VAT_REG='$VAT',CLT_STX_REG='$STX',UPDATED_DATE='$Today' where CLT_CLIENT_ID='$ID'";

      $sql1 = "UPDATE client_master set CLT_APPROVAL='PENDING' where CLT_CLIENT_ID='$ID'";

      if (mysqli_query($conn, $sql)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Client" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
    <div style="overflow-x: scroll;margin-left:40px;margin-right:40px;">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
        <thead>
          <tr style="background: #ccc;">
            <th class="mdl-data-table__cell--numeric">ID</th>
            <th class="mdl-data-table__cell--numeric">Name</th>
            <th class="mdl-data-table__cell--numeric">Address1</th>
            <th class="mdl-data-table__cell--numeric">Address2</th>
            <th class="mdl-data-table__cell--numeric">Pincode</th>
            <th class="mdl-data-table__cell--numeric">City</th>
            <th class="mdl-data-table__cell--numeric">State</th>
            <th class="mdl-data-table__cell--numeric">Mobile</th>
            <th class="mdl-data-table__cell--numeric">Telephone</th>
            <th class="mdl-data-table__cell--numeric">Contact Person</th>
            <th class="mdl-data-table__cell--numeric">Mobile(Contact Person)</th>
            <th class="mdl-data-table__cell--numeric">E-Mail(Contact Person)</th>
            <th class="mdl-data-table__cell--numeric">Company Status</th>
            <th class="mdl-data-table__cell--numeric">PAN Number</th>
            <th class="mdl-data-table__cell--numeric">GST.Reg.No</th>
            <th class="mdl-data-table__cell--numeric">VAT.Reg.No</th>
            <th class="mdl-data-table__cell--numeric">STX.Reg.No</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $ID; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Name_View; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Address1_View; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Address2; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Pincode; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $City; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $State; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Mobile; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $Telephone; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CLT_CONTACT_PERSON; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CLT_MOB_NUM; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CLT_CP_MAIL; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $CLT_COMPANY_STATUS_VIEW; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $PAN; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $GST; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $VAT; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $STX; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewClientDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
      <?php } } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

    if (mysqli_query($conn, $sql1)) { } else {
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