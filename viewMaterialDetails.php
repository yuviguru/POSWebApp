<?php session_start();

 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_material_master="SELECT * FROM material_master;";
    $sql_material = $conn->query($sql_material_master);

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
      <div class="mdl-grid" style="margin-right:40px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;" align="center">
          Material Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top: 0px;">
          <a href="material-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>
<div style="margin-right: 190px;
    margin-left: 120px;">
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
          <th class="mdl-data-table__cell--non-numeric">Vendor Id</th>
          <th class="mdl-data-table__cell--non-numeric">Material Code</th>
          <th class="mdl-data-table__cell--non-numeric">Units In</th>
          <th class="mdl-data-table__cell--non-numeric">Narrations</th>
          <th class="mdl-data-table__cell--non-numeric">VAT/CST</th>
          <th class="mdl-data-table__cell--non-numeric">Quote Ref</th>
          <th class="mdl-data-table__cell--non-numeric">General</th>
          
         
        </tr>
      </thead>
      <tbody>
      <?php if($sql_material->num_rows > 0) {
          while ($sql_material_details = $sql_material->fetch_assoc()) {
            
              $delete_flag=$sql_material_details["DELETE_FLAG"]; 

            if($delete_flag=='NO') {
                $value = '<strong><span class=text_style>More Details</span></strong><br><table align=center>
                            <tr>
                                <th>Length</th>
                                <th>Width</th>
                                <th>Thickness</th>
                                <th>Rate/Unit</th>                                
                            </tr>
                             <tr>
                              <td>'.$sql_material_details["MAT_HT"].'</td>
                              <td>'.$sql_material_details["MAT_WD"].'</td>
                              <td>'.$sql_material_details["MAT_THICK"].'</td>
                              <td>'.$sql_material_details["MAT_RATE_UNIT"].'</td>
                            </tr>
                            </table>';
        ?>
        <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_material_details["MAT_APPROVAL"]=='PENDING') { ?>
                  <a href="approvalMaterial.php?MAT_PKID=<?php echo $sql_material_details["MAT_PKID"] ?>&MAT_APPROVAL=<?php echo $sql_material_details["MAT_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                  </a>
                  <a href="approvalMaterial.php?MAT_PKID=<?php echo $sql_material_details["MAT_PKID"] ?>&MAT_APPROVAL=<?php echo $sql_material_details["MAT_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                    <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                  </a>
              <?php } else if($sql_material_details["MAT_APPROVAL"] =='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_material_details["MAT_APPROVAL"] =='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
            </td>
          <?php } ?>

          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_material_details["MAT_APPROVAL"]!='EDITING') { ?>
                <a href="editMaterialDetails.php?MAT_PKID=<?php echo $sql_material_details["MAT_PKID"] ?>&Approval_Status=<?php echo $sql_material_details["MAT_APPROVAL"]; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
              <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if(($delete_flag=='NO') && (($sql_material_details["MAT_APPROVAL"]=='PENDING') || ($sql_material_details["MAT_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();"  href="deleteMaterial.php?MAT_PKID=<?php echo $sql_material_details["MAT_PKID"] ?>&DELETE_FLAG=<?php echo $delete_flag ?>">
                  <span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
          
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["VEN_PKID"])!=null) 
                echo $sql_material_details["VEN_PKID"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_CD_ID"])!=null) 
                echo $sql_material_details["MAT_CD_ID"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_UNITS"])!=null) 
                echo $sql_material_details["MAT_UNITS"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_NART"])!=null) 
                echo $sql_material_details["MAT_NART"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_VAT_CST"])!=null) 
                echo $sql_material_details["MAT_VAT_CST"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_QUOTE_REF"])!=null) 
                echo $sql_material_details["MAT_QUOTE_REF"]; 
              else
                echo "--";
            ?>
          </td>
          <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_material_details["MAT_GEN"])!=null) 
                echo $sql_material_details["MAT_GEN"]; 
              else
                echo "--";
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
  } 
  ?>
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
      window.location.href='viewMaterialDetails.php';
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