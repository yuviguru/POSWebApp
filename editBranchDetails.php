<?php session_start();
  $Branch_ID=$_GET['branchID'];
  $Approval_Status=$_GET['Approval_Status'];
  $BRN_APPROVAL='';

  include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

  $sql_appr="SELECT BRN_APPROVAL FROM branch_master where BRN_PKID='$Branch_ID'";
  $sql_app = $conn->query($sql_appr);

  if($sql_app->num_rows > 0) 
  {
    while ($sql_act_details = $sql_app->fetch_assoc()) {
      $BRN_APPROVAL=$sql_act_details["BRN_APPROVAL"];
    }
  }

  if($BRN_APPROVAL!='EDITING') { 

   include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql1 = "UPDATE branch_master set BRN_APPROVAL='EDITING' where BRN_PKID='$Branch_ID'";

    if (mysqli_query($conn, $sql1)) 
    {
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
      $sql_branch_details = $conn->query("SELECT * FROM branch_master WHERE BRN_PKID='$Branch_ID'");
      $sql_branch_detail = $sql_branch_details->fetch_assoc();
      $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
      $sql_state = $conn->query($sql_state_details);
      $sql_emp_details = "SELECT DISTINCT EMP_ID,EMP_NAME FROM employee_master";
      $sql_emp = $conn->query($sql_emp_details);
      
    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }

    
    ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
 
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID']) && $_SESSION['EDIT']=='Yes') {  ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Branch Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewBranchDetails.php#">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main>  
  
  <main class="mdl-layout__content">
      <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
            <div class="mdl-cell mdl-cell--12-col" align="right">
              <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
            </div>
        </div>
          <form class="margin" id="branch-form" action="update-branchmas-db.php" style="padding: 15px;padding-top:0px;" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">
                  <input class="mdl-textfield__input req" type="hidden" id="update-branch-id" name="update-branch-id" value="<?php echo $Branch_ID; ?>">
                  <input type="hidden" id="Approval_Status" name="Approval_Status" maxlength="50" value="<?php echo $BRN_APPROVAL?>">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <select class="browser-default mdl-textfield__input req" name="branch-head" id="branch-head">
                  <? if(($sql_branch_detail['BRN_HEAD'] == '') || ($sql_branch_detail['BRN_HEAD'] == NULL) ) ?>
                      <option disabled selected></option>
                  <?php if($sql_emp->num_rows > 0){
                      while ($sql_emp_name = $sql_emp->fetch_assoc()) {
                        echo '<option '.(($sql_emp_name["EMP_ID"]==$sql_branch_detail['BRN_HEAD']) ? "selected" : "").' value="'.$sql_emp_name["EMP_ID"].'">'.$sql_emp_name["EMP_NAME"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <label class="mdl-textfield__label" for="branch-head">Branch Head</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" align="left">
                  <label for="branch-effdate" style="color: rgb(33, 150, 243);font-size: 18px;">Effective Date</label>
                  <input class="mdl-textfield__input req datefield-color" type="date" min="1989-01-01" max="<?php echo date("Y-m-d"); ?>" id="branch-effdate" name="branch-effdate"  value="<?php echo $sql_branch_detail["BRN_EF_DATE"] ?>">
                  <span class="mdl-textfield__error">Enter Valid Date(dd-mm-yyyy)</span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" maxlength="45" id="branch-mail" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" name="branch-mail" maxlength="50" value="<?php echo $sql_branch_detail['BRN_EMAIL'] ?>">
                  <label class="mdl-textfield__label" for="branch-mail">Email(Official)<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Email(eg. Myname@domain.com)</span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" maxlength="100" id="branch-add1" name="branch-add1"><?php echo $sql_branch_detail['BRN_ADD1'] ?></textarea>
                  <label class="mdl-textfield__label" for="branch-add1">Branch Address 1<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input req" type="text" rows= "2" maxlength="50" id="branch-add2" name="branch-add2"><?php echo $sql_branch_detail['BRN_ADD2'] ?></textarea>
                  <label class="mdl-textfield__label" for="branch-add2">Branch Address 2</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input req" type="text" id="branch-phn-num" pattern="^\(?([0-9]{3,5})\)?([-][0-9]{6,8})$" name="branch-phn-num" maxlength="12" value="<?php echo $sql_branch_detail['BRN_TELE_NO'] ?>">
                  <label class="mdl-textfield__label" for="sample3">Telephone Number</label>
                  <span class="mdl-textfield__error">Enter Valid Telephone Number</span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
               <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="branch-state">State <span class="mandatory-field">*</span></label>
                  <?php if($BRN_APPROVAL=='YES') { ?>
                    <input class="mdl-textfield__input" readonly type="text" name="branch-state" id="branch-state" readonly value="<?php echo $sql_branch_detail['BRN_STATE'] ?>">
                  <?php } else { ?>
                  <select class="browser-default mdl-textfield__input" name="branch-state" id="branch-state">
                    <?php if($sql_state->num_rows > 0){
                      while ($sql_st_name = $sql_state->fetch_assoc()) {
                        echo '<option '.(($sql_st_name["State_Name"]==$sql_branch_detail['BRN_STATE']) ? "selected" : "").' value="'.$sql_st_name["State_Name"].'">'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <?php } ?>
                  <span id="emptyfield-error"></span>
                </div>
                <div id="city_names2">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="mdl-textfield__label" for="City2">Select City <span class="mandatory-field">*</span></label>
                  <?php if($BRN_APPROVAL=='YES') { ?>
                    <input class="mdl-textfield__input" readonly type="text" name="City2" id="City2" readonly value="<?php echo $sql_branch_detail['BRN_CITY'] ?>">
                  <?php } else { ?>
                    <select class="browser-default mdl-textfield__input" name="City2" id="City2">
                      <option value="<?php echo $sql_branch_detail["BRN_CITY"] ?>" selected><?php echo $sql_branch_detail["BRN_CITY"] ?></option>
                      <?php 
                      $bran_state_id = $sql_branch_detail['BRN_STATE']; 
                      $sql_city_details = "SELECT DISTINCT City_Name FROM state_city WHERE State_Name='$bran_state_id'";
                      $sql_city = $conn->query($sql_city_details);
                      if($sql_city->num_rows > 0) {
                        while ($sql_cty_name = $sql_city->fetch_assoc()) {
                          if ($sql_branch_detail["BRN_CITY"] != $sql_cty_name["City_Name"]) {
                            echo '<option value='.$sql_cty_name["City_Name"].'>'.$sql_cty_name["City_Name"].'</option><br>';
                          }
                        }
                      } 
                      $conn->close();
                      ?>
                    </select>
                    <?php } ?>
                    <span id="emptyfield-error"></span>
                  </div>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^([0-9]{6})+$" maxlength="6" id="branch-pincode" name="branch-pincode" value="<?php echo $sql_branch_detail['BRN_PINCODE'] ?>"//> 
                  <label class="mdl-textfield__label" for="branch-pincode">Pin Code<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Pincode</span>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="branch-CP" name="branch-CP" maxlength="50" value="<?php echo $sql_branch_detail['BRN_CONTACT_PERSON'] ?>" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="branch-CP">Contact Person<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error"></span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-cell--6-offset" style="width:100%">Update</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  </main>
<?php } else {
  echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
} ?>
</div>
<script type="text/javascript">
       $("#branch-form").on("submit", function() {
  var check = true;
    var anyFieldIsEmpty5 = $("#branch-form input").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty6 = $("#branch-form select").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    var anyFieldIsEmpty7 = $("#branch-form textarea").not('.req').each(function() {
           fieldname = $(this).siblings('.mdl-textfield__label').text();
           fieldlen = $.trim(this.value).length;
           if(fieldlen <= 0){
           $(this).siblings('.emptyfield-error').text(fieldname+' cannot be Empty');
            check = false;
           
         }
        });

    if(check == false){
      return false;
    }
});  
 $("#branch-form .mdl-textfield__input").on("change paste keyup", function() {
  if($(this).val().trim() != '') 
    $(this).siblings('.emptyfield-error').hide();
   else
    $(this).siblings('.emptyfield-error').show();
  });
     </script>
 <script type="text/javascript" src="js/validation.js"></script>
    <script type="text/javascript">

      $("#branch-state").on("change", function() {
          $.ajax({url: "getCity2.php?State="+document.getElementById("branch-state").value, success: function(result){
              $("#city_names2").html(result);
          }});
      });

</script>
<script type="text/javascript">

    $( window ).on('unload',function() {
    var BRN_PKID=$("#update-branch-id").val();
    var Approval_Status=$("#Approval_Status").val();
    var Table_Name="branch_master";
    var Col_Name="BRN_PKID";
    var Col_Name2="BRN_APPROVAL";

      $.ajax({
      type: 'GET',
      async: false,
      url: 'Approval_Status.php',
      data: 'PKID=' + BRN_PKID + '&Table_Name=' + Table_Name + '&Col_Name=' + Col_Name + '&Col_Name2=' + Col_Name2 + '&Approval_Status=' + Approval_Status,
      });
   });
</script>
  </body>
</html>
<?php } else {
  echo"<script>alert('Another Admin Editing this Branch');
  window.top.location.href='viewBranchDetails.php'</script>";
} ?>