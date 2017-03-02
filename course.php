<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Local plugin "courseadmin" - View page
 *
 * @package    local_courseadmin
 * @copyright  2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// defined('MOODLE_INTERNAL') || die(); - Must not be called because this script is called from outside moodle
// Include lib.php
require_once(dirname(__FILE__) . '/lib.php');
// Include config.php
require_once('../../config.php');
require_login();
// Globals
global $PAGE, $USER;
// Get plugin config
$local_courseadmin_config = get_config('local_courseadmin');
// Require login if the plugin or Moodle is configured to force login
if ($local_courseadmin_config->forcelogin == COURSEADMIN_FORCELOGIN_YES || ($local_courseadmin_config->forcelogin == COURSEADMIN_FORCELOGIN_GLOBAL && $CFG->forcelogin)) {
    require_login();
}
// View only with /static/ URL
if ($local_courseadmin_config->apacherewrite == true) {
    if (strpos($_SERVER['REQUEST_URI'], '/static/') > 0 || strpos($_SERVER['REQUEST_URI'], '/static/') === false) {
        die;
    }
}
// Set page context
$PAGE->set_context(context_system::instance());
// Fetch context
$context = \context_system::instance();
// Set page layout
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('pluginname', 'local_courseadmin'));
$PAGE->set_heading(get_string('pluginname', 'local_courseadmin'));
$PAGE->set_url('/local/courseadmin/course.php');
$username = $USER->username;
$dbhost    = get_config('local_courseadmin', 'dbhost');
$dbuser    = get_config('local_courseadmin', 'dbuser');
$dbpass    = get_config('local_courseadmin', 'dbpass');
$dbname    = get_config('local_courseadmin', 'dbname');
$conn      = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$success = "<div class='success' style='padding:20px;color:#fff;background:green;margin:20px 0;' ><span style='font-size:20px;'>Save Successful!</span>
<hr>Please allow up to an hour for these changes to be processed.</div>";
$updatedcourse = FALSE;
if (isset($_POST["created"])) {
if (count($_POST) > 0) {
    $created = $_POST['created'];
    array_map('intval', $created);
    $created = implode(',', $created);
    mysqli_query($conn, "UPDATE ec_courses SET created = 1 WHERE idnumber IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
	mysqli_query($conn, "UPDATE ec_enrolments SET enrol = 1 WHERE courseid IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    $updatedcourse = TRUE;
}
}
$updatedmeta = FALSE;
if (isset($_POST["meta"])) {
if (count($_POST) > 0) {
    $meta = $_POST['meta'];
    array_map('intval', $meta);
    $meta = implode(',', $meta);
	if ( isset( $_POST['parent'] ) ) {
		foreach ( $_POST['parent'] as $parent ) {
//	$parent = $_POST['unique'];
//	array_map('intval', $parent);
//    $parent = implode(',', $parent);

//	$child = $_POST['unique'];
//	array_map('intval', $child);
//    $child = implode(',', $child);
//	$unique = $_POST['unique'];
//	array_map('intval', $unique);
//    $unique = implode(',', $unique);
//	$parent = '111';
	if ( isset( $_POST['child'] ) ) {
	foreach ( $_POST['child'] as $child ) {
		$unique = $parent . $child;
//    mysqli_query($conn, "UPDATE md_meta SET meta=0 WHERE id IN ($meta)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
	$insert = "INSERT IGNORE INTO md_meta (enrol, status, courseid, sortorder, name, enrolperiod, enrolstartdate, enrolenddate, expirynotify, expirythreshold, notifyall, password, cost, currency, roleid, customint1, customint2, customint3, customint4, customint5, customint6, customint7, customint8, customchar1, customchar2, customchar3, customdec1, customdec2, customtext1, customtext2, customtext3, customtext4, timecreated, timemodified)
	VALUES ('meta', '0', '$parent', '0', 'NULL', '0', '0', '0', '0', '0', '0', 'NULL', 'NULL', 'NULL', '0', '$child', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', '$unique', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL',  UNIX_TIMESTAMP(), UNIX_TIMESTAMP())";
	$remove = "DELETE FROM md_meta WHERE courseid NOT IN ($parent) AND customint1 = ($child)";
    mysqli_query($conn, $insert) or trigger_error(mysqli_error($conn), E_USER_ERROR);
	mysqli_query($conn, $remove) or trigger_error(mysqli_error($conn), E_USER_ERROR);
}
		}
		}
}
	    $updatedmeta = TRUE;
}
}
$updatedenrol = FALSE;
if (isset($_POST["enrol"])) {
if (count($_POST) > 0) {
    $enrol = $_POST['enrol'];
    array_map('intval', $enrol);
    $enrol = implode(',', $enrol);
    mysqli_query($conn, "UPDATE ec_enrolments SET enrol=0 WHERE (courseid NOT IN ($enrol)) AND userid = '$username'") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    mysqli_query($conn, "UPDATE ec_enrolments SET enrol=1 WHERE courseid IN ($enrol) AND userid = '$username'") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    $updatedenrol = TRUE;
}
}
?>

<body>
<?php
echo $OUTPUT->header();
?>
<h1>Course Admin</h1>
<div id="exTab2" class="container">	
<ul class="nav nav-tabs">
			<li class="active">
        <a  href="#course" data-toggle="tab">Course Creator</a>
			</li>
			<li><a href="#meta" data-toggle="tab">Meta Links</a>
			</li>
			<li><a href="#enrol" data-toggle="tab">Enrolment</a>
			</li>
		</ul>

			<div class="tab-content ">
			  
        
        
        
         <div class="tab-pane active" id="course">
          <h3>Course Creator</h3>
          <p>Select the courses below that you would like created on Moodle.</p>
			  
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
if ($updatedcourse === TRUE) {
    echo ($success);
}
?>
				<table>
				<tr>
				<th class="c0"></th>
				<th class="c1">Course/Unit Name</th>
				<th class="c2"><i class="fa fa-group"></i> Group</th>
				</tr>
				<?php
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE ec_enrolments.userid = '$username' AND INSTR (ec_courses.shortname, '/') ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created) = mysqli_fetch_row($result)) {
    $checked = ($created == 1) ? 'checked="checked"' : '';
    echo '<tr class="c0"><td><input type="checkbox" id="check' . $id . '" name="created[]" value="' . $idnumber . '" ' . $checked . '/></td><td class="c1">' . $fullname . '</td><td class="c2">' . $description . '</td></tr>' . "\n";
	if ($checked) {
		?>
		<script>
			document.getElementById("check<?php echo ($id) ?>").disabled = true;
			</script>
			<?php
	}
}
?>
					<tr><td colspan="2" id="submit"><input type="submit" name="submitcourses" value="Save Selection" style="margin:20px 0;"/></td></tr>
			</table>
			</form>
				</div>

         
         
         
         
<div class="tab-pane" id="meta">
          <h3>Meta Link</h3>
          <p>Use the meta-linker to connect multiple units to a single unit</p>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <?php
if ($updatedmeta === TRUE) {
    echo ($success);
}
?>
           <!-- tabs left -->
<div class="tabbable tabs-left">
<ul class="nav nav-tabs">
	<li class="active"><a href="#0" data-toggle="tab"><b>Select a Course</b></a></li>
          <?php
$count = 1;
$sql = "SELECT ec_courses.idnumber, ec_courses.fullname, ec_courses.created, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE (ec_enrolments.userid = '$username' AND INSTR (ec_courses.shortname, '/') AND ec_courses.created = '1') ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($parentidnumber, $fullname) = mysqli_fetch_row($result)) {
    $incrementli = $count;
//	echo $parentidnumber;
    echo '<li><a href="#' . $incrementli . '" data-toggle="tab">' . $fullname . '</a></li>' . "\n";
    $incrementli = $count++;
	echo '<input type="hidden" name="parent[]" value="' . $parentidnumber . '" />';
}
?>
</ul>
        
        
        
<div class="tab-content">
         <div class="tab-pane active" id="0">Select a course from the list on the left, then put a check in the corresponding box(es) in the list to the right to meta link that course to create meta links. <br>
         <img src="http://scilsng.com/wp-content/uploads/2015/07/Computer-Networking.jpg">
         </div>
			 <?php
$count = 1;
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE (ec_enrolments.userid = '$username' AND INSTR (ec_courses.shortname, '/') AND ec_courses.created = '1') ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created, $shortname) = mysqli_fetch_row($result)) {
	$current      = substr($shortname, 0, strpos($shortname, "/"));
	$currentname  = str_replace($shortname, "", $fullname);
    $incrementdiv = $count;
    echo '<div class="tab-pane" id="' . $incrementdiv . '">';
	echo '<h4>Your other units containing <b>"' . $currentname . '"</b> in the title</h4>';
//	echo $idnumber;
	echo '<ul>';
    $sqlli = "SELECT ec_enrolments.courseid, ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.shortname, md_meta.courseid, md_meta.customint1, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_enrolments.courseid = ec_courses.idnumber LEFT JOIN md_meta ON ec_courses.idnumber = md_meta.customint1 WHERE (ec_enrolments.userid = '$username' AND INSTR (ec_courses.shortname, '/') AND ec_courses.shortname != '$shortname') ORDER by ec_courses.fullname ASC";
	$resultli = mysqli_query($conn, $sqlli) or trigger_error(mysqli_error($conn), E_USER_ERROR);
	while (list($courseid, $idli, $childidnumber, $fullnameli, $descriptionli, $createdli, $shortnameli, $metaparent, $metachild) = mysqli_fetch_row($resultli)) {
		if ((strpos($shortnameli, $current) !== false) || (strpos($fullnameli, $currentname) !== false)) {
		if ($metaparent = $idnumber) {
			$metachecked = 1;
		}
		if (($metachild != $childidnumber) && ($idli != $metaparent) && ($parentidnumber != $metaparent)) {
			$metachecked = 0;
		}
//		echo $metaparent;
		$checked = ($metachecked == 1) ? 'checked="checked"' : '';
        echo '<p><li><input type="hidden" name="meta[]" value="0" /><input type="checkbox" name="meta[]" value="' . $childidnumber . '" ' . $checked . '/>' . $fullnameli . '</li><ul class="group"><li>' . $descriptionli . '</li></ul></p>' . "\n";
    	
		echo 
			'<input type="hidden" name="child[]" value="' . $childidnumber . '" />
			<input type="hidden" name="unique[]" value="' . $idli . '" />';
	}
	}
echo '</ul></div>' . "\n";
$incrementdiv = $count++;
}
?>
</div>
</div>
<input type="submit" name="submitmeta" value="Save Selection" style="margin:20px 0;"/>
</form>



</div>
         
<div class="tab-pane" id="enrol">
          <h3>Enrolment</h3>
          <p>You are enrolled as a teacher on courses and units with a tick next to their name. Untick courses or units for which you no longer wish to participate in. You may re-enrol yourself from this page at a later time if you change your mind.</p>  
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
if ($updatedenrol === TRUE) {
    echo ($success);
}
?>
				<table>
				<tr>
				<th class="c0"></th>
				<th class="c1">Course/Unit Name</th>
				<th class="c2"><i class="fa fa-group"></i> Group</th>
				</tr>
				<?php
$sql = "SELECT ec_enrolments.courseid, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_enrolments.enrol, ec_enrolments.courseid, ec_enrolments.userid FROM ec_enrolments INNER JOIN ec_courses ON ec_enrolments.courseid = ec_courses.idnumber WHERE ec_enrolments.userid = '$username' AND (ec_courses.created = '1' OR shortname LIKE '__________-____') ORDER by ec_courses.created DESC, ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($iden, $idnumberen, $fullnameen, $descriptionen, $createden, $enrol) = mysqli_fetch_row($result)) {
//	if ($enrol = 1) {
//		$enrolled = 1;
//	}
//	if ($enrol = 0){
//		$enrolled = 0;
//	}
    $checked = ($enrol == 1 ) ? 'checked="checked"' : '';
    echo '<tr class="c0"><td><input type="hidden" name="enrol[]" value="0" /><input type="checkbox" name="enrol[]" value="' . $idnumberen . '" ' . $checked . '/></td><td class="c1">' . $fullnameen . '</td><td class="c2">' . $descriptionen . ' </td></tr>' . "\n";
}
?>
					<tr><td colspan="2" id="submit"><input type="submit" name="submitenrol" value="Save Selection" style="margin:20px 0;"/></td></tr>
			</table>
			</form>
				</div>
				
				
				
				
				
				
</div>
</div>




<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>
</html>