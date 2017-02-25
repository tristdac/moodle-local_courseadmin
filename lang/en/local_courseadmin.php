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
 * Local plugin "courseadmin" - Language pack
 *
 * @package    local_courseadmin
 * @copyright  2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Course Admin';
$string['apacherewrite'] = 'Force Apache mod_rewrite';
$string['apacherewrite_desc'] = 'Serve Course Admin page only with a clean URL, rewritten by Apache mod_rewrite. See README file for details.';
$string['cleanhtml'] = 'Clean HTML code';
$string['cleanhtml_desc'] = 'Configure if the static page\'s HTML code should be cleaned (and thereby special tags like <iframe> being removed). See README for details.';
$string['cleanhtmlyes'] = 'Yes, clean HTML code';
$string['cleanhtmlno'] = 'No, don\'t clean HTML code';
$string['documents'] = 'Documents';
$string['documents_desc'] = 'The .html files with the static pages\' HTML code. See README file for details.';
$string['documentheadingsource'] = 'Data source of document heading';
$string['documentheadingsource_desc'] = 'The data source of the static page\'s document heading';
$string['documentnavbarsource'] = 'Data source of breadcrumb item title';
$string['documentnavbarsource_desc'] = 'The data source of the static page\'s breadcrumb item title (used in the Moodle "Navbar")';
$string['documenttitlesource'] = 'Data source of document title';
$string['documenttitlesource_desc'] = 'The data source of the static page\'s document title (used in the browser titlebar)';
$string['documenttitlesourceh1'] = 'First h1 tag in HTML code (usually located shortly after opening the body tag)';
$string['documenttitlesourcehead'] = 'First title tag in HTML code (usually located within the head tag)';
$string['forcelogin'] = 'Force login';
$string['forcelogin_desc'] = 'Serve Course Admin page only to logged in users or also to non-logged in visitors. This behaviour can be set specifically for Course Admin or can be set to respect Moodle\'s global forcelogin setting. See README for details.';
$string['forceloginglobal'] = 'Respect the global setting $CFG->forcelogin';
$string['pagenotfound'] = 'Page not found';
$string['processcontent'] = 'Process content';
$string['processfilters'] = 'Process filters';
$string['processfilters_desc'] = 'Configure if Moodle filters (especially the multilanguage filter) should be processed when serving the Course Admin page\'s content. See README for details.';
$string['processfiltersyes'] = 'Yes, process filters';
$string['processfiltersno'] = 'No, don\'t process filters';
$string['upgrade_notice_2016020307'] = '<strong>UPGRADE NOTICE:</strong> The static page document files were moved to the new filearea within Moodle. You can delete the legacy documents directory {$a} now. For more upgrade instructions, especially if you have been using the multilanguage features of this plugin, see README file.';

$string['collegedatabase:config'] = 'Configure database enrol instances';
$string['collegedatabase:unenrol'] = 'Unenrol suspended users';
$string['collegedatabase:receiveerrorsemail'] = 'Receive messages when Edinburgh College databse synchronisation fails';
$string['dbencoding'] = 'Database encoding';
$string['dbhost'] = 'Database host';
$string['dbhost_desc'] = 'Type database server IP address or host name. Use a system DSN name if using ODBC.';
$string['dbname'] = 'Database name';
$string['dbname_desc'] = 'Leave empty if using a DSN name in database host.';
$string['dbpass'] = 'Database password';
$string['dbsetupsql'] = 'Database setup command';
$string['dbsetupsql_desc'] = 'SQL command for special database setup, often used to setup communication encoding - example for MySQL and PostgreSQL: <em>SET NAMES \'utf8\'</em>';
$string['dbsybasequoting'] = 'Use sybase quotes';
$string['dbsybasequoting_desc'] = 'Sybase style single quote escaping - needed for Oracle, MS SQL and some other databases. Do not use for MySQL!';
$string['dbtype'] = 'Database driver';
$string['dbtype_desc'] = 'ADOdb database driver name, type of the external database engine.';
$string['dbuser'] = 'Database user';
$string['debugdb'] = 'Debug ADOdb';
$string['debugdb_desc'] = 'Debug ADOdb connection to external database - use when getting empty page during login. Not suitable for production sites!';
$string['defaultrole'] = 'Default role';
$string['defaultrole_desc'] = 'The role that will be assigned by default if no other role is specified in external table.';
$string['ignorehiddencourses'] = 'Ignore hidden courses';
$string['ignorehiddencourses_desc'] = 'If enabled users will not be enrolled on courses that are set to be unavailable to students.';
$string['localcategoryfield'] = 'Local category field';
$string['localcoursefield'] = 'Local course field';
$string['localrolefield'] = 'Local role field';
$string['localuserfield'] = 'Local user field';
$string['newcoursetable'] = 'Remote new courses table';
$string['newcoursetable_desc'] = 'Specify of the name of the table that contains list of courses that should be created automatically. Empty means no courses are created.';
$string['newcoursecategory'] = 'New course category field';
$string['newcoursesubcategory'] = 'New course subcategory field';
$string['newcoursefullname'] = 'New course full name field';
$string['newcourseidnumber'] = 'New course ID number field';
$string['newcourseshortname'] = 'New course short name field';
$string['newcoursedescription'] = 'New course description field';
$string['remotecoursefield'] = 'Remote course field';
$string['remotecoursefield_desc'] = 'The name of the field in the remote table that we are using to match entries in the course table.';
$string['remoteenroltable'] = 'Remote user enrolment table';
$string['remoteenroltable_desc'] = 'Specify the name of the table that contains list of user enrolments. Empty means no user enrolment sync.';
$string['remoteotheruserfield'] = 'Remote Other User field';
$string['remoteotheruserfield_desc'] = 'The name of the field in the remote table that we are using to flag "Other User" role assignments.';
$string['remoterolefield'] = 'Remote role field';
$string['remoterolefield_desc'] = 'The name of the field in the remote table that we are using to match entries in the roles table.';
$string['remoteuserfield'] = 'Remote user field';
$string['settingsheaderdb'] = 'External database connection';
$string['settingsheaderlocal'] = 'Local field mapping';
$string['settingsheaderremote'] = 'Remote enrolment sync';
$string['settingsheadernewcourses'] = 'Creation of new courses';
$string['remoteuserfield_desc'] = 'The name of the field in the remote table that we are using to match entries in the user table.';
$string['newcourseyear'] = 'Current course year';
$string['newcourseyear_desc'] = 'The year of the courses currently in the remote course table, courses will be created with this as the highest level category.';
$string['sync_enrolments'] = 'Synchronise enrolments for existing users and courses from Edinburgh College database';
$string['sync_users'] = 'Synchronise users (provision new and update only) from Edinburgh College database';
$string['sync_courses'] = 'Synchronise courses (provision new and update fullname, shortname only) from Edinburgh College database';
$string['settingsheaderusers'] = 'User information';
$string['userstable'] = 'Remote user table';
$string['userstable_desc'] = 'Table of valid users to be created or updated. Leave empty or disable scheduled task to stop';
$string['usersusername'] = 'Username';
$string['usersfirstname'] = 'First name';
$string['userslastname'] = 'Last name';
$string['usersemail'] = 'Email address';
$string['messageprovider:errors'] = 'Error notifications from the users and enrolments synchronisation scheduled tasks';
