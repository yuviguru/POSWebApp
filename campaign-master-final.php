<?php session_start();
 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_settings="SELECT Campaign_Master as Campaign_Master FROM settings";
    $sql_sett = $conn->query($sql_settings);

    $sql_branch_stat = "SELECT BRN_PKID,BRN_CITY FROM branch_master where BRN_APPROVAL='YES'";
    $sql_branch = $conn->query($sql_branch_stat);

    $sql_emp_id_stat = "SELECT EMP_ID,EMP_NAME FROM employee_master where EMP_APPROVAL='YES'";
    $sql_emp_id = $conn->query($sql_emp_id_stat);

    $sql_cl_code_stat = "SELECT CLT_CLIENT_ID,CLT_NAME FROM client_master where CLT_APPROVAL='YES'";
    $sql_cl_code = $conn->query($sql_cl_code_stat);

    $sql_brand_stat = "SELECT BRD_ID,BRD_NAME FROM brand_master where BRD_APPROVAL='YES'";
    $sql_brand = $conn->query($sql_brand_stat);

    $sql_activity_stat = "SELECT ACT_PKID,ACT_DESC FROM activity_master where ACT_APPROVAL='YES'";
    $sql_act = $conn->query($sql_activity_stat);

    $sql_store_stat = "SELECT * FROM store_master where STR_APPROVAL='YES'";
    $sql_store = $conn->query($sql_store_stat);

    $sql_store_count = "SELECT DISTINCT count(*) as count FROM store_master where STR_APPROVAL='YES'";
    $sql_st_count = $conn->query($sql_store_count);
    
    $conn->close();

?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
    #CAMPbrCodeErr,#CAMPeIDErr,#CAMPclCodeErr,#CAMbrIDErr,#CAMPactErr,#CAMP_CC_DateErr,#CAMP_EmailErr,#CAMP_CPErr,#CAMP_MobErr,#CAMP_EmailCPErr,#CAMP_VATErr,#CAMP_BudErr,#CAMP_CNameErr,#CAMP_BRNameErr,#CAMP_QAErr,#CAMP_AStartDate_Err,#CAMP_EmailPersErr,#CAMP_PO_NumErr,#CAMP_PO_DateErr,#CAMP_PO_App_ByErr,#CAMP_STRIDErr,#CAMP_CC_DateErr1,#CAMP_AEndDate_Err,#CAMP_PO_DateErrGreater,#CAMPactErrEmptyStore {
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
  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){?>
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Campaign Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewCampaignDetails-Final.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main> 
  
  <main class="mdl-layout__content">
    <div class="mdl-grid">
      
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" >
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>
          <form action="campmas-db-final.php" style="padding: 15px;padding-top:0px" name="form" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--3-col" align="center">
              <?php if($sql_sett->num_rows > 0){
                while ($sql_sett_ID = $sql_sett->fetch_assoc()) {
              ?>
                <input type="hidden" id="ID" name="ID" maxlength="50" value="<?php echo $sql_sett_ID["Campaign_Master"]?>">
                <input type="hidden" id="OLD_ID" name="OLD_ID" value="<?php echo $sql_sett_ID["Campaign_Master"]?>">
                <input type="hidden" id="store_Count" name="store_Count" value="<?php echo $sql_st_count->fetch_assoc()["count"]?>">
                <div id="cntrl_branch" style="display: none;"></div>
              <?php     
                }
              }
              ?>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="sample3">Emp.Branch Code <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="CAMP_BRCode" name="CAMP_BRCode">
                    <option value="" disabled selected></option>
                    <?php if($sql_branch->num_rows > 0){
                      while ($sql_bran = $sql_branch->fetch_assoc()) {
                        echo '<option value='.$sql_bran["BRN_PKID"].'>'.$sql_bran["BRN_CITY"].'('.$sql_bran["BRN_PKID"].')'.'</option><br>';
                      }
                    }
                    ?>
                  </select>
                  <span id="CAMPbrCodeErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: 25px;">
                  <label class="mdl-textfield__label" for="sample3">Emp.ID <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="CAMP_E_ID" name="CAMP_E_ID">
                    <option value="" disabled selected></option>
                    <?php if($sql_emp_id->num_rows > 0){
                      while ($sql_emp = $sql_emp_id->fetch_assoc()) {
                        echo '<option value='.$sql_emp["EMP_ID"].'>'.$sql_emp["EMP_ID"].' '. " - " .''.$sql_emp["EMP_NAME"].'</option><br>';
                      }
                    }
                    ?>
                  </select>
                  <span id="CAMPeIDErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: 20px;">
                  <label class="mdl-textfield__label" for="sample3">Client <span class="mandatory">*</span></label>
                  <input type="hidden" name="CAMP_CL_Code" Value="No" onkeypress="validateAlphanumeric();">
                  <select class="browser-default mdl-textfield__input" id="CAMP_CL_Code" name="CAMP_CL_Code">
                    <option value="" disabled selected></option>
                    <?php if($sql_cl_code->num_rows > 0) {
                      while ($sql_client = $sql_cl_code->fetch_assoc()) {
                        echo '<option value='.$sql_client["CLT_CLIENT_ID"].'>'.$sql_client["CLT_CLIENT_ID"].' '." - ".' '.$sql_client["CLT_NAME"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span id="CAMPclCodeErr"></span>
                </div>                
              </div>

              <div class="mdl-cell mdl-cell--3-col" align="center" >
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="sample3">Brand ID <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="CAMP_BR_ID" name="CAMP_BR_ID">
                    <option value="" disabled selected></option>
                    <?php if($sql_brand->num_rows > 0) {
                      while ($sql_brd = $sql_brand->fetch_assoc()) {
                        echo '<option value='.$sql_brd["BRD_ID"].'>'.$sql_brd["BRD_ID"].''.' - '.$sql_brd["BRD_NAME"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span id="CAMbrIDErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: 25px;">
                  <label class="mdl-textfield__label" for="sample3">Activity <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="CAMP_Activity" name="CAMP_Activity">
                    <option value="" disabled selected></option>
                    <?php if($sql_act->num_rows > 0) {
                      while ($sql_act_code = $sql_act->fetch_assoc()) {
                        echo '<option value='.$sql_act_code["ACT_PKID"].''."-".''.$sql_act_code["ACT_DESC"].'>'.$sql_act_code["ACT_PKID"].''.' - '.$sql_act_code["ACT_DESC"].'</option><br>';
                      }
                    }
                    $conn->close();
                    ?>
                  </select>
                  <span id="CAMPactErrEmptyStore" style="display: none">No Store is Avialable!Please Select Different Activity</span>
                  <span id="CAMPactErr"></span>
                </div>
                <?php $Today=date("d-m-Y"); ?>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label style="margin-left: -100px;color: rgb(33, 150, 243);font-size: 18px;">Campaign Creation Date <span class="mandatory">*</span></label>
                  <input class="mdl-textfield__input" type="text" id="CAMP_CDate" name="CAMP_CDate" min="2000-01-01" max="3000-01-01" onkeypress="validateNumber_and_Hyphen();" value="<?php echo $Today ?>" style="color:black;" disabled>
                  <span class="mdl-textfield__error">Enter Valid Date</span>
                  <span id="CAMP_CC_DateErr"></span>
                  <span id="CAMP_CC_DateErr1" style="display: none;">Future Date is not a Valid Date</span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--3-col" align="center">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="CAMP_PO_Num" name="CAMP_PO_Num" maxlength="20" min="2000-01-01" max="3000-01-01"  onkeypress="validateAlphanumeric();">
                  <label class="mdl-textfield__label" for="CAMP_PO_Num">PO No. <span class="mandatory">*</span></label>
                  <span id="CAMP_PO_NumErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label style="margin-left: -230px;" id="PODate_label">PO Date <span class="mandatory">*</span></label>
                  <input class="mdl-textfield__input" type="date" id="CAMP_PO_Date" name="CAMP_PO_Date" onkeypress="validateNumber_and_Hyphen();">
                  <span id="CAMP_PO_DateErr" style="display: none;">You Must Select PO Date</span>
                  <span id="CAMP_PO_DateErrGreater" style="display: none;">PO Date Can't be a Future Date</span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label style="margin-left: -160px;" id="SDate_label">Activity Start Date <span class="mandatory">*</span></label>
                  <input class="mdl-textfield__input" type="date" id="CAMP_ACT_SDate" name="CAMP_ACT_SDate" min="2000-01-01" max="3000-01-01" onkeypress="validateNumber_and_Hyphen();">
                  <span id="CAMP_AStartDate_Err"></span>
                </div>
              </div>
              
              <div class="mdl-cell mdl-cell--3-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: -27px;" id="EdateView">
                  <label style="margin-left: -180px;" id="EDate_label">Activity End Date </label>
                  <input class="mdl-textfield__input" type="date" id="CAMP_ACT_EDate" name="CAMP_ACT_EDate" min="2000-01-01" max="3000-01-01" onkeypress="validateNumber_and_Hyphen();" disabled>
                  <span id="mdl-CAMP_AEndDate_Err" style="display: none;">Enter Valid Date</span>
                  <span id="CAMP_AEndDate_Err" style="display: none;">Activity End Date should be greater than Start Date</span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: 10px;">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="CAMP_Remarks" name="CAMP_Remarks" maxlength="50" onkeypress="validateAlphanumeric();"></textarea>
                  <label class="mdl-textfield__label" for="CAMP_Remarks">Remarks</label>
                </div>
              </div>

              <div class="mdl-cell mdl-cell--2-col" align="center"></div>
              <div class="mdl-cell mdl-cell--8-col" align="center" id="hide_store" style="display: none;">
                <div align="center"> 
                  <label>STORES <span class="mandatory">*</span></label>
                </div> 
                <table id="myTable" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                  <thead>
                    <tr style="background: #ccc;">
                      <th>Select Store</th>
                      <th class="mdl-data-table__cell--numeric">Store ID</th>
                      <th class="mdl-data-table__cell--numeric">Store Name</th>
                      <th class="mdl-data-table__cell--numeric">City</th>
                      <th class="mdl-data-table__cell--numeric">State</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if($sql_store->num_rows > 0) {
                      while ($sql_store_details = $sql_store->fetch_assoc()) {
                    ?>
                    <tr>
                      <td class="mdl-data-table__cell--numeric">
                        <label class="mdl-checkbox mdl-js-checkbox">
                          <input type="checkbox" name="Store_Ids[]" class="mdl-checkbox__input" value="<?php echo $sql_store_details["STR_PKID"]?>">
                        </label>
                      </td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <?php echo $sql_store_details["STR_PKID"]?>
                      </td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <?php echo $sql_store_details["STR_NAME"]?>
                      </td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <?php echo $sql_store_details["STR_CITY"]?>
                      </td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <?php echo $sql_store_details["STR_STATE"]?>
                      </td>
                    </tr>
                    <?php
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
                <div class="mdl-cell mdl-cell--3-col" align="center"></div>
                <div class="mdl-cell mdl-cell--3-col" align="center">
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%" onclick="return(checkCAMP_BRCode() && checkCAMP_EMP_ID() && checkCAMP_CLCode() && checkCAMP_BRID() && checkCAMP_ACT() && checkCAMP_PO_Num() && checkCAMP_PO_Date() && checkCAMP_ACT_SDate() && checkCAMP_StoreIDs() && checkCAMP_ACT_EDate() && get_details());">Submit</button>
                </div>
                <div class="mdl-cell mdl-cell--3-col" align="center">
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%" type="reset">Clear</button>
                </div>              
                <div class="mdl-cell mdl-cell--3-col" align="center"></div>
              </div>
            </div>
          </form>
        </div>
      
      </div>
  </main>
  <?php include "footer.php";
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>

<script src="js/validation.js" type="text/javascript"></script> 
<script type="text/javascript"> 
    
    function get_details()
    
    {
      var full_serial='';
      var ID=($('#ID').val());

      var activity=($('#CAMP_Activity').val()).substr(0,4);

      var brID=($('#CAMP_BR_ID').val());

      var empID=($('#CAMP_E_ID').val());

      var date = new Date();
      var year = date.getFullYear();

      var next_year = date.getFullYear()+1;

      var stringyear=next_year.toString();

      var nxt_year_2digit = stringyear.substr(stringyear.length - 2);

      var serial=ID.substr(ID.length - 3);

      var serial_plus=++serial;

        if(serial_plus.toString().length <= 1){
            full_serial="00"+serial_plus;
        }
        else if (serial_plus.toString().length>1 && serial_plus.toString().length<= 2){
            full_serial="0"+serial_plus;
        }
        else if (serial_plus.toString().length>2 && serial_plus.toString().length<= 3){
            full_serial=serial_plus;
        }

      var final_ID=activity+"/"+brID+"/"+empID+"/"+year+"-"+nxt_year_2digit+"/"+full_serial;

      $('#ID').val(final_ID).change();

    //  alert("Your Campaign ID is : " +final_ID);

    }
</script>
<script type="text/javascript">
  $("#CAMP_PO_Date").on("change", function() {
      $("#PODate_label").css('color','rgb(33, 150, 243)');
      $("#PODate_label").css('font-size','18px');
      $("#PODate_label").css('margin-left','-220px');
    });

   $("#CAMP_BRCode").on("change", function() {
          $.ajax({url: "getCB.php?CB="+document.getElementById("CAMP_BRCode").value, success: function(result){
              $("#cntrl_branch").show();
              $("#cntrl_branch").html(result);
          }});
      });
  
  $("#CAMP_ACT_SDate").on("change", function() {
            var start_date = $("#CAMP_ACT_SDate").val();
            if(start_date != '')
            {
              $("#CAMP_ACT_EDate").prop("disabled",false);
              $("#CAMP_ACT_EDate").parent().removeClass('is-disabled');
              $("#CAMP_ACT_EDate").prop("min",start_date);
            }
            else
            {
              $("#CAMP_ACT_EDate").prop("disabled",true);
            }
      });
</script>
</body>
</html>
