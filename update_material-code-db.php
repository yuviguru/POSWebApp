<?php session_start(); ?>
<!doctype html>
<html lang="en">
<?php include 'header.php'; ?>  
  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
  <?php include 'navigation.php';
    if((isset($_SESSION['USERID'])) && ($_SESSION['EDIT']=='Yes')) { ?>  

<?php
  include 'db-conn.php';
  include 'salvos_globals.php';
$mat_name    = (isset($_POST['mat_name']) ? $_POST['mat_name'] : null);
$mat_name=rtrim(ltrim(preg_replace('/\s+/',' ',$mat_name)));
$MAT_CAT = $_POST['MAT_CAT'];
$MAT_SPEC = implode(',', $_POST['MAT_SPEC']);

$ID=$_POST['ID'];

 $Today=date("Y-m-d H:i:s");


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
} 
    include 'check_page_access.php';
 if(isset($_POST['submit'])) {
$sql="UPDATE material_code_master set MAT_COD_NAME='$mat_name',MAT_COD_SPECS='$MAT_SPEC',UPDATED_DATE='$Today',MAT_COD_UPDATED_BY='$Logged_User' where MAT_COD_ID='$ID'"; 

$sql1 = "UPDATE material_code_master set MAT_COD_APPROVAL='PENDING' where MAT_COD_ID='$ID'";


 if (mysqli_query($conn, $sql)) { 
  $sql_category_reset = $conn->query("UPDATE material_classfication set DELETE_FLAG='YES',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' WHERE MAT_COD_ID='$ID'");
        foreach ($MAT_CAT as $CAT) {
          $sql_category_select = $conn->query("SELECT * FROM material_classfication WHERE MAT_COD_ID='$ID' && CAT_ID='$CAT'");

          if($sql_category_select->num_rows > 0) {
            $sql_category_update = $conn->query("UPDATE material_classfication set DELETE_FLAG='NO',UPDATED_DATE='$Today',UPDATED_BY='$Logged_User' WHERE MAT_COD_ID='$ID' && CAT_ID='$CAT'");
          }
          else
          {
            $sql_category_insert = $conn->query("INSERT INTO material_classfication(MAT_COD_ID, CAT_ID, CREATED_DATE, CREATED_BY) VALUES ('$ID','$CAT','$Today','$Logged_User')");
          }
        }
          ?>
  
<br><br><br><br><br><br>
        <div class="moz-margin" align="center" style="color: #A6192E;font-size: 20px;">
          <?php echo "Material" ?> <font color="green"><?php echo $mat_name ?></font><?php echo "Details Updated successfully"; ?><br>
        </div><br>
        <br><br>
  <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp myTable" align="center">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--numeric">Material Name</th>
          <th class="mdl-data-table__cell--numeric">Material Category</th>
          <th class="mdl-data-table__cell--numeric">Material Specs</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $mat_name;     ?></td> 
          <td class="mdl-data-table__cell--non-numeric"><?php $prefix = $catnames ='';
                                                            foreach($MAT_CAT as $CAT){
                                                              $sql_cat = $conn->query("SELECT * FROM categories WHERE CAT_ID='$CAT'");
                                                              $cat_det = $sql_cat->fetch_assoc();
                                                              $catnames .= $prefix.$cat_det['CAT_NAME'];
                                                              $prefix = ', ';
                                                            }
                                                            echo $catnames; ?></td>
          <td class="mdl-data-table__cell--non-numeric"><?php echo $MAT_SPEC;     ?></td>
        </tr>
      </tbody>
    </table>
    <br><br><br>
    <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <div align="center">
      <a href="viewMaterialCodeDetails.php">
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

