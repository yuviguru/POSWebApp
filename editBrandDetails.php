<?php session_start();
    $brand_ID=$_GET['brandID'];
    $Approval_Status=$_GET['Approval_Status'];
    $BRD_APPROVAL='';

    include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';

  $sql_appr="SELECT BRD_APPROVAL FROM brand_master where BRD_ID='$brand_ID'";
  $sql_app = $conn->query($sql_appr);
  $sql_branch_stat = "SELECT BRN_PKID,BRN_CITY FROM branch_master where BRN_APPROVAL='YES'";
      $sql_branch = $conn->query($sql_branch_stat);

  $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
  $sql_state = $conn->query($sql_state_details);

  $sql_city_details = "SELECT DISTINCT City_Name FROM state_city";
  $sql_city = $conn->query($sql_city_details);
  if($sql_app->num_rows > 0) 
  {
    while ($sql_act_details = $sql_app->fetch_assoc()) {
      $BRD_APPROVAL=$sql_act_details["BRD_APPROVAL"];
    }
  }

  if($BRD_APPROVAL!='EDITING') { 

   include 'db-conn.php';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql1 = "UPDATE brand_master set BRD_APPROVAL='EDITING' where BRD_ID='$brand_ID'";

    if (mysqli_query($conn, $sql1)) 
    {
      $sql_brand_details = $conn->query("SELECT * FROM brand_master where BRD_ID='$brand_ID'");
      $sql_brand_detail = $sql_brand_details->fetch_assoc();
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
  if(isset($_SESSION['USERID']) && ($_SESSION['EDIT']=='Yes')) { ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Brand Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewBrandDetails.php#">
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
          <div class="mdl-cell mdl-cell--12-col"> <h5><span class="mandatory-field">Brand ID</span> - <?php echo $sql_brand_detail['BRD_ID']; ?></h5>
              <h5><span class="mandatory-field">Client ID</span> - <?php echo $sql_brand_detail['BRD_CLIENT_ID']; ?></h5> 
          </div>
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>
          <form class="margin" id="brand-form" action="update-brandmas-db.php" style="padding: 15px;" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <input class="mdl-textfield__input req" type="hidden" id="update-client-id" name="update-client-id" value="<?php echo $sql_brand_detail['BRD_CLIENT_ID']; ?>">
                <input class="mdl-textfield__input" type="hidden" id="update-brand-id" name="update-brand-id" value="<?php echo $sql_brand_detail['BRD_ID']; ?>">
                <input class="mdl-textfield__input" type="hidden" id="Approval_Status" name="Approval_Status" value="<?php echo $Approval_Status; ?>">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="brand-name" name="brand-name" value="<?php echo $sql_brand_detail['BRD_NAME']; ?>"  maxlength="50" <?php echo (($Approval_Status=='YES') ? "readonly" : ""); ?>>
                  <label class="mdl-textfield__label" for="brand-name">Brand Name<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="brand-cb">Controlling Branch<span class="mandatory-field">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="brand-cb" name="brand-cb">
                    <option value="" disabled selected></option>
                    <?php if($sql_branch->num_rows > 0){
                    while ($sql_bra = $sql_branch->fetch_assoc()) {
                    echo '<option '.(($sql_brand_detail["BRD_CON_BRANCH"]==$sql_bra['BRN_PKID']) ? "selected" : "").' value="'.$sql_bra["BRN_PKID"].'">'.$sql_bra["BRN_PKID"].' - '.$sql_bra["BRN_CITY"].'</option><br>';
                    }
                    } 
                    
                    ?>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="cntrl_branch" style="display: none;"></div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="client-CP" name="client-CP" value="<?php echo $sql_brand_detail['BRD_CT_PERSON']; ?>"  maxlength="45">
                  <label class="mdl-textfield__label" for="client-CP">Contact Person<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
                <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="Address1" name="Address1" maxlength="100"><?php echo $sql_brand_detail['BRD_ADDRESS1']; ?></textarea>
                  <label class="mdl-textfield__label" for="Address1">Address 1 <span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input req" type="text" rows= "2" id="Address2" name="Address2" maxlength="50"><?php echo $sql_brand_detail['BRD_ADDRESS2']; ?></textarea>
                  <label class="mdl-textfield__label" for="Address2">Address 2</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -15px;">
                  <input class="mdl-textfield__input" type="text" id="Pincode" name="Pincode" pattern="^([0-9]{6})+$" maxlength="6" onkeypress="validateNumber();" value="<?php echo $sql_brand_detail['BRD_PIN']; ?>">
                  <label class="mdl-textfield__label" for="Pincode">Pin Code <span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Pincode</span>
                  <span class="emptyfield-error"></span>
                </div>
                </div>
                <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="State">State <span class="mandatory-field">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="State" id="State">
                    <option value="" disabled selected></option>
                    <?php if($sql_state->num_rows > 0){
                      while ($sql_st_name = $sql_state->fetch_assoc()) {
                        echo '<option '.(($sql_brand_detail["BRD_STATE"]==$sql_st_name['State_Name']) ? "selected" : "").' value="'.$sql_st_name["State_Name"].'">'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="city_names2">
                   <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <label class="mdl-textfield__label" for="City2">Select City <span class="mandatory-field">*</span></label>
                    <select class="browser-default mdl-textfield__input" name="City2" id="City2">
                      <option value="<?php echo $sql_brand_detail["BRD_CITY"] ?>" selected><?php echo $sql_brand_detail["BRD_CITY"] ?></option>
                      <?php
                      $state_name_id =$sql_get_detail["STATE"];
                      echo $state_name_id ;
                      $sql_city_details = "SELECT DISTINCT City_Name FROM state_city WHERE State_Name='$state_name_id'";
                      $sql_city = $conn->query($sql_city_details);
                       if($sql_city->num_rows > 0) {
                        while ($sql_cty_name = $sql_city->fetch_assoc()) {
                          if ($sql_brand_detail["BRD_CITY"] != $sql_cty_name["City_Name"]) {
                            echo '<option value='.$sql_cty_name["City_Name"].'>'.$sql_cty_name["City_Name"].'</option><br>';
                          }
                        }
                      }
                      $conn->close(); 
                      ?>
                    </select>
                    <span id="emptyfield-error"></span>
                  </div>
                 </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^([0-9]{10})+$" id="client-mob" name="client-mob" maxlength="12" value="<?php echo $sql_brand_detail['BRD_MOBILE_NO']; ?>">
                  <label class="mdl-textfield__label" for="client-mob">Mobile Number<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" id="client-mail" name="client-mail" maxlength="50" value="<?php echo $sql_brand_detail['BRD_EMAIL_ID']; ?>">
                  <label class="mdl-textfield__label" for="client-mail">E-Mail ID<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Email(eg. Myname@domain.com)</span>
                  <span class="emptyfield-error"></span>
                </div>
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
  } 
  ?>
</div>
  <script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
   $("#brand-cb").on("change", function() {
          $.ajax({url: "getCB.php?CB="+document.getElementById("brand-cb").value, success: function(result){
              $("#cntrl_branch").show();
              $("#cntrl_branch").html(result);
          }});
      });
</script>
<script type="text/javascript">

      
      $("#State").on("change", function() {
          $.ajax({url: "getCity2.php?State="+document.getElementById("State").value, success: function(result){
              $("#city_names2").show();
              $("#city_names2").html(result);
          }});
      });
</script>
<script type="text/javascript">

    $( window ).on('unload',function() {
    var BRN_PKID=$("#update-brand-id").val();
    var Approval_Status=$("#Approval_Status").val();
    var Table_Name="brand_master";
    var Col_Name="BRD_ID";
    var Col_Name2="BRD_APPROVAL";

      $.ajax({
      type: 'GET',
      async: false,
      url: 'Approval_Status.php',
      data: 'PKID=' + BRN_PKID +'&Table_Name=' + Table_Name + '&Col_Name=' + Col_Name + '&Col_Name2=' + Col_Name2 + '&Approval_Status=' + Approval_Status,
      });
   });
</script>
  </body>
</html>
<?php } else {
  echo"<script>alert('Another Admin Editing this Brand');
  window.top.location.href='viewBrandDetails.php'</script>";
} 

?>
      