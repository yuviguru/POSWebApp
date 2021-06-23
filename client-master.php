<?php session_start();
  $Client_Master='';
include 'db-conn.php';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
    include 'check_page_access.php';
    $sql_settings="SELECT Client_Master as Client_Master FROM settings";
    $sql_sett = $conn->query($sql_settings);

    $sql_branch_stat = "SELECT BRN_PKID,BRN_CITY FROM branch_master";
    $sql_branch = $conn->query($sql_branch_stat);

    $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
    $sql_state = $conn->query($sql_state_details);

    $sql_city_details = "SELECT DISTINCT City_Name FROM state_city";
    $sql_city = $conn->query($sql_city_details);

  if($sql_sett->num_rows > 0){
    while ($sql_set_details = $sql_sett->fetch_assoc()) {
      $Client_Master=$sql_set_details["Client_Master"];
    }
  } 
  $conn->close();
                         
?>

<!doctype html>
<html lang="en">

  <?php include 'header.php'; ?>  
  <style type="text/css">
    #nameErr,#add1Err,#cityErr,#cityErr,#pinErr,#stateErr,#mobErr,#branchErr,#gstErr,#CPnameerr,#CPmoberr{
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
        Client Master
      </div>
      <?php if( $_SESSION['VIEW']=='Yes') { ?>
      <div class="mdl-cell mdl-cell--2-col" style="margin-top:0px;">
        <a href="viewClientDetails.php">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%">View All</button>
        </a>
      </div>
      <?php } ?>
    </div>
  </main>

  <main class="mdl-layout__content" style="top:-10px;">
   
    <div class="mdl-grid" style="margin-top:-40px;">
        <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="">
        <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
          <div class="mdl-cell mdl-cell--12-col" align="right">
            <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
          </div>
        </div>

          <form action="clmas-db.php" method="GET" style="padding: 15px;margin-top: -65px;" autocomplete="off">
            <div class="mdl-grid">
              <div class="mdl-cell mdl-cell--4-col" align="center">

                  <input type="hidden" id="ID" name="ID" maxlength="50" value="<?php echo $Client_Master?>">
                  <input type="hidden" id="OLD_ID" name="OLD_ID" value="<?php echo $Client_Master?>">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="Name" name="Name" maxlength="50" >
                  <label class="mdl-textfield__label" for="Name">Client Name <span class="mandatory">*</span></label>
                  <span id="nameErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="Address1" name="Address1" maxlength="100"></textarea>
                  <label class="mdl-textfield__label" for="Address1">Address 1 <span class="mandatory">*</span></label>
                  <span id="add1Err"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows= "2" id="Address2" name="Address2" maxlength="50"></textarea>
                  <label class="mdl-textfield__label" for="Address2">Address 2</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="    margin-top: -15px;">
                  <input class="mdl-textfield__input" type="text" id="Pincode" name="Pincode" pattern="^([0-9]{6})+$" maxlength="6" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="Pincode">Pin Code <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Pincode</span>
                  <span id="pinErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <label class="mdl-textfield__label" for="State">State <span class="mandatory">*</span></label>
                  <select class="browser-default mdl-textfield__input" name="State" id="State">
                    <option value="" disabled selected></option>
                    <?php if($sql_state->num_rows > 0){
                      while ($sql_st_name = $sql_state->fetch_assoc()) {
                        echo '<option value="'.$sql_st_name["State_Name"].'">'.$sql_st_name["State_Name"].'</option><br>';
                      }
                    } 
                    ?>
                  </select>
                  <span id="stateErr"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
                <div id="city_names" style="display: none;"></div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="Mobile" name="Mobile" pattern="^([0-9]{10})+$" maxlength="10" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="Mobile">Mobile <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Mobile Number</span>
                  <span id="mobErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="Telephone" name="Telephone" pattern="^\(?([0-9]{3,5})\)?([-][0-9]{6,8})$" onkeypress="validateNumber_and_Hyphen();">
                  <label class="mdl-textfield__label" for="Telephone">Telephone Number</label>
                  <span class="mdl-textfield__error">Enter Valid Telephone Number (Ex : 044-12345678)</span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="CPname" name="CPname" maxlength="50" onkeypress="validateAlphabet();">
                  <label class="mdl-textfield__label" for="CPname">Contact Person <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Name</span>
                  <span id="CPnameerr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="CPmob" name="CPmob" pattern="^([0-9]{10})+$" maxlength="10" onkeypress="validateNumber();">
                  <label class="mdl-textfield__label" for="CPmob">Mobile Number(Contact Person)  <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Mobile Number</span>
                  <span id="CPmoberr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="CPmail" name="CPmail" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" maxlength="50">
                  <label class="mdl-textfield__label" for="CPmail">E-Mail(Contact Person) <span class="mandatory">*</span></label>
                  <span class="mdl-textfield__error">Enter Valid Email(eg. Myname@domain.com)</span>
                  <span id="CPmailerr"></span>
                </div>
              </div>
              <div class="mdl-cell mdl-cell--4-col" align="center">
               <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-top: 20px;">
                  <label class="mdl-textfield__label" for="company-status">Company Status</label>
                  <select class="browser-default mdl-textfield__input" id="companystatus" name="companystatus">
                    <option value="" disabled selected></option>
                    <option value="Asscociation of Persons">Asscociation of Persons</option>
                    <option value="Body of Individuals-Proprietorship">Body of Individuals-Proprietorship</option>
                    <option value="Company Resident-Limited">Company Resident-Limited</option>
                    <option value="Company Resident-PVT Ltd">Company Resident-PVT Ltd</option>
                    <option value="Co-operative Society/Trust">Co-operative Society/Trust</option>
                    <option value="Individual HUF Resident">Individual HUF Resident</option>
                    <option value="Limited Liablity Partnership(LLP)">Limited Liablity Partnership(LLP)</option>
                    <option value="Partnership Firm">Partnership Firm</option>
                  </select>
                  <span class="emptyfield-error"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="PAN" name="PAN" maxlength="15" onkeypress="validateAlphanumeric();Space();">
                  <label class="mdl-textfield__label" for="PAN">PAN Number</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="GST" name="GST" maxlength="15" onkeypress="validateAlphanumeric();Space();">
                  <label class="mdl-textfield__label" for="GST">GST Regn. Number</label>
                  <span id="gstErr"></span>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="CLT_VAT" name="VAT" maxlength="15" onkeypress="validateAlphanumeric();Space();">
                  <label class="mdl-textfield__label" for="VAT">VAT Regn. Number</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="STX" name="STX" maxlength="15" onkeypress="validateAlphanumeric();Space();">
                  <label class="mdl-textfield__label" for="STX">STX Regn. Number</label>
                </div>
              </div>
              <div class="mdl-grid" align="center" style="width:100%">
                <div class="mdl-cell mdl-cell--3-col" align="center"></div>
                 <div class="mdl-cell mdl-cell--3-col" align="center">
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent " style="width:100%" type="submit" onclick="return(checkName() && checkAddress1() && checkPincode() && checkState() && checkCity() && checkMobile() && checkCP() && checkCPmob() && final_ID());">Submit</button>
                </div>
                <div class="mdl-cell mdl-cell--3-col" align="center">
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%" type="reset">Clear</button>
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

<script src="js/validation.js" type="text/javascript"></script>

<script type="text/javascript">

      $("#State").on("change", function() {
          $.ajax({url: "getCity.php?State="+document.getElementById("State").value, success: function(result){
              $("#city_names").show();
              $("#city_names").html(result);
          }});
      });

</script>

<script type="text/javascript"> 
    
    function final_ID()
    
    {
      var full_serial='';
      var ID=($('#ID').val().trim());

      var city=($('#City').val().trim());
      var city_first3=city.substr(0,3);
      var name=($('#Name').val().trim());
      var first_alph=name.charAt(0);
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
      var final_ID=city_first3.toUpperCase()+first_alph.toUpperCase()+full_serial;
      $('#ID').val(final_ID).change();
      //alert("Your Client ID is : " +final_ID);
    }
</script>
</body>
</html>
