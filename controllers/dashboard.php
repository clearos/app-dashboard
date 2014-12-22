<?php

/**
 * Dashboard controller.
 *
 * @category   apps
 * @package    dashboard
 * @subpackage controllers
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
 * Dashboard controller.
 *
 * @category   apps
 * @package    dashboard
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

class Dashboard extends ClearOS_Controller
{
    /**
     * Dashboard summary view.
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->lang->load('dashboard');
        $this->load->library('dashboard/Dashboard', array('username' => $this->session->userdata('username')), 'my_dashboard');

        // Load controllers
        //-----------------

        $data = array(
            'rows' => $this->my_dashboard->get_max_rows(),
            'layout' => $this->my_dashboard->get_layout()
        );

        $index = 0;
        foreach ($data['layout'] as $row_num => $row) {
            foreach ($row['columns'] as $col => $meta) {
                if (isset($meta['controller'])) {
                    $parts = explode('/', $meta['controller']);
                    $dashboard_widgets[] = array(
                        'controller' => $parts[0] . '/' . $parts[1],
                        'method' => (isset($parts[2]) ? $parts[2] : 'index'),
                        'params' => $row_num . '-' . $col
                    );
                    $data['layout'][$row_num]['columns'][$col]['controller_index'] = $index;
                    $index++;
                }
            }
        }

        if (!empty($dashboard_widgets))
            $data['widgets'] = $this->page->view_controllers($dashboard_widgets, lang('dashboard_app_name'), array('type' => MY_Page::TYPE_DASHBOARD_WIDGET));

        // Add settings and delete widget to breadcrumb trail
        $breadcrumb_links = array(
            'settings' => array('url' => '/app/dashboard/settings', 'tag' => lang('base_settings')),
            'delete' => array('url' => '#', 'tag' => lang('base_delete'), 'class' => 'dashboard-delete')
        );

        $this->page->view_form('dashboard/canvas', $data, lang('dashboard_app_name'), array(
            'type' => MY_Page::TYPE_DASHBOARD,
            'breadcrumb_links' => $breadcrumb_links)
        );
    }
}
