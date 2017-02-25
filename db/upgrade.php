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
 * Local plugin "courseadmin" - Upgrade plugin tasks
 *
 * @package    local_courseadmin
 * @copyright  2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_local_courseadmin_upgrade($oldversion) {

    // Fetch documents from documents directory and put them into the new documents filearea.
    if ($oldversion < 2016020309) {
        // Prepare filearea
        $context = \context_system::instance();
        $fs = get_file_storage();
        $filerecord = array('component' => 'local_courseadmin', 'filearea' => 'documents',
                            'contextid' => $context->id, 'itemid' => 0, 'filepath' => '/',
                            'filename' => '');

        // Prepare documents directory
        $documentsdirectory = get_config('local_courseadmin', 'documentdirectory');
        $handle = @opendir($documentsdirectory);

        if ($handle) {
            // Array to remember file to be deleted from documents directory
            $todelete = array();

            // Fetch all files from documents directory
            while (false !== ($file = readdir($handle))) {
                // Only process .html files
                $ishtml = strpos($file, '.html');
                if (!$ishtml) {
                    continue;
                }

                // Compose file name and path
                $filerecord['filename'] = $file;
                $fullpath = $documentsdirectory . '/' . $file;

                // Put file into filearea
                $fs->create_file_from_pathname($filerecord, $fullpath);

                // Remember file to be deleted
                $todelete[] = $fullpath;
            }

            // Close documents directory
            if ($handle) {
                closedir($handle);
            }

            // Show an info message that documents directory is no longer needed
            $message = get_string('upgrade_notice_2016020307', 'local_courseadmin', $documentsdirectory);
            echo html_writer::tag('div', $message, array('class' => 'alert alert-info'));
        }

        // Remove documents directory setting because it is not needed anymore
        set_config('documentdirectory', null, 'local_courseadmin');

        // Remember upgrade savepoint
        upgrade_plugin_savepoint(true, 2016020309, 'local', 'courseadmin');
    }

    return true;
}
