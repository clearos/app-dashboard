<?php

/**
 * Stats information controller.
 *
 * @category   Apps
 * @package    Dashboard
 * @subpackage Controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
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
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Stats information controller.
 *
 * @category   Apps
 * @package    Dashboard
 * @subpackage Controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

class Stats extends ClearOS_Controller
{
    /**
     * Stats default controller
     *
     * @return view
     */

    function index()
    {
        // Load dependencies
        //------------------

        $this->lang->load('base');
        //$this->lang->load('reports');
        $this->load->library('base/Stats');

        $body = '';

        // Load view data
        //---------------

        try {
            $data[lang(dashboard_clearos_version)] = $this->stats->get_clearos_version();
	    $data[lang(dashboard_kernel_version)] = $this->stats->get_kernel_version();
	    $data[lang(dashboard_system_time)] = $this->stats->get_system_time();
            $data[lang(dashboard_cpu_model)] = $this->stats->get_cpu_model();
            $mem_size = $this->stats->get_mem_size();
            $data[lang(dashboard_mem_size)] = array($mem_size .' '. lang(base_gigabytes));

            $uptimes = $this->stats->get_uptimes();
            $days = floor($uptimes['uptime'] / (60*60*24));
            $hours = round(($uptimes['uptime'] - ($days * 60 * 60 * 24))/(60 * 60), 1);
            $data[lang(dashboard_uptime)] = array($days .' '. lang('base_days') .' '. $hours .' '. lang('base_hours'));

	    $load = $this->stats->get_load_averages();
	    $data[lang(dashboard_load)] = array($load['one'] . ' ' . $load['five'] . ' ' . $load['fifteen']);

            $yum_log = $this->stats->get_yum_log();
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }
        $array['data'] = $data;
	$array['log'] = $yum_log;
        // Load views
        //-----------

        $this->page->view_form('dashboard/stats', $array, lang('reports_stats_information'));
    }

    /**
     * Report data.
     *
     * @return JSON report data
     */

    function get_data()
    {
        clearos_profile(__METHOD__, __LINE__);

        // Load dependencies
        //------------------

        $this->load->library('base/Stats');

        // Load data
        //----------

        try {
            $data['version'] = $this->stats->get_clearos_version();
	    $data['kernel'] = $this->stats->get_kernel_version();
	    $data['system_time'] = $this->stats->get_system_time();
            $data['cpu_model'] = $this->stats->get_cpu_model();
            $mem_size = $this->stats->get_mem_size();
	    $data['mem_size'] = array($mem_size .' '. lang(base_gigabytes));

	    $uptimes = $this->stats->get_uptimes();
	    $days = floor($uptimes['uptime'] / (60*60*24));
            $hours = round(($uptimes['uptime'] - ($days * 60 * 60 * 24))/(60 * 60), 1);
            $data['uptime'] = array($days .' '. lang('base_days') .' '. $hours .' '. lang('base_hours'));

            $load = $this->stats->get_load_averages();
            $data['load'] = array($load['one'] . ' ' . $load['five'] . ' ' . $load['fifteen']);

            $yum_log = $this->stats->get_yum_log();
        } catch (Exception $e) {
            echo json_encode(array('code' => clearos_exception_code($e), 'errmsg' => clearos_exception_message($e)));
        }
	$array['data'] = $data;
	$array['log'] = $yum_log;
        // Show data
        //----------

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Fri, 01 Jan 2010 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($array);
    }
}
