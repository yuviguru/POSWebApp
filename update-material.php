<?php session_start(); ?>
<!doctype html>
<html lang="en">
<?php include 'header.php'; ?>  
<body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php'; 
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?> 

<?php

     $vendorid=$_POST['vendorid'];
      $matcode=$_POST['matcode'];
      $units=$_POST['units'];
      $VatCst=$_POST['VatCst'];
      $narat=$_POST['narat'];
      $quote=$_POST['quote'];
      // $Name=$_GET[''];
      $genrl=$_POST['genrl'];
      $length=$_POST['length'];
      $width=$_POST['width'];
      $thick=$_POST['thick'];
      $rateUnit=$_POST['rateUnit'];


 $MAT_PKID=$_POST['MAT_PKID'];
$Today=date("Y-m-d H:i:s");


    include 'db-conn.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} 
    include 'check_page_access.php';
 if(isset($_POST['submit'])) {
$sql="UPDATE material_master set VEN_PKID='$vendorid',MAT_CD_ID='$matcode',MAT_UNITS='$units',MAT_VAT_CST='$VatCst',MAT_NART='$narat',MAT_QUOTE_REF='$quote',MAT_GEN='$genrl',MAT_HT='$length',MAT_WD='$width',MAT_THICK='$thick',MAT_RATE_UNIT='$rateUnit',UPDATED_DATE='$Today' where MAT_PKID='$MAT_PKID'"; 

 $sql1 = "UPDATE material_master set MAT_APPROVAL='PENDING' where MAT_PKID='$MAT_PKID'";

 if (mysqli_query($conn, $sql)) { ?>
  
<br><br><br><br><br><br>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Material" ?> <font color="green"><?php echo $matcode ?></font><?php echo " Details Updated successfully"; ?><br>
        </div><br><br>

<br><br>
  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Vendor Id</th>
          <th class="mdl-data-table__cell--numeric">Material Code</th>
          <th class="mdl-data-table__cell--numeric">Material Units</th>
          <th class="mdl-data-table__cell--numeric">Narrations</th>
          <th class="mdl-data-table__cell--numeric">Quote Ref</th>
          <th class="mdl-data-table__cell--numeric">General</th>
          <th class="mdl-data-table__cell--numeric">Length</th>
          <th class="mdl-data-table__cell--numeric">Width</th>
          <th class="mdl-data-table__cell--numeric">Thickness</th>
          <th class="mdl-data-table__cell--numeric">Rate Unit</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $vendorid; ?></td> 
          <td class="mdl-data-table__cell--non-numeric"><?php echo $matcode; ?></td> 
          <td class="mdl-data-table__cell--non-numeric"><?php echo $units; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $narat; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $quote; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $genrl; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $length; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $width; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $thick; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $rateUnit; ?></td>
        </tr>
      </tbody>
    </table>
    <br><br><br>
  <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
  <div align="center">
    <a href="viewMaterialDetails.php">
      <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:20%">View All Details</button>
    </a>
  </div>
      <?php } else {

          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      if (mysqli_query($conn, $sql1)) {
     } else {
          echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
      }
  }
?> 
<?php } } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
</div>
  </body>
  </html>

