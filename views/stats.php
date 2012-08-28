<?php

/**
 * Memory information view.
 *
 * @category   ClearOS
 * @package    Base
 * @subpackage Views
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/base/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.  
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('dashboard');
$this->lang->load('base');

$headers = array(lang(dashboard_stats_item), lang(dashboard_stats_value));
$headers2 = array(lang(base_date), lang(base_time), lang(base_action), lang(dashboard_package));

$rows = array();
$rows2 = array();

foreach ($data as $id => $entry) 
{
    $row['details'] = array ($id,$entry[0]);
    $rows[] = $row;
}

foreach ($log as $logentry)
{
    $row['details'] = array($logentry['date'], $logentry['time'], $logentry['action'], $logentry['package']);
    $rows2[] = $row;
}

$anchors2 = array(anchor_custom('/app/software_updates', 'Software Updates'));

///////////////////////////////////////////////////////////////////////////////
// Table
///////////////////////////////////////////////////////////////////////////////

echo summary_table(
     lang('dashboard_stats_title'),
     $anchors,
     $headers,
     $rows,
     $options
);

echo summary_table(
     lang('dashboard_yum_log'),
     $anchors2,
     $headers2,
     $rows2,
     $options
);
