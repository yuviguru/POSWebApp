<?php session_start();
   include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_activity_master="SELECT * FROM activity_master";
    $sql_act = $conn->query($sql_activity_master);

  $conn->close();
                         
?>

<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
    #nameErr,#add1Err,#cityErr,#cityErr,#pinErr,#stateErr,#mobErr{
      color: #d50000;
      position: absolute;
      font-size: 12px;
      margin-top: 3px;
      visibility: visible;
      display: block;}
    .mandatory{color: red;font-size: 17px;}
  </style>
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">

  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?> 
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:15px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 250px" align="center">
          Activity Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
          <a href="activity-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Create New</button>
        </a>
        </div>
        <?php } ?>
      </div>
    </main>

  <div  style="margin-left:15px;margin-right:15px;">
     <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
      <thead>  
        <tr style="background: #ccc;">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>  
            <th class="mdl-data-table__cell--numeric">Approve/Reject</th>
          <?php } ?>
          <?php if($_SESSION['EDIT']=='Yes') { ?>  
            <th class="mdl-data-table__cell--numeric">Edit</th>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
          <th class="mdl-data-table__cell--numeric">Delete</th>
          <?php } ?>
          <th class="mdl-data-table__cell--numeric">Activity Code</th>
            <th class="mdl-data-table__cell--numeric">Name</th>
            <th class="mdl-data-table__cell--numeric">Dependencies</th>
        </tr>
      </thead>
      <tbody>
      <?php if($sql_act->num_rows > 0) {
          while ($sql_activity_details = $sql_act->fetch_assoc()) {
            $ACT_PKID=$sql_activity_details["ACT_PKID"];
            $ACT_APPROVAL=$sql_activity_details["ACT_APPROVAL"];
            $delete_flag=$sql_activity_details["ACT_DELETE_FLAG"];

          if($delete_flag=='NO') {
            if(($sql_activity_details["ACT_CATEGORY"])!=null) {
                 $prefix = $catnames ='';
                 $ACT_CAT = explode(',',$sql_activity_details["ACT_CATEGORY"]);
                foreach($ACT_CAT as $CAT){
                  $sql_cat = $conn->query("SELECT * FROM categories WHERE CAT_ID='$CAT'");
                  $cat_det = $sql_cat->fetch_assoc();
                  $catnames .= $prefix.$cat_det['CAT_NAME'];
                  $prefix = ', ';
                }
                 $value = '<strong><span class=text_style>More Details</span></strong><br><table align=center>
                            <tr>
                                <th>Categories</th>                               
                            </tr>
                             <tr>
                              <td>'.$catnames.'</td>
                            </tr>
                            </table>';
              }
              else
                echo "---------";
              
        ?>
        <tr data-child-value="<?php echo $value;?>">
        <?php if($_SESSION['APPROVE']=='Yes') { ?>
          <td class="mdl-data-table__cell--numeric">
            <?php if($ACT_APPROVAL=='PENDING')  { ?>
                  <a href="approvalActivity.php?ACT_PKID=<?php echo $ACT_PKID ?>&ACT_APPROVAL=<?php echo $ACT_APPROVAL ?>&APPROVAL=<?php echo "APPROVE" ?>">
                    <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                  </a>
                  <a href="approvalActivity.php?ACT_PKID=<?php echo $ACT_PKID ?>&ACT_APPROVAL=<?php echo $ACT_APPROVAL ?>&APPROVAL=<?php echo "REJECT" ?>">
                    <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                  </a>
              <?php } else if($ACT_APPROVAL=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($ACT_APPROVAL=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
          </td> 
        <?php } ?>

          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--numeric">
            <?php
              if($ACT_APPROVAL!='EDITING') { ?>
                <a href="editActivityDetails.php?ACT_PKID=<?php echo $ACT_PKID ?>&Approval_Status=<?php echo $ACT_APPROVAL; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>
              <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--numeric">
              <?php if((($ACT_APPROVAL=='PENDING') || ($ACT_APPROVAL=='NO')) && ($delete_flag=='NO')) { ?>
                <a class="click-off" onclick="clickOffConfirmed();" href="deleteActivity.php?ACT_PKID=<?php echo $ACT_PKID ?>&Delete_Flag=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
          <td class="mdl-data-table__cell--numeric">
            <?php 
              if(($sql_activity_details["ACT_PKID"])!=null) 
                echo $sql_activity_details["ACT_PKID"]; 
              else
                echo "---------";
            ?>
          </td>
          <td class="mdl-data-table__cell--right-numeric">
            <?php 
              if(($sql_activity_details["ACT_NAME"])!=null) 
                echo $sql_activity_details["ACT_NAME"]; 
              else
                echo "---------";
            ?>
          </td>
          <td class="mdl-data-table__cell--right">
            <?php 
              if(($sql_activity_details["ACT_DEPEND"])!=null) 
                echo $sql_activity_details["ACT_DEPEND"]  ; 
              else
                echo "---------";
            ?>
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
              } 
              else {
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
      window.location.href='viewActivityDetails.php';
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