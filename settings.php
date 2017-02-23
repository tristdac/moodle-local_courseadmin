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
 * Local plugin "courseadmin" - Settings
 *
 * @package    local_courseadmin
 * @copyright  2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Include lib.php
require_once(dirname(__FILE__) . '/lib.php');

global $CFG, $PAGE;

if ($hassiteconfig) {
    // New settings page
    $page = new admin_settingpage('courseadmin', get_string('pluginname', 'local_courseadmin'));


    // Document filearea
    $page->add(new admin_setting_heading('local_courseadmin/documentsheading', get_string('documents', 'local_courseadmin'), ''));

    // Create document filearea widget
    $page->add(new admin_setting_configstoredfile('local_courseadmin/documents', get_string('documents', 'local_courseadmin'), get_string('documents_desc', 'local_courseadmin'), 'documents', 0, array('maxfiles' => -1, 'accepted_types' => '.html')));


    // Document title source
    $page->add(new admin_setting_heading('local_courseadmin/documenttitlesourceheading', get_string('documenttitlesource', 'local_courseadmin'), ''));

    // Create document title source widget
    $titlesource[COURSEADMIN_TITLE_H1] = get_string('documenttitlesourceh1', 'local_courseadmin');
    $titlesource[COURSEADMIN_TITLE_HEAD] = get_string('documenttitlesourcehead', 'local_courseadmin');
    $page->add(new admin_setting_configselect('local_courseadmin/documenttitlesource', get_string('documenttitlesource', 'local_courseadmin'), get_string('documenttitlesource_desc', 'local_courseadmin'), COURSEADMIN_TITLE_H1, $titlesource));
    $page->add(new admin_setting_configselect('local_courseadmin/documentheadingsource', get_string('documentheadingsource', 'local_courseadmin'), get_string('documentheadingsource_desc', 'local_courseadmin'), COURSEADMIN_TITLE_H1, $titlesource));
    $page->add(new admin_setting_configselect('local_courseadmin/documentnavbarsource', get_string('documentnavbarsource', 'local_courseadmin'), get_string('documentnavbarsource_desc', 'local_courseadmin'), COURSEADMIN_TITLE_H1, $titlesource));


    // Apache rewrite
    $page->add(new admin_setting_heading('local_courseadmin/apacherewriteheading', get_string('apacherewrite', 'local_courseadmin'), ''));

    // Create apache rewrite control widget
    $page->add(new admin_setting_configcheckbox('local_courseadmin/apacherewrite', get_string('apacherewrite', 'local_courseadmin'), get_string('apacherewrite_desc', 'local_courseadmin'), 0));


    // Force login
    $page->add(new admin_setting_heading('local_courseadmin/forceloginheading', get_string('forcelogin', 'local_courseadmin'), ''));

    // Create force login widget
    $forceloginmodes[COURSEADMIN_FORCELOGIN_YES] = get_string('yes');
    $forceloginmodes[COURSEADMIN_FORCELOGIN_NO] = get_string('no');
    $forceloginmodes[COURSEADMIN_FORCELOGIN_GLOBAL] = get_string('forceloginglobal', 'local_courseadmin');
    $page->add(new admin_setting_configselect('local_courseadmin/forcelogin', get_string('forcelogin', 'local_courseadmin'), get_string('forcelogin_desc', 'local_courseadmin'), $forceloginmodes[COURSEADMIN_FORCELOGIN_GLOBAL], $forceloginmodes));


    // Process content
    $page->add(new admin_setting_heading('local_courseadmin/processcontentheading', get_string('processcontent', 'local_courseadmin'), ''));

    // Create process filters widget
    $processfiltersmodes[COURSEADMIN_PROCESSFILTERS_YES] = get_string('processfiltersyes', 'local_courseadmin');
    $processfiltersmodes[COURSEADMIN_PROCESSFILTERS_NO] = get_string('processfiltersno', 'local_courseadmin');
    $page->add(new admin_setting_configselect('local_courseadmin/processfilters', get_string('processfilters', 'local_courseadmin'), get_string('processfilters_desc', 'local_courseadmin'), $processfiltersmodes[COURSEADMIN_PROCESSFILTERS_YES], $processfiltersmodes));

    // Create clean HTML widget
    $cleanhtmlmodes[COURSEADMIN_CLEANHTML_YES] = get_string('cleanhtmlyes', 'local_courseadmin');
    $cleanhtmlmodes[COURSEADMIN_CLEANHTML_NO] = get_string('cleanhtmlno', 'local_courseadmin');
    $page->add(new admin_setting_configselect('local_courseadmin/cleanhtml', get_string('cleanhtml', 'local_courseadmin'), get_string('cleanhtml_desc', 'local_courseadmin'), $cleanhtmlmodes[COURSEADMIN_CLEANHTML_YES], $cleanhtmlmodes));


    // Add settings page to navigation tree
    $ADMIN->add('localplugins', $page);
}
