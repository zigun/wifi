<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
// check url

ob_start("ob_gzhandler");

$url = $_SERVER['REQUEST_URI'];

if(!isset($_SESSION["mikhmon"])){
  header("Location:./admin.php?id=login");
}else{

// load session MikroTik

$session = $_GET['session'];
if(empty($session)){
  echo "<script>window.location='./admin.php?id=sessions'</script>";
}
$_SESSION["$session"] = $session;
$setsession = $_SESSION["$session"];

$_SESSION["connect"] = "";

// load config
include('./include/config.php');
$iphost=explode('!',$data[$session][1])[1];
$userhost=explode('@|@',$data[$session][2])[1];
$passwdhost=explode('#|#',$data[$session][3])[1];
$hotspotname=explode('%',$data[$session][4])[1];
$dnsname=explode('^',$data[$session][5])[1];
$curency=explode('&',$data[$session][6])[1];
$areload=explode('*',$data[$session][7])[1];
$iface=explode('(',$data[$session][8])[1];
$maxtx=explode(')',$data[$session][9])[1];
$maxrx=explode('+',$data[$session][10])[1];


// load exp
include_once('./lib/exdtmo.php');

$today = strtotime($todays_date);
$expiration_date = strtotime($exp_date);



// routeros api
include_once('./lib/routeros_api.class.php');
include_once('./lib/formatbytesbites.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, decrypt($passwdhost));

$getidentity = $API->comm("/system/identity/print");
  $identity = $getidentity[0]['name'];

// get variable
$hotspot = $_GET['hotspot'];
$hotspotuser = $_GET['hotspot-user'];
$userbyname = $_GET['hotspot-user'];
$removeuseractive = $_GET['remove-user-active'];
$removehost = $_GET['remove-host'];
$removecookie = $_GET['remove-cookie'];
$removeipbinding = $_GET['remove-ip-binding'];
$removehotspotuser = $_GET['remove-hotspot-user'];
$removeuserprofile = $_GET['remove-user-profile'];
$resethotspotuser = $_GET['reset-hotspot-user'];
$removehotspotuserbycomment = $_GET['remove-hotspot-user-by-comment'];
$enablehotspotuser = $_GET['enable-hotspot-user'];
$disablehotspotuser = $_GET['disable-hotspot-user'];
$enableipbinding = $_GET['enable-ip-binding'];
$disableipbinding = $_GET['disable-ip-binding'];
$userprofile = $_GET['user-profile'];
$userprofilebyname = $_GET['user-profile'];
$sys = $_GET['system'];
$enablesch= $_GET['enable-scheduler'];
$disablesch = $_GET['disable-scheduler'];
$removesch  = $_GET['remove-scheduler'];
$macbinding = $_GET['mac'];
$ipbinding = $_GET['addr'];
$ppp = $_GET['ppp'];
$enablesecr= $_GET['enable-pppsecret'];
$disablesecr = $_GET['disable-pppsecret'];
$removesecr  = $_GET['remove-pppsecret'];
$removepprofile  = $_GET['remove-pprofile'];
$removepactive  = $_GET['remove-pactive'];
$srv = $_GET['srv'];
$prof = $_GET['profile'];
$comm = $_GET['comment'];
$serveractive = $_GET['server'];

?>
<?php
include_once('./include/headhtml.php');

include_once('./include/menu.php');

$disable_sci = '<script>
  document.getElementById("comment").onkeypress = function(e) {
    var chr = String.fromCharCode(e.which);
    if (" _!@#$%^&*()+=;|?,.~".indexOf(chr) >= 0)
        return false;
};
</script>';

?>

<?php
// logout
if($hotspot == "logout"){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Logout...</b>";

  session_destroy();
  echo "<script>window.location='./admin.php?id=login'</script>";
}
// redirect to home
elseif(substr($url,-1) == "/" || substr($url,-9) == "index.php"){

  include_once('./include/home.php');
  $_SESSION['ubn'] = "";
}

// redirect to home
elseif($hotspot == "dashboard"){
  include_once('./include/home.php');
  $_SESSION['ubn'] = "";

}

// hotspot log
elseif($hotspot == "log"){
	include_once('./include/log.php');
}

// hotspot log
elseif($hotspot == "userlog"){
  include_once('./include/userlog.php');
}

// about
elseif($hotspot == "about"){
  include_once('./include/about.php');
}

// bad request
elseif(substr($url,-1) == "="){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Bad request! redirect to Home......</b>";

  echo "<script>window.location='./'</script>";
}

// hotspot add users
elseif($hotspot == "add-user"){
  $_SESSION['hua'] = "";
  include_once('./include/adduser.php');
}

// hotspot users
elseif($hotspot == "users" && $prof == "all"){
  $_SESSION['ubp'] = "";
  $_SESSION['hua'] = "";
  $_SESSION['ubc'] = "";
  $_SESSION['vcr'] = "";
  include_once('./include/users.php');
}

// hotspot users filter by profile
elseif($hotspot == "users" && $prof!= ""){
  $_SESSION['ubp'] = $prof;
  $_SESSION['hua'] = "";
  $_SESSION['ubc'] = "";
  $_SESSION['vcr'] = "";
  include_once('./include/users.php');
}

// hotspot users filter by comment
elseif($hotspot == "users" && $comm!= ""){
  $_SESSION['ubc'] = $comm;
  $_SESSION['hua'] = "";
  $_SESSION['ubp'] = "";
  $_SESSION['vcr'] = "";
  include_once('./include/users.php');
}

// hotspot by profile
elseif($hotspot == "users-by-profile"){
  $_SESSION['ubp'] = "";
  $_SESSION['hua'] = "";
  $_SESSION['ubc'] = "";
  $_SESSION['vcr'] = "active";
  include_once('./include/userbyprofile.php');
}
// export hotspot users
elseif($hotspot == "export-users"){
  include_once('./include/exportusers.php');
}


// add hotspot user
elseif($hotspotuser == "add"){
	include_once('./include/adduser.php');
  echo $disable_sci;
}

// add hotspot user
elseif($hotspotuser == "generate"){
	include_once('./include/generateuser.php');
  echo $disable_sci;
}

// hotspot users filter by name
elseif(substr($hotspotuser,0,1) == "*"){
  $_SESSION['ubn'] = $hotspotuser;
  $_SESSION['hua'] = "";
	include_once('./include/userbyname.php');
}elseif($hotspotuser != ""){
  $_SESSION['ubn'] = $hotspotuser;
	include_once('./include/userbyname.php');
}

// remove hotspot user
elseif($removehotspotuser != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removehotspotuser.php');
}

// remove hotspot user by comment
elseif($removehotspotuserbycomment != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removehotspotuserbycomment.php');
}

// reset hotspot user
elseif($resethotspotuser != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/resethotspotuser.php');
}

// enable hotspot user
elseif($enablehotspotuser != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/enablehotspotuser.php');
}

// disable hotspot user
elseif($disablehotspotuser != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/disablehotspotuser.php');
}

// user profile
elseif($hotspot == "user-profiles"){
  include_once('./include/userprofile.php');
}

// add  user profile
elseif($userprofile == "add"){
include_once('./include/adduserprofile.php');
}

// User profile by name
elseif(substr($userprofile,0,1) == "*"){
  include_once('./include/userprofilebyname.php');
}elseif($userprofile != ""){
  include_once('./include/userprofilebyname.php');
}


// remove user profile
elseif($removeuserprofile != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removeuserprofile.php');
}

// hotspot active
elseif($hotspot == "active"){
  $_SESSION['ubp'] = "";
  $_SESSION['hua'] = "hotspotactive";
  $_SESSION['ubc'] = "";
  include_once('./include/hotspotactive.php');
}

// hotspot hosts
elseif($hotspot == "dhcp-leases"){
  include_once('./include/dhcpleases.php');
}

// hotspot hosts
elseif($hotspot == "hosts" || $hotspot == "hostp" || $hotspot == "hosta"){
  include_once('./include/hosts.php');
}

// hotspot bindings
elseif($hotspot == "binding"){
  include_once('./include/binding.php');
}


// hotspot Cookies
elseif($hotspot == "cookies"){
  include_once('./include/cookies.php');
}

// remove hotspot Cookies
elseif($removecookie != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removecookie.php');
}

// hotspot Ip Bindings
elseif($hotspot == "ipbinding"){
  include_once('./include/ipbinding.php');
}

// remove enable disable ipbinding
elseif($removeipbinding != "" || $enableipbinding != "" || $disableipbinding != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/pipbinding.php');
}


// remove user active
elseif($removeuseractive != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removeuseractive.php');
}

// remove host
elseif($removehost != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removehost.php');
}


// makebinding
elseif($macbinding != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/makebinding.php');
}

// selling
elseif($hotspot == "selling"){
  include_once('./include/selling.php');
}

// ppp secret
elseif($ppp== "secrets"){
  include_once('./include/pppsecrets.php');
}

// ppp addsecret
elseif($ppp== "addsecret"){
  include_once('./include/addsecret.php');
}

// remove enable disable secret
elseif($removesecr != "" || $enablesecr != "" || $disablesecr != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/psecret.php');
}


// ppp profile
elseif($ppp== "profiles"){
  include_once('./include/pppprofile.php');
}

// remove enable disable profile
elseif($removepprofile != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removepprofile.php');
}

// ppp active connection
elseif($ppp== "active"){
  include_once('./include/pppactive.php');
}

// remove ppp active connection
elseif($removepactive != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/removepactive.php');
}

// sys scheduler
elseif($sys == "scheduler"){
  include_once('./include/scheduler.php');
}
// remove enable disable scheduler
elseif($removesch != "" || $enablesch != "" || $disablesch != ""){
  echo "<b class='cl-w'><i class='fa fa-circle-o-notch fa-spin' style='font-size:24px'></i> Processing...</b>";

  include_once('./process/pscheduler.php');
}

?>

</div>
</div>
</div>
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/mikhmon.js"></script>
<script src="js/mikhmon-ui.js"></script>
<script>
$(document).ready(function(){
  $("#filterTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#dataTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?php
if($hotspot == "dashboard"){
  echo '<script>
  $(document).ready(function(){
   var interval = "'.($areload * 1000).'";
   setInterval(function() {
    $("#reloadHome").load("./include/home.php?session='.$session.'"); }, interval);})
</script>';
}elseif($hotspot == "active" && $serveractive != ""){
    echo '<script>
  $(document).ready(function(){
   var interval = "'.($areload * 1000).'";
   setInterval(function() {
    $("#reloadHotspotActive").load("./include/hotspotactive.php?server='.$serveractive.'&session='.$session.'"); }, interval);})
</script>
';
}elseif($hotspot == "active" && $serveractive == ""){
    echo '<script>
  $(document).ready(function(){
   var interval = "'.($areload * 1000).'";
   setInterval(function() {
    $("#reloadHotspotActive").load("./include/hotspotactive.php?session='.$session.'"); }, interval);})
</script>
';
}elseif($userprofile == "add" || substr($userprofile,0,1) == "*" || $userprofile != ""){
  echo"<script>
  //enable disable input on ready
$(document).ready(function(){
    var exp = document.getElementById('expmode').value;
    var val = document.getElementById('validity').style;
    var grp = document.getElementById('graceperiod').style;
    var vali = document.getElementById('validi');
    var grpi = document.getElementById('gracepi');
    if (exp === 'rem' || exp === 'remc') {
      val.display= 'table-row';
      vali.type = 'text';
      $('#validi').focus();
      grp.display = 'table-row';
      grpi.type = 'text';
    } else if (exp === 'ntf' || exp === 'ntfc') {
      val.display = 'table-row';
      vali.type = 'text';
      $('#validi').focus();
      grp.display = 'none';
      grpi.type = 'hidden';
    } else {
      val.display = 'none';
      grp.display = 'none';
      vali.type = 'hidden';
      grpi.type = 'hidden';
    }
});
</script>";
}}
?>
</body>
</html>
