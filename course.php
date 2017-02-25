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
// Globals
global $PAGE, $COURSE, $USER, $DB;
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
//$colexists = mysqli_query($conn, "SELECT selected FROM ec_courses");
//if (!$colexists) {
//    $insert_col = "ALTER TABLE ec_courses ADD selected INT NOT NULL";
//    mysqli_query($conn, $insert_col);
//    mysqli_query($conn, "ALTER TABLE ec_courses ADD selected VARCHAR( 255 )");
//}
$updatedcourse = FALSE;
if (count($_POST) > 0) {
    $created = $_POST['created'];
    array_map('intval', $created);
    $created = implode(',', $created);
    mysqli_query($conn, "UPDATE ec_courses SET created=0") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    mysqli_query($conn, "UPDATE ec_courses SET created=1 WHERE id IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
	mysqli_query($conn, "UPDATE ec_courses SET selected=1 WHERE id IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    $updatedcourse = TRUE;
}
$updatedmeta = FALSE;
if (count($_POST) > 0) {
    $created = $_POST['created'];
    array_map('intval', $created);
    $created = implode(',', $created);
    mysqli_query($conn, "UPDATE ec_courses SET created=0") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    mysqli_query($conn, "UPDATE ec_courses SET created=1 WHERE id IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    $updatedcourse = TRUE;
}
$updatedenrol = FALSE;
if (count($_POST) > 0) {
    $created = $_POST['created'];
    array_map('intval', $created);
    $created = implode(',', $created);
    mysqli_query($conn, "UPDATE ec_courses SET created=0") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    mysqli_query($conn, "UPDATE ec_courses SET created=1 WHERE id IN ($created)") or trigger_error(mysqli_error($conn), E_USER_ERROR);
    $updatedcourse = TRUE;
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
          <p>Select the courses below that you would like created on Moodle</p>
			  
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
if ($updatedcourse === TRUE) {
    echo "<div class='success' style='padding:20px;color:#fff;background:green;margin:20px 0;font-size:20px;'>Save Successful!</div>";
}
?>
				<table>
				<tr>
				<th class="c0"></th>
				<th class="c1">Course/Unit Name</th>
				<th class="c2"><i class="fa fa-group"></i> Group</th>
				</tr>
				<?php
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.selected, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE ec_enrolments.userid = '$username' AND ec_courses.shortname LIKE '%%/%%' ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created, $selected) = mysqli_fetch_row($result)) {
    $checked = ($created == 1) ? 'checked="checked"' : '';
    echo '<tr class="c0"><td><input type="checkbox" name="created[]" value="' . $id . '" ' . $checked . '/></td><td class="c1">' . $fullname . '</td><td class="c2">' . $description . '</td></tr>' . "\n";
}
?>
					<tr><td colspan="2"><input type="submit" name="submitcourses" value="Save Selection" style="margin:20px 0;"/></td></tr>
			</table>
			</form>
				</div>

         
         
         
         
<div class="tab-pane" id="meta">
          <h3>Meta Link</h3>
          <p>Use the meta-linker to connect multiple units to a single unit</p>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <?php
if ($updatedmeta === TRUE) {
    echo "<div class='success' style='padding:20px;color:#fff;background:green;margin:20px 0;font-size:20px;'>Save Successful!</div>";
}
?>
           <!-- tabs left -->
<div class="tabbable tabs-left">
<ul class="nav nav-tabs">
	<li class="active"><a href="#0" data-toggle="tab"><b>Select a Course</b></a></li>
          <?php
$count = 1;
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE (ec_enrolments.userid = '$username' AND ec_courses.shortname LIKE '%%/%%' AND ec_courses.created = '1') ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created) = mysqli_fetch_row($result)) {
    $incrementli = $count;
    echo '<li><a href="#' . $incrementli . '" data-toggle="tab">' . $fullname . '</a></li>' . "\n";
    $incrementli = $count++;
}
?>
</ul>
        
        
        
<div class="tab-content">
         <div class="tab-pane active" id="0">Select a course from the list on the left, then put a check in the corresponding box(es) in the list to the right to meta link that course to create meta links. 
         <img src="http://scilsng.com/wp-content/uploads/2015/07/Computer-Networking.jpg">
         </div>
			 <?php
$count = 1;
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE (ec_enrolments.userid = '$username' AND ec_courses.shortname LIKE '%%/%%' AND ec_courses.created = '1') ORDER by ec_courses.fullname ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created, $shortname) = mysqli_fetch_row($result)) {
	$current      = substr($shortname, 0, strpos($shortname, "/"));
    $incrementdiv = $count;
    echo '<div class="tab-pane" id="' . $incrementdiv . '">';
	echo '<h4>Your other occurrences of ' . $current . '</h4>';
	echo '<ul>';
    $sqlli = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE (ec_enrolments.userid = '$username' AND ec_courses.shortname LIKE '%%/%%' AND ec_courses.shortname != '$shortname') ORDER by ec_courses.fullname ASC";
$resultli = mysqli_query($conn, $sqlli) or trigger_error(mysqli_error($conn), E_USER_ERROR);
	while (list($idli, $idnumberli, $fullnameli, $descriptionli, $createdli, $shortnameli) = mysqli_fetch_row($resultli)) {
		if (strpos($shortnameli, $current) !== false) {
		$checked = ($createdli == 1) ? 'checked="checked"' : '';
        echo '<li><input type="checkbox" name="created[]" value="' . $idli . '" ' . $checked . '/>  ' . $fullnameli . '</li><ul class="group"><li>' . $description . '</li></ul>' . "\n";
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
          <p>Untick courses or units for which you would not like to participate in</p>  
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
if ($updatedenrol === TRUE) {
    echo "<div class='success' style='padding:20px;color:#fff;background:green;margin:20px 0;font-size:20px;'>Save Successful!</div>";
}
?>
				<table>
				<tr>
				<th class="c0"></th>
				<th class="c1">Course/Unit Name</th>
				<th class="c2"><i class="fa fa-group"></i> Group</th>
				</tr>
				<?php
$sql = "SELECT ec_courses.id, ec_courses.idnumber, ec_courses.fullname, ec_courses.description, ec_courses.created, ec_courses.selected, ec_courses.shortname, ec_enrolments.courseid, ec_enrolments.userid FROM ec_courses INNER JOIN ec_enrolments ON ec_courses.idnumber = ec_enrolments.courseid WHERE ec_enrolments.userid = '$username' ORDER by ec_courses.description ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn), E_USER_ERROR);
while (list($id, $idnumber, $fullname, $description, $created, $selected) = mysqli_fetch_row($result)) {
    $checked = ($created == 1) ? 'checked="checked"' : '';
    echo '<tr class="c0"><td><input type="checkbox" name="created[]" value="' . $id . '" ' . $checked . '/></td><td class="c1">' . $fullname . '</td><td class="c2">' . $description . ' </td></tr>' . "\n";
}
?>
					<tr><td colspan="2"><input type="submit" name="submitcourses" value="Save Selection" style="margin:20px 0;"/></td></tr>
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