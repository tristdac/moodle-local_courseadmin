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
 * A scheduled task for courseadmin cron.
 *
 * @package    local_courseadmin
 * @copyright  2017
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_courseadmin\task;



class cron_task extends \core\task\scheduled_task {
	
	

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('pluginname', 'local_courseadmin');
    }

    /**
     * Run courseadmin cron.
     * Function to be run periodically according to the moodle cron.
     * This function runs every 4 hours.
     */
    public function execute() {
        global $DB;
		
        // Get user changes and apply to views
        $conn      = mysqli_connect('localhost', 'root', 'root', 'courses');

		// Write Courses
        mysqli_query($conn, "INSERT IGNORE INTO md_courses (fullname, shortname, idnumber, category, subcategory, description) SELECT fullname, shortname, idnumber, category, subcategory, description FROM ec_courses WHERE created='1' OR shortname LIKE '__________-____'");
		
		// Write Meta
		
		
		// Write Enrolments
		mysqli_query($conn, "INSERT IGNORE INTO md_enrolments (userid, courseid, role, role_code) SELECT ec.userid, ec.courseid, ec.role, ec.role_code FROM ec_enrolments ec LEFT JOIN md_enrolments md ON ec.userid=md.userid AND ec.courseid=md.courseid WHERE (ec.unenrol IS NULL OR ec.unenrol = '0') AND not exists (SELECT 1 FROM md_enrolments where ec.userid=md.userid AND ec.courseid=md.courseid)");
		
		mysqli_query($conn, "REMOVE FROM md_enrolments (userid, courseid, role, role_code) SELECT userid, courseid, role, role_code FROM ec_enrolments WHERE ec_enrolments.unenrol IS NULL OR ec_enrolments.unenrol = '1'");
		
		// Write Users
		mysqli_query($conn, "INSERT IGNORE INTO md_users (userid, surname, forename, email_address, country) SELECT userid, surname, forename, email_address, 'United Kingdom' FROM ec_users");
		
    }

}
