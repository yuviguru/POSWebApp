<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>
  <body>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php'; 
    if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes') { 

    include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
	
    include 'check_page_access.php';
      $Name_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Name'])));
      $Name=addslashes($Name_View);
      $City=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['City'])));
      $Mobile=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Mobile'])));

      $sql__dup_check = $conn->query("SELECT * FROM client_master WHERE CLT_NAME='$Name' AND CLT_CITY='$City' OR CLT_PHONE1='$Mobile'");
      if(($sql__dup_check->num_rows > 0) && (!isset($_GET['Confirmation']))) { ?><br><br><br> 

      <div class="moz-margin" align="center">
        <h3 style="color:red;font-size:20px;">The Client Name and City or Mobile You have entered is already exist in the Database.<br>Do You want to continue?</h3>
        <a href="<?php echo basename($_SERVER['REQUEST_URI']).'&Confirmation=Yes'?>"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Yes</button></a>
        <a href="client-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">No</button></a>
      </div><br> 
      <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">ID</th>
          <th class="mdl-data-table__cell--numeric">Name</th>
          <th class="mdl-data-table__cell--numeric">Address1</th>
          <th class="mdl-data-table__cell--numeric">Address2</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
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
      <?php while ($sql_client_dup = $sql__dup_check->fetch_assoc()) { ?>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_CLIENT_ID'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_NAME'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_ADDRESS1']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_ADDRESS2'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_CITY'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_STATE'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_PIN'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_PHONE1'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_PHONE2'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_CONTACT_PERSON']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_CP_MOB_NUM']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_CP_MAIL']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_COMPANY_STATUS']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_PAN']; ?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_GST_REG'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_VAT_REG'];?></td>
            <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_dup['CLT_STX_REG'];?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    </div>
    <?php } 

   else {

    $OLD_ID=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['OLD_ID'])));

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

    $Today=date("Y-m-d");


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
      echo "<br><br><br><br><br>";

      $sql = "INSERT INTO client_master(CLT_CLIENT_ID,CLT_NAME, CLT_ADDRESS1, CLT_ADDRESS2,CLT_CITY ,CLT_PIN ,CLT_STATE ,CLT_PHONE1 ,CLT_PHONE2 ,CLT_CONTACT_PERSON ,CLT_CP_MOB_NUM ,CLT_CP_MAIL ,CLT_COMPANY_STATUS ,CLT_PAN,CLT_GST_REG,CLT_VAT_REG,CLT_STX_REG,CREATED_Date) VALUES ('$ID','$Name','$Address1','$Address2','$City','$Pincode','$State','$Mobile','$Telephone','$CLT_CONTACT_PERSON' ,'$CLT_MOB_NUM' ,'$CLT_CP_MAIL' ,$CLT_COMPANY_STATUS,'$PAN','$GST','$VAT','$STX','$Today')";

      $sql1 = "UPDATE settings set Client_Master='$ID' where Client_Master='$OLD_ID'";

      if ((mysqli_query($conn, $sql) && (mysqli_query($conn, $sql1)))) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Client" ?> <font color="green"><?php echo $ID ?></font> <?php echo "Created successfully"; ?>
        </div><br><br><br>

    <div class="mdl-cell mdl-cell--12-col" align="center" style="overflow-x:auto;">
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
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
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Address1; ?></td>
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
    <div align="center">
      <a href="viewClientDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a> 
    </div>
    <?php } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);;     
    }     
    }
  } }
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>

  </div>
  </body>
  </html>