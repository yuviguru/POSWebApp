<?php session_start();
   include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include 'check_page_access.php';
      $sql_brand_details = $conn->query("SELECT a.*,b.BRN_CITY FROM brand_master a,branch_master b where a.BRD_CON_BRANCH=b.BRN_PKID");
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
      <div class="mdl-grid" style="margin-right:110px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 300px;" align="center">
          Brand Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top: 0px;">
          <a href="brand-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

    <div class="mdl-layout__content" style="margin-left:110px;margin-right:110px;">
      <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
        <thead>
          <tr>
           <?php if($_SESSION['APPROVE']=='Yes') { ?>  
              <th class="mdl-data-table__cell--numeric">Approve/Reject</th>
            <?php } ?>
            <?php if($_SESSION['EDIT']=='Yes') { ?>  
              <th class="mdl-data-table__cell--numeric">Edit</th>
            <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <th class="mdl-data-table__cell--numeric">Delete</th>
            <?php } ?>
            <th class="mdl-data-table__cell--numeric">Brand ID</th>
            <th class="mdl-data-table__cell--numeric">Name</th>
            <th class="mdl-data-table__cell--numeric">Client</th>
            <th class="mdl-data-table__cell--numeric">Controlling Branch</th>
            <th class="mdl-data-table__cell--numeric">Contact Person</th>
            <th class="mdl-data-table__cell--numeric">Address 1</th>
          </tr>
        </thead>
        <tbody>
          <?php if($sql_brand_details->num_rows > 0) {
            while ($sql_brand_detail = $sql_brand_details->fetch_assoc()) {

            if($sql_brand_detail["BRD_DELETE_FLAG"]=='NO'){

               $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                      <tr>
                          <th>Address 2 </th>
                          <th>City</th>
                          <th>State</th>
                          <th>Pincode</th>
                          <th>Mobile Number</th>
                          <th>Mail</th>
                      </tr>
                       <tr>
                        <td>'.$sql_brand_detail["BRD_ADDRESS2"].'</td>
                        <td>'.$sql_brand_detail["BRD_CITY"].'</td>
                        <td>'.$sql_brand_detail["BRD_STATE"].'</td>
                        <td>'.$sql_brand_detail["BRD_PIN"].'</td>
                        <td>'.$sql_brand_detail["BRD_MOBILE_NO"].'</td>
                        <td>'.$sql_brand_detail["BRD_EMAIL_ID"].'</td>
                      </tr>
                      </table>';
          ?>
          <tr data-child-value="<?php echo $value;?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
           <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_brand_detail["BRD_APPROVAL"]=='PENDING') { ?>
                <a href="approvalBrand.php?BRD_ID=<?php echo $sql_brand_detail["BRD_ID"] ?>&BRD_APPROVAL=<?php echo $sql_brand_detail["BRD_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                </a>
                <a href="approvalBrand.php?BRD_ID=<?php echo $sql_brand_detail["BRD_ID"] ?>&BRD_APPROVAL=<?php echo $sql_brand_detail["BRD_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                    <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                </a>
              <?php } else if($sql_brand_detail["BRD_APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_brand_detail["BRD_APPROVAL"]=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
              ?>
            </td>
            <?php } ?>
            <?php if($_SESSION['EDIT']=='Yes') { ?>  
              <td class="mdl-data-table__cell--non-numeric">
                <?php if($sql_brand_detail["BRD_APPROVAL"]!='EDITING') {?> 
                <a href="editBrandDetails.php?brandID=<?php echo $sql_brand_detail["BRD_ID"]; ?>&Approval_Status=<?php echo $sql_brand_detail["BRD_APPROVAL"]; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
                <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
              </td>
            <?php } ?>
            <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if(($sql_brand_detail["BRD_DELETE_FLAG"]=='NO') && (($sql_brand_detail["BRD_APPROVAL"]=='PENDING') || ($sql_brand_detail["BRD_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteBrand.php?brandID=<?php echo $sql_brand_detail["BRD_ID"]?>&Delete_Flag=<?php echo $sql_brand_detail["BRD_DELETE_FLAG"]?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
                <?php } else { ?>
                  <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
                <?php } ?>
              </td>
            <?php } ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_brand_detail["BRD_ID"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_brand_detail["BRD_NAME"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php
              $Client_id= $sql_brand_detail["BRD_CLIENT_ID"];
              $sql_client_name = $conn->query("SELECT CLT_NAME FROM client_master WHERE  CLT_CLIENT_ID='$Client_id'"); 
              echo $sql_client_name->fetch_assoc()['CLT_NAME']; ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_brand_detail["BRN_CITY"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_brand_detail["BRD_CT_PERSON"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_brand_detail["BRD_ADDRESS1"]?>
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
      window.location.href='viewBrandDetails.php';
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
