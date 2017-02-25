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
 * External database enrolment sync tests, this also tests adodb drivers
 * that are matching our four supported Moodle database drivers.
 *
 * @package    local_courseadmin
 * @category   phpunit
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_courseadmin_testcase extends advanced_testcase {
    protected static $courses = array();
    protected static $users = array();
    protected static $roles = array();

    /** @var string Original error log */
    protected $oldlog;

    protected function init_local_courseadmin() {
        global $DB, $CFG;

        // Discard error logs from AdoDB.
        $this->oldlog = ini_get('error_log');
        ini_set('error_log', "$CFG->dataroot/testlog.log");

        $dbman = $DB->get_manager();

        set_config('dbencoding', 'utf-8', 'local_courseadmin');

        set_config('dbhost', $CFG->dbhost, 'local_courseadmin');
        set_config('dbuser', $CFG->dbuser, 'local_courseadmin');
        set_config('dbpass', $CFG->dbpass, 'local_courseadmin');
        set_config('dbname', $CFG->dbname, 'local_courseadmin');

        if (!empty($CFG->dboptions['dbport'])) {
            set_config('dbhost', $CFG->dbhost.':'.$CFG->dboptions['dbport'], 'local_courseadmin');
        }

        switch ($DB->get_dbfamily()) {

            case 'mysql':
                set_config('dbtype', 'mysqli', 'local_courseadmin');
                set_config('dbsetupsql', "SET NAMES 'UTF-8'", 'local_courseadmin');
                set_config('dbsybasequoting', '0', 'local_courseadmin');
                if (!empty($CFG->dboptions['dbsocket'])) {
                    $dbsocket = $CFG->dboptions['dbsocket'];
                    if ((strpos($dbsocket, '/') === false and strpos($dbsocket, '\\') === false)) {
                        $dbsocket = ini_get('mysqli.default_socket');
                    }
                    set_config('dbtype', 'mysqli://'.rawurlencode($CFG->dbuser).':'.rawurlencode($CFG->dbpass).'@'.rawurlencode($CFG->dbhost).'/'.rawurlencode($CFG->dbname).'?socket='.rawurlencode($dbsocket), 'local_courseadmin');
                }
                break;

            case 'oracle':
                set_config('dbtype', 'oci8po', 'local_courseadmin');
                set_config('dbsybasequoting', '1', 'local_courseadmin');
                break;

            case 'postgres':
                set_config('dbtype', 'postgres7', 'local_courseadmin');
                $setupsql = "SET NAMES 'UTF-8'";
                if (!empty($CFG->dboptions['dbschema'])) {
                    $setupsql .= "; SET search_path = '".$CFG->dboptions['dbschema']."'";
                }
                set_config('dbsetupsql', $setupsql, 'local_courseadmin');
                set_config('dbsybasequoting', '0', 'local_courseadmin');
                if (!empty($CFG->dboptions['dbsocket']) and ($CFG->dbhost === 'localhost' or $CFG->dbhost === '127.0.0.1')) {
                    if (strpos($CFG->dboptions['dbsocket'], '/') !== false) {
                        $socket = $CFG->dboptions['dbsocket'];
                        if (!empty($CFG->dboptions['dbport'])) {
                            $socket .= ':' . $CFG->dboptions['dbport'];
                        }
                        set_config('dbhost', $socket, 'local_courseadmin');
                    } else {
                      set_config('dbhost', '', 'local_courseadmin');
                    }
                }
                break;

            case 'mssql':
                if (get_class($DB) == 'mssql_native_moodle_database') {
                    set_config('dbtype', 'mssql_n', 'local_courseadmin');
                } else {
                    set_config('dbtype', 'mssqlnative', 'local_courseadmin');
                }
                set_config('dbsybasequoting', '1', 'local_courseadmin');
                break;

            default:
                throw new exception('Unknown database driver '.get_class($DB));
        }
	}

}
