<?php session_start(); ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>

  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
    <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?> 
    <?php 

    $Client_id     =$_GET['update-client-id'];
    $Brand_ID      =$_GET['update-brand-id'];
    $Brand_name    =$_GET['brand-name'];
    $Brand_CB      =$_GET['brand-cb'];
    $Client_CP     =$_GET['client-CP'];
    $Client_mob    =$_GET['client-mob'];
    $Client_mail   =$_GET['client-mail'];

    $Address1_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address1'])));
    $Address1=addslashes($Address1_View);

    $Address2_View=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Address2'])));
    $Address2=addslashes($Address2_View);

    $City=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['City2'])));
    $Pincode=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['Pincode'])));
    $State=rtrim(ltrim(preg_replace('/\s+/',' ',$_GET['State'])));
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
      echo "<br><br><br><br><br>";
    include 'check_page_access.php';
		
      $sql_client_name = $conn->query("SELECT CLT_NAME FROM client_master WHERE  CLT_CLIENT_ID='$Client_id'");
      $sql_branch_name = $conn->query("SELECT BRN_CITY FROM branch_master WHERE  BRN_PKID='$Brand_CB'");
      $sql_brand_details = "UPDATE brand_master set BRD_ID='$Brand_ID', BRD_NAME='$Brand_name',BRD_CON_BRANCH='$Brand_CB', BRD_CLIENT_ID='$Client_id', BRD_CT_PERSON='$Client_CP', BRD_ADDRESS1='$Address1', BRD_ADDRESS2='$Address2', BRD_STATE='$State', BRD_CITY='$City', BRD_PIN='$Pincode', BRD_MOBILE_NO='$Client_mob', BRD_EMAIL_ID='$Client_mail',UPDATED_DATE='$Today',BRD_APPROVAL='PENDING' where BRD_ID='$Brand_ID'";
      if (mysqli_query($conn, $sql_brand_details)) { ?>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Brand" ?> <font color="green"><?php echo $Brand_ID ?></font> <?php echo "Details Updated successfully"; ?>
        </div><br><br><br>
        <div style="overflow-x: scroll;">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
        <th class="mdl-data-table__cell--non-numeric">Brand ID</th>
          <th class="mdl-data-table__cell--non-numeric">Brand Name</th>
          <th class="mdl-data-table__cell--non-numeric">Client</th>
          <th class="mdl-data-table__cell--non-numeric">Controlling Branch</th>
          <th class="mdl-data-table__cell--non-numeric">Contact Person</th>
          <th class="mdl-data-table__cell--numeric">Address 1</th>
          <th class="mdl-data-table__cell--numeric">Address 2</th>
          <th class="mdl-data-table__cell--numeric">State</th>
          <th class="mdl-data-table__cell--numeric">City</th>
          <th class="mdl-data-table__cell--numeric">Pincode</th>
          <th class="mdl-data-table__cell--non-numeric">Mobile Number</th>
          <th class="mdl-data-table__cell--non-numeric">E-Mail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Brand_ID;     ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Brand_name;   ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_client_name->fetch_assoc()['CLT_NAME']; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $sql_branch_name->fetch_assoc()['BRN_CITY']; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_CP;    ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Address1_View;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Address2_View;?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $State;        ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $City;         ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Pincode;      ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_mob;   ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $Client_mail;  ?></td>
        </tr>
      </tbody>
    </table><br>
    </div><br>
      <?php } else {
          echo '<div align="center"><h3 style="color:red;">ERROR: Try Again</h3><br><a href="branch-master.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Create New</button></a></div><br>';
      }
    }
    ?>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewBrandDetails.php">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
      </a>
    </div>
    <?php } } else {
   echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
?>
</div>
</body>
</html>