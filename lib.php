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
 * Local plugin "courseadmin" - Library
 *
 * @package    local_courseadmin
 * @copyright  2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// defined('MOODLE_INTERNAL') || die(); - Must not be called because this script is called from outside moodle

define('COURSEADMIN_TITLE_H1', 1);
define('COURSEADMIN_TITLE_HEAD', 2);

define('COURSEADMIN_FORCELOGIN_YES', 1);
define('COURSEADMIN_FORCELOGIN_NO', 2);
define('COURSEADMIN_FORCELOGIN_GLOBAL', 3);

define('COURSEADMIN_PROCESSFILTERS_YES', 1);
define('COURSEADMIN_PROCESSFILTERS_NO', 2);

define('COURSEADMIN_CLEANHTML_YES', 1);
define('COURSEADMIN_CLEANHTML_NO', 2);
