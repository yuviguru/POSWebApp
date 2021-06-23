<?php session_start();
include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
	
    include 'check_page_access.php';
    $sql_elements_master="SELECT * FROM element_master;";
    $sql_elements = $conn->query($sql_elements_master);

  $conn->close();
                         
?>

<!doctype html>
<html lang="en">
  <?php include 'header.php'; ?>
  <style type="text/css">
    #myTable_wrapper{
      width: 100%;
    }
  </style> 
  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">

  <?php include 'navigation.php';
  if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes')) { ?>   
    <br><br><br><br>
    <main>
      <div class="mdl-grid" style="margin-right:45px;">
        <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 320px;" align="center">
          Elements Details
        </div>
        <?php if( $_SESSION['CREATE']=='Yes') { ?>
        <div class="mdl-cell mdl-cell--2-col">
          <a href="elements-master.php">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Create New</button>
          </a>
        </div>
        <?php } ?>
      </div>
    </main>

 <div style="margin-right: 230px;
    margin-left: 230px;">
   <table id="myTable" class="mdl-data-table" cellspacing="0" width="100%">
      <thead>  
        <tr >
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <th class="mdl-data-table__cell--non-numeric">Approve/Reject</th>
          <?php } ?>
          <?php if($_SESSION['EDIT']=='Yes') { ?>  
            <th class="mdl-data-table__cell--non-numeric">Edit</th>
          <?php } if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <th class="mdl-data-table__cell--non-numeric">Delete</th>
          <?php } ?>
          <th class="mdl-data-table__cell--non-numeric">Elements</th>
         
        </tr>
      </thead>
      <tbody>
      <?php if($sql_elements->num_rows > 0) {
          while ($sql_elements_details = $sql_elements->fetch_assoc()) {
            $value="";
            $prev_act="";
            $ELE_PKID=$sql_elements_details["ELE_PKID"];
            $delete_flag=$sql_elements_details["ELE_DELETE_FLAG"]; 
            if($delete_flag=='NO') {
              $sql_elements_class = $conn->query("SELECT b.ACT_PKID,c.ACT_NAME,d.CAT_NAME FROM salvos.element_classfication a,activity_category_elements b JOIN activity_master c ON c.ACT_PKID = b.ACT_PKID JOIN categories d on d.CAT_ID= b.CAT_ID where a.ACT_CAT_ID=b.ACT_CAT_ID AND a.ELE_PKID = '$ELE_PKID' AND a.DELETE_FLAG='NO' order by c.ACT_NAME");
            if($sql_elements_class->num_rows > 0) {
              
              $value .= '<strong><span class=text_style>More Details</span></strong><br><table  style=white-space:normal; class=display responsive nowrap cellspacing=0 width=100%>
                            <tr>
                                <th>Activity</th>
                                <th>Categories</th>
                            </tr>';
              while ($sql_ele_class = $sql_elements_class->fetch_assoc()) {
                $curr_act = $sql_ele_class['ACT_PKID'];
                if($curr_act != $prev_act){
                  if($prev_act != "") $value .='</td>';
                $value.=' <tr>
                            <td>'.$sql_ele_class['ACT_PKID'].'-'.$sql_ele_class['ACT_NAME'].'</td><td>';
                }
                $value.= $sql_ele_class['CAT_NAME'].',';
                $prev_act = $curr_act;
              }
            }
            else
            { $value = 'No Information Found';}
        ?>
        <tr data-child-value="<?php echo $value; ?>">
          <?php if($_SESSION['APPROVE']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if($sql_elements_details["ELE_APPROVAL"]=='PENDING') { ?>
                <a href="approvalElements.php?ELE_PKID=<?php echo $sql_elements_details["ELE_PKID"] ?>&ELE_APPROVAL=<?php echo $sql_elements_details["ELE_APPROVAL"] ?>&APPROVAL=<?php echo "APPROVE" ?>">
                  <span class="fa fa-check fa-2x" style="background:#006400;color:#fff;"></span>
                </a>
                <a href="approvalElements.php?ELE_PKID=<?php echo $sql_elements_details["ELE_PKID"] ?>&ELE_APPROVAL=<?php echo $sql_elements_details["ELE_APPROVAL"] ?>&APPROVAL=<?php echo "REJECT" ?>">
                  <span class="fa fa-times fa-2x" style="color:#fff;background: #a6192e;margin-left: 10px;font-weight:bolder;"></span>
                </a>
            <?php } else if($sql_elements_details["ELE_APPROVAL"]=='EDITING') { ?>
                  <span class="fa fa-lock fa-2x" style="color: #000;"></span>
              <?php } else if($sql_elements_details["ELE_APPROVAL"]=='YES') {
                echo "Approved";
              } else { 
                echo "Rejected";
              }
            ?>
            </td>
          <?php } ?>

          <?php if($_SESSION['EDIT']=='Yes') { ?>
            <td class="mdl-data-table__cell--non-numeric">
            <?php if($sql_elements_details["ELE_APPROVAL"] !='EDITING') { ?>
              <a href="editElementDetails.php?ele_id=<?php echo $sql_elements_details["ELE_PKID"]; ?>&Approval_Status=<?php echo $sql_elements_details["ELE_APPROVAL"]; ?>&Approval_Status=<?php echo $sql_elements_details["ELE_APPROVAL"]; ?>"><span class="fa fa-pencil-square-o fa-2x" style="color: #033158;font-weight:bold;"></span></a>     
            <?php } else { ?>
                <span class="fa fa-lock fa-2x" style="color: #000;"></span>
             <?php } ?>
            </td>
          <?php } ?>

          <?php if((isset($_SESSION['USERID'])) && ($_SESSION['VIEW']=='Yes') && ($_SESSION['EDIT']=='Yes') && ($_SESSION['APPROVE']=='Yes') && ($_SESSION['CREATE']=='Yes')) { ?>
            <td class="mdl-data-table__cell--non-numeric">
              <?php if(($delete_flag=='NO') && (($sql_elements_details["ELE_APPROVAL"]=='PENDING') || ($sql_elements_details["ELE_APPROVAL"]=='NO'))) { ?>
                  <a class="click-off" onclick="clickOffConfirmed();" href="deleteElement.php?ELE_PKID=<?php echo $ELE_PKID ?>&ELE_DELETE_FLAG=<?php echo $delete_flag ?>"><span class="fa fa-trash fa-2x" style="color: #a6192e;"></span></a>
              <?php } else { ?>
                <span class="fa fa-trash fa-2x" style="color: transparent;text-shadow: 0 0 2px rgba(0,0,0,0.5);"></span>
              <?php } ?>
            </td>
          <?php } ?>
           <td class="mdl-data-table__cell--non-numeric">
            <?php 
              if(($sql_elements_details["ELEMENTS"])!=null) 
                echo $sql_elements_details["ELEMENTS"]; 
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
      window.location.href='viewElementsDetails.php';
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