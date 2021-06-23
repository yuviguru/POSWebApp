<?php session_start();
 include 'db-conn.php';
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  include 'check_page_access.php';
  // Check connection
  if ($conn->connect_error) {
      echo '<div align="center"><h3 style="color:red;font-size:20px;">DATABASE CONNECTION ERROR: Check & Try Again</h3><br><a href="CampaignManagement.php"><button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:10%">Refresh</button></a></div><br>';
  }
  else{
            $sql_campaign_master="SELECT * FROM activity_master where ACT_DESC LIKE 'branding' LIMIT 1";
            $sql_campaign = $conn->query($sql_campaign_master);
            $Act_id = $sql_campaign->fetch_assoc()['ACT_PKID'];

            $sql_campaign_master="SELECT * FROM campaign_master_final where CAMP_APPROVAL='YES' && CAMP_ACTIVITY='$Act_id'";
            $sql_campaign = $conn->query($sql_campaign_master);

            $sql_camp_cl_code = "SELECT CLT_CLIENT_ID,CLT_NAME FROM client_master where CLT_APPROVAL='YES'";
            $sql_cl_code = $conn->query($sql_camp_cl_code);

            $sql_brand_stat = "SELECT BRD_ID,BRD_NAME FROM brand_master where BRD_APPROVAL='YES'";
            $sql_brand = $conn->query($sql_brand_stat);

            $sql_state_details = "SELECT DISTINCT State_ID,State_Name FROM state_city order by State_Name";
            $sql_state = $conn->query($sql_state_details);

            $sql_city_details = "SELECT DISTINCT City_Name FROM state_city";
            $sql_city = $conn->query($sql_city_details);

    $conn->close();
?>
    <!doctype html>
    <html lang="en">
    <?php include 'header.php'; ?>
        <style type="text/css">
            .mdl-data-table td {
                padding: 0px 75px;
            }
            table{table-layout: fixed; width: 100%}
            table td{white-space: normal;}
            .dataTables_length{
              float:left;
            }
            .dataTables_info{
              float: left;
            }
        </style>

        <body>
            <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header" style="height:auto">
                <?php include 'navigation.php'; ?><br><br><br><br>
                    <main>
                        <div class="mdl-grid" style="">
                            <div class="mdl-cell mdl-cell--10-col" style="color:#A6192E;font-size: 30px;padding-left: 250px" align="center">
                                Campaign Management
                            </div>
                        </div>
                    </main>
                    <main class="mdl-layout__content">
                        <div class="mdl-grid">
                            <div class="mdl-shadow--4dp mdl-cell mdl-cell--12-col" align="center" style="padding-bottom:30px">
                                <div class="mdl-grid" style="background-color:#ffffff; padding-bottom:0px;">
                                <div class="mdl-cell mdl-cell--12-col" align="right">
                                    <p align="right"><font color="red"><b>NOTE :</b></font> The Fields with <span class="mandatory"> * </span>indicates Mandatory</p>
                                </div>
                            </div>
                            <form action="camp_manage_db.php" autocomplete="off" class="margin" method="GET">
                                <div class="mdl-grid">
                                            <div class="mdl-cell mdl-cell--4-col">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                    <label class="mdl-textfield__label" for="clientId">Client</label>
                                                    <select class="browser-default mdl-textfield__input" name="clientId" id="clientId">
                                                        <option value="" disabled selected></option>
                                                          <?php if($sql_cl_code->num_rows > 0) {
                                                      while ($sql_client = $sql_cl_code->fetch_assoc()) {
                                                        echo '<option value='.$sql_client["CLT_CLIENT_ID"].'>'.$sql_client["CLT_CLIENT_ID"].' '." - ".' '.$sql_client["CLT_NAME"].'</option><br>';
                                                      }
                                                    } 
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mdl-cell mdl-cell--4-col">
                                                <span id="newbrand"></span>
                                            </div>
                                             <div class="mdl-cell mdl-cell--4-col " style="margin-bottom:0px;">
                                        <span id="newcamp"></span>
                                    </div>
                                </div>
                                    <div class="mdl-cell mdl-cell--8-col target-store" id="camp-stores" align="center" style="display:none">
                                    </div>                                        
                                        <div class="mdl-cell mdl-cell--5-col" align="center"></div>
                                         <div class="mdl-cell mdl-cell--3-col" align="center">
                                          <button id="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent campman-enable" disabled id="submit" type="submit" name="submit" style="width:100%">Submit</button>
                                          </div>
                                </form>
                            </div>
                        </div>
                    </main>
            </div>
        <?php } ?>
          <script type="text/javascript">
           $("#State").on("change", function() {
                        $.ajax({url: "getCity.php?State="+document.getElementById("State").value, success: function(result){
                        $("#city_names").show();
                        $("#city_names").html(result);
                      }});
                    });
                 /* Get Management Details*/                   
                 $(document).ready(function(){
                    /* Client Id And Brand Id Fetch*/
                      $("#clientId").change(function(){
                        $.ajax({url: "getCampMangIds.php?CLT_CLIENT_ID="+document.getElementById("clientId").value, success: function(result){
                        $("#newbrand").html(result);
                        $("#campid").prop("disabled",true);
                        $("#newcamp").hide();
                         $("#camp-stores").hide();
                        $('.campman-enable').prop('disabled',true);
                        }});
                    });
                });
            </script>

</body>
</html>