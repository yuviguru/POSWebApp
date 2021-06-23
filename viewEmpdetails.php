<?php session_start();
    include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
		include 'check_page_access.php';
      $sql_emp_details = $conn->query("SELECT a.*,b.BRN_CITY FROM employee_master a,branch_master b where a.EMP_CON_BRANCH=b.BRN_PKID");
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
      <div class="mdl-grid" style="margin-right:20px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px;" align="center">
          Employee Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
          <a href="employee-master.php">
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
            </a>
        </div>
        <?php } ?>
      </div>
   
      <!-- <div style="margin-left: 125px;margin-right: 125px;">-->
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
              <th class="mdl-data-table__cell--numeric">Employee ID</th>
              <th class="mdl-data-table__cell--numeric">Employee Name</th>
              <th class="mdl-data-table__cell--numeric">Department</th>
              <th class="mdl-data-table__cell--numeric">Designation</th>
              <th class="mdl-data-table__cell--numeric">Location</th>
              <th class="mdl-data-table__cell--numeric">Qualification</th>
              <th class="mdl-data-table__cell--numeric">Date of Joining</th>
              
            </tr>
          </thead>
          <tbody >
            <?php if($sql_emp_details->num_rows > 0) {
              while ($sql_emp_detail = $sql_emp_details->fetch_assoc()) {
                $EMP_ID_url=$sql_emp_detail["EMP_ID"];
                if(($sql_emp_detail["EMP_DELETE_FLAG"]=='NO') && ($EMP_ID_url!='00000')) {
                  $value = '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                                <th>Address 1</th>
                                <th>Address 2</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Pincode</th>
                                <th>EMail(offical) </th>
                                <th>EMail(Personal)</th>
                                <th>Mobile(offical)</th>
                                <th>Mobile(Personal)</th>
                            </tr>
                             <tr>
                              <td>'.$sql_emp_detail["EMP_ADD1"].'</td>
                              <td>'.$sql_emp_detail["EMP_ADD2"].'</td>
                              <td>'.$sql_emp_detail["CITY"].'</td>
                              <td>'.$sql_emp_detail["STATE"].'</td>
                              <td>'.$sql_emp_detail["PINCODE"].'</td>
                              <td>'.$sql_emp_detail["E_MAIL_OFFICIAL"].'</td>
                              <td>'.$sql_emp_detail["E_MAIL_PERSONAL"].'</td>
                              <td>'.$sql_emp_detail["MOBILE_OFFICIAL"].'</td>
                              <td>'.$sql_emp_detail["MOBILE_PERSONAL"].'</td>
                            </tr>
                            </table>';
          ?>
          <tr data-child-value="<?php echo $value;?>">
            <?php if($_SESSION['APPROVE']=='Yes') { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if($sql_emp_detail["EMP_APPROVAL"]=='PENDING') { ?>
                    <a href="approvalEmp.php?EMP_ID=<?php echo $sql_emp_detail["EMP_ID"] ?>&EMP_APPROVAL=<?php echo $sql_emp_detail["EMP_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                      <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                    </a>
                    <a href="approvalEmp.php?EMP_ID=<?php echo $sql_emp_detail["EMP_ID"] ?>&EMP_APPROVAL=<?php echo $sql_emp_detail["EMP_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                      <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                    </a>
                <?php } else if($sql_emp_detail["EMP_APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_emp_detail["EMP_APPROVAL"]=='YES') {
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
                if(($_SESSION['EDIT']=='Yes') && ($sql_emp_detail["EMP_APPROVAL"] !='EDITING')) { ?>
                  <a href="editEmpDetails.php?empID=<?php echo $EMP_ID_url ?>&Approval_Status=<?php echo $sql_emp_detail["EMP_APPROVAL"]?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
                  <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } ?>
              </td>
            <?php } ?>

            <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
              <td class="mdl-data-table__cell--non-numeric">
                <?php if(($sql_emp_detail["EMP_DELETE_FLAG"]=='NO') && (($sql_emp_detail["EMP_APPROVAL"]=='PENDING') || ($sql_emp_detail["EMP_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteemp.php?empID=<?php echo $EMP_ID_url ?>&Delete_Flag=<?php echo $sql_emp_detail["EMP_DELETE_FLAG"]?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
                <?php } else { ?>
                  <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
              </td>
            <?php } ?>
            
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["EMP_ID"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["EMP_NAME"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["EMP_DEPARTMENT"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["EMP_DESIGNATION"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["BRN_CITY"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
              <?php echo $sql_emp_detail["EMP_QULIFICATION"]?>
            </td>
            <td class="mdl-data-table__cell--non-numeric">
            <?php 
                if(($sql_emp_detail["EMP_DOJ"])!=null) {
                  $date = new DateTime($sql_emp_detail["EMP_DOJ"]);
                  $result = $date->format('d-m-Y');
                  echo $result; 
                }
                else
                  echo "---------";
              ?>
            </td>
         
          <?php
                }
              }
            }
          ?>
        </tbody>
      </table>
   
  
       </main>
    <?php include 'footer.php';?>

    <?php  } else {
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
      window.location.href='viewEmpDetails.php';
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