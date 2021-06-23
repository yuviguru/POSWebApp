<?php session_start();
include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
    include 'check_page_access.php';
    $sql_mat_code_master="SELECT * FROM material_code_master";
    $sql_mat = $conn->query($sql_mat_code_master);

  $conn->close();
                         
?>

<!doctype html>
<html lang="en">
  <?php include 'header.php'; ?>  
 
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">

  <?php include 'navigation.php'; 
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?>  
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:155px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 350px;" align="center">
          Material Code Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
          <a href="material-code-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>
   <div style="margin-right: 20px;
    margin-left: 20px;">
 
    <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
      <thead>  
        <tr style="background: #ccc;">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <th class="mdl-data-table__cell--non-numeric">Approve/Reject</th>
          <?php } ?>
          <?php if($_SESSION['EDIT']=='Yes') { ?>  
            <th class="mdl-data-table__cell--non-numeric">Edit</th>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
                <th class="mdl-data-table__cell--non-numeric">Delete</th>
          <?php } ?>
          <th class="mdl-data-table__cell--non-numeric">Material Name</th>
          <th class="mdl-data-table__cell--non-numeric">Material Category</th>
          <th class="mdl-data-table__cell--non-numeric">Material Specs</th>
        </tr>
      </thead>
      <tbody>
      <?php if($sql_mat->num_rows > 0) {
          while ($sql_mat_code_details = $sql_mat->fetch_assoc()) {
            $MAT_COD_ID=$sql_mat_code_details["MAT_COD_ID"];
            $delete_flag=$sql_mat_code_details["DELETE_FLAG"]; 
            $value="";
            $prev_act="";
            $mat_cats ="";
            if($delete_flag=='NO') {
              $sql_mat_class = $conn->query("SELECT a.*,b.MAT_COD_NAME,c.CAT_NAME FROM material_classfication a join categories c on a.CAT_ID=c.CAT_ID,material_code_master b  Where a.MAT_COD_ID='$MAT_COD_ID' and a.DELETE_FLAG='NO' and a.MAT_COD_ID=b.MAT_COD_ID;");
              if($sql_mat_class->num_rows > 0) {
              while ($sql_class = $sql_mat_class->fetch_assoc()) {
                if($mat_cats !="")
                  $mat_cats .= ','.$sql_class['CAT_NAME'];
                else
                  $mat_cats .= $sql_class['CAT_NAME'];
              }
            }
            else
            { 
              $mat_cats  = '----------';
              $mat_specs = '----------';
            }
              $value='No information found....';
        ?>
        <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_mat_code_details["MAT_COD_APPROVAL"]=='PENDING') { ?>
                  <a href="approvalMaterialCode.php?MAT_COD_ID=<?php echo $sql_mat_code_details["MAT_COD_ID"] ?>&MAT_COD_APPROVAL=<?php echo $sql_mat_code_details["MAT_COD_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                  </a>
                  <a href="approvalMaterialCode.php?MAT_COD_ID=<?php echo $sql_mat_code_details["MAT_COD_ID"]; ?>&MAT_COD_APPROVAL=<?php echo $sql_mat_code_details["MAT_COD_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT"; ?>">
                    <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                  </a>
              <?php } else if($sql_mat_code_details["MAT_COD_APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_mat_code_details["MAT_COD_APPROVAL"]=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
              ?>
            </td>
          <?php } ?>
          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if($sql_mat_code_details["MAT_COD_APPROVAL"]!='EDITING') { ?>
              <a href="editMaterialCodeDetails.php?matID=<?php echo $sql_mat_code_details["MAT_COD_ID"] ?>&Approval_Status=<?php echo $sql_mat_code_details["MAT_COD_APPROVAL"]; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
            <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if(($delete_flag=='NO') && (($sql_mat_code_details["MAT_COD_APPROVAL"]=='PENDING') || ($sql_mat_code_details["MAT_COD_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteMaterialCode.php?MAT_COD_ID=<?php echo $MAT_COD_ID ?>&DELETE_FLAG=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
           
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_mat_code_details["MAT_COD_NAME"])!=null) 
                echo $sql_mat_code_details["MAT_COD_NAME"]; 
              else
                echo "--";
            ?>
          </td>
          
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
                echo $mat_cats;
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_mat_code_details["MAT_COD_SPECS"])!=null) 
                echo $sql_mat_code_details["MAT_COD_SPECS"]; 
              else
                echo "----------";
            ?>
          </td>
        </tr>
        <?php
            }
          }
        }
        ?>
      </tbody>
    </table>
</div>

  <?php include "footer.php"; } else {
    echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } ?>
</div>
<script type="text/javascript">
  $('.click-off').click(function (e) {
    e.preventDefault();
    var linkURL = $(this).attr("href");
    // escape here if the confirm is false;
    swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
              closeOnConfirm: false,
              closeOnCancel: true
          }, function clickOffConfirmed(isConfirm) {
              if (isConfirm) {
                  swal("Deleted!", "Your file has been deleted.", "success");
                  window.location.href = linkURL;
                  // table.row($(btn).parents('tr')).remove().draw(false);
              } else {
                  swal('Cancelled','Your imaginary file is safe.','error');
              }
          });
  });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
    var url = document.location.toString();
      var url_id= url.substr(-1);
    if (url_id=='#'){
      window.location.href='viewMaterialCodeDetails.php';
      }
    });
</script>
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
</body>
</html>