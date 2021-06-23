<?php session_start();
    include 'db-conn.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include 'check_page_access.php';
      $sql_client_ids = $conn->query("SELECT * FROM client_master where CLT_APPROVAL='YES'");
      $sql_branch_stat = "SELECT BRN_PKID,BRN_CITY FROM branch_master where BRN_APPROVAL='YES'";
      $sql_branch = $conn->query($sql_branch_stat);

      $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
      $sql_state = $conn->query($sql_state_details);

      $sql_city_details = "SELECT DISTINCT City_Name FROM state_city";
      $sql_city = $conn->query($sql_city_details);
    ?>
<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  
  <body>
  <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header" style="height:auto">
 
  <?php include 'navigation.php';
  if(isset($_SESSION['USERID']) && $_SESSION['CREATE']=='Yes'){ ?> 
  <br><br><br><br> 
  <main>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 40px;padding-left: 150px" align="center">
        Brand Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewBrandDetails.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main>

  <main class="mdl-layout__content" style="top: -30px;">
    <div class="mdl-grid">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>
          <form class="margin" id="brand-form" action="brandmas-db.php" style="padding: 15px;" autocomplete="off">
            <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col" align="center">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="client_id">Client<span class="mandatory-field">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="client_id" name="client_id">
                    <option value="" disabled selected></option>
                    <?php if($sql_client_ids->num_rows > 0){
                    while ($sql_client_id = $sql_client_ids->fetch_assoc()) {
                    echo '<option value="'.$sql_client_id["CLT_CLIENT_ID"].'-'.$sql_client_id["CLT_NAME"].'">'.$sql_client_id["CLT_CLIENT_ID"].' - '.$sql_client_id["CLT_NAME"].'</option><br>';
                     }
                    } 
                    $conn->close();
                    ?>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="hi">
                </div>
                <input class="mdl-textfield__input" type="hidden" id="brand-id" name="brand-id" value="">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="brand-name" name="brand-name" maxlength="50">
                  <label class="mdl-textfield__label" for="brand-name">Brand Name<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="brand-cb">Controlling Branch<span class="mandatory-field">*</span></label>
                  <select class="browser-default mdl-textfield__input" id="brand-cb" name="brand-cb">
                    <option value="" disabled selected></option>
                    <?php if($sql_branch->num_rows > 0){
                    while ($sql_bra = $sql_branch->fetch_assoc()) {
                    echo '<option value="'.$sql_bra["BRN_PKID"].'">'.$sql_bra["BRN_PKID"].' - '.$sql_bra["BRN_CITY"].'</option><br>';
                    }
                    } 
                    $conn->close();
                    ?>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="cntrl_branch" style="display: none;"></div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="client-CP" name="client-CP"  maxlength="45" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="client-CP">Contact Person<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--4-col" align="center">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="Address1" name="Address1" maxlength="100"></textarea>
                  <label class="mdl-textfield__label" for="Address1">Address 1 <span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input req" type="text" rows= "2" id="Address2" name="Address2" maxlength="50"></textarea>
                  <label class="mdl-textfield__label" for="Address2">Address 2</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -15px;">
                  <input class="mdl-textfield__input" type="text" id="Pincode" name="Pincode" pattern="^([0-9]{6})+$" maxlength="6" onkeypress="validateNumber();">
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
                        echo '<option value="'.$sql_st_name["State_Name"].'">'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div id="city_names2" style="display: none;"></div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^([0-9]{10})+$" id="client-mob" name="client-mob" maxlength="12" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="client-mob">Mobile Number<span class="mandatory-field">*</span></label>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" id="client-mail" name="client-mail" maxlength="50">
                  <label class="mdl-textfield__label" for="client-mail">E-Mail ID<span class="mandatory-field">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Email(eg. Myname@domain.com)</span>
                  <span class="emptyfield-error"></span>
                </div>
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
              <div class="mdl-cell mdl-cell--3-col" align="center"></div>
               <div class="mdl-cell mdl-cell--3-col" align="center">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">Submit</button>
                </div>
                 <div class="mdl-cell mdl-cell--3-col" align="center">
                <button type="reset" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%">Clear</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  </main>
  <?php include 'footer.php';
   } 
    else {
      echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
    } 
  ?>
</div>
  <script type="text/javascript" src="js/validation.js"></script>
  <script type="text/javascript">
  $("#client_id").on("change", function(){
          $.ajax({url: "getBranchidDB.php?client_id="+document.getElementById("client_id").value, success: function(result){
            $("#hi").html(result);
            var client_id_name = $('#client_id').val();
            var n = client_id_name.indexOf('-');
              var client_id = client_id_name.substring(0, n != -1 ? n : client_id_name.length);
            var old_brand_id = $('#oldbrandID').val();
              var spilt_id = old_brand_id.substring(7,9);
               ++spilt_id;
              var run_serial_new= (spilt_id < 10 ? '0' : '')+spilt_id;
              var new_brand_id = client_id+run_serial_new;
              $("#brand-id").attr("value",new_brand_id);
          }});
      });

  
</script>
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
  $(function(){

   $( "#brand-name" ).bind( 'paste',function()
   {
       setTimeout(function()
       { 
          //get the value of the input text
          var data= $( '#brand-name' ).val() ;
          //replace the special characters to '' 
          var dataFull = data.replace(/[\,\\,\;\#\$\%\*\+\'\"]/gi, '');
          //set the new value of the input text without special characters
          $( '#brand-name' ).val(dataFull);
       });

    });
});

  $(function() {

   $( "#client-CP" ).bind( 'paste',function()
   {
       setTimeout(function()
       { 
          //get the value of the input text
          var data= $( '#client-CP' ).val() ;
          //replace the special characters to '' 
          var dataFull = data.replace(/[\,\\,\;\#\$\%\*\&\+\-\.\'\"]/gi, '');
          //set the new value of the input text without special characters
          $( '#client-CP' ).val(dataFull);
       });

    });
});
</script>
  </body>
</html>
