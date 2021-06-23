<?php session_start();
   include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include 'check_page_access.php';
    $sql_branch_details = $conn->query("SELECT * FROM branch_master");
    ?>
<!doctype html>
<html lang="en">
  <?php include 'header.php'; ?>
  <body>
    <!-- <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto"> -->
  <div class="mdl-layout mdl-js-layout">
  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <br><br><br><br>

    <main class="mdl-layout__content" style="flex: 1 0 auto;">
    <div class="mdl-grid" style="margin-right:20px;">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px;" align="center">
        Branch Details
      </div>
      <?php if( $_SESSION['CREATE']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="branch-master.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
        </a>
      </div>
      <?php } ?>
    </div>


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
            <th class="mdl-data-table__cell--numeric">Branch ID</th>
            <th class="mdl-data-table__cell--numeric">Head</th>
            <th class="mdl-data-table__cell--numeric">Efffective Date</th>
            <th class="mdl-data-table__cell--numeric">Mail</th>
            <th class="mdl-data-table__cell--numeric">Contact Person</th>
           
            </tr>
          </thead>
           <tbody>

            <?php if($sql_branch_details->num_rows > 0) {
                while ($sql_branch_detail = $sql_branch_details->fetch_assoc()) {
                  $BRN_APPROVAL=$sql_branch_detail["BRN_APPROVAL"];
                    if($sql_branch_detail["BRN_DELETE_FLAG"]=='NO') {
                      $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                                <tr>
                                   <th>Address 1 </th>
                                    <th>Address 2 </th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Phone Number</th>
                                    
                                </tr>
                                 <tr>
                                  <td>'.$sql_branch_detail["BRN_ADD1"].'</td>
                                  <td>'.$sql_branch_detail["BRN_ADD2"].'</td>
                                  <td>'.$sql_branch_detail["BRN_CITY"].'</td>
                                  <td>'.$sql_branch_detail["BRN_STATE"].'</td>
                                  <td>'.$sql_branch_detail["BRN_PINCODE"].'</td>
                                  <td>'.$sql_branch_detail["BRN_TELE_NO"].'</td>
                                 
                                </tr>
                                </table>';
          ?>
          <tr data-child-value="<?php echo $value;?>" >
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if($sql_branch_detail["BRN_APPROVAL"]=='PENDING') { ?>
                  <a href="approvalBranch.php?BRN_ID=<?php echo $sql_branch_detail["BRN_PKID"] ?>&BRN_APPROVAL=<?php echo $sql_branch_detail["BRN_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                  </a>
                  <a href="approvalBranch.php?BRN_ID=<?php echo $sql_branch_detail["BRN_PKID"] ?>&BRN_APPROVAL=<?php echo $sql_branch_detail["BRN_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                    <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                  </a>
              <?php } else if($BRN_APPROVAL=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($BRN_APPROVAL=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
              ?>
            </td>
          <?php } ?>

            <?php if($_SESSION['EDIT']=='Yes') { ?>
              <td class="mdl-data-table__cell--non-numeric">
              <?php
                if($sql_branch_detail["BRN_APPROVAL"] != 'EDITING') { ?>
                <a href="editBranchDetails.php?branchID=<?php echo $sql_branch_detail["BRN_PKID"]; ?>&Approval_Status=<?php echo $sql_branch_detail["BRN_APPROVAL"]; ?>">
                <span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
              <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } ?>
              </td>

            <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if(($sql_branch_detail["BRN_DELETE_FLAG"]=='NO') && (($sql_branch_detail["BRN_APPROVAL"]=='PENDING') || ($sql_branch_detail["BRN_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteBranch.php?BRN_PKID=<?php echo $sql_branch_detail["BRN_PKID"] ?>&Delete_Flag=<?php echo $sql_branch_detail["BRN_DELETE_FLAG"] ?>&Approval_Status=<?php echo $sql_branch_detail["BRN_APPROVAL"]; ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
                <?php } else { ?>
                  <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
                  <?php } ?>
              </td>
            <?php } ?>

            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_branch_detail["BRN_PKID"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php  $EMP_ID = $sql_branch_detail["BRN_HEAD"];
                     $sql_emp_details = "SELECT EMP_NAME FROM employee_master WHERE EMP_ID='$EMP_ID'";
                      $sql_emp = $conn->query($sql_emp_details);
                      echo  $sql_emp->fetch_assoc()['EMP_NAME'];
              ?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_branch_detail["BRN_EF_DATE"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_branch_detail["BRN_EMAIL"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
             <?php echo $sql_branch_detail["BRN_CONTACT_PERSON"]?>             
            </td>
            </tr>
    
<?php
              }
            }
          }
          ?>
              </tbody>
    </table>

 </main>
     <?php include 'footer.php'; ?> 
</div>
    <!--</div>-->
  <?php } else {
   echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
  } 
  ?>
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
      window.location.href='viewBranchDetails.php';
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