<?php

/**
 * Dashboard controller.
 *
 * @category   apps
 * @package    dashboard
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
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
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

class Settings extends ClearOS_Controller
{
    /**
     * Dashboard summary view.
     *
     * @return view
     */

    function index()
    {
        $this->_view_edit('view');
    }

    /**
     * Dashboard settings edit controller
     *
     * @return view
     */

    function edit()
    {
        $this->_view_edit('edit');
    }

    /**
     * Dashboard view/edit controller
     *
     * @param string $mode mode
     *
     * @return view
     */

    function _view_edit($mode = NULL)
    {
        // Load libraries
        //---------------

        $this->lang->load('dashboard');
        $this->load->library('dashboard/Dashboard');

        // Set validation rules
        //---------------------

        $this->form_validation->set_policy('layout', 'dashboard/Dashboard', 'validate_layout', TRUE);

        $form_ok = $this->form_validation->run();

        // Handle form submit
        //-------------------

        if (($this->input->post('submit') && $form_ok)) {
            try {
                $layout = array();
                // Get the old layout
                $layout_old = $this->dashboard->get_layout();
                // Get the new layout
                $rows = $this->input->post('layout');
                // This contains just the number of rows/columns in each
                // Need to go through and fetch any controllers defined in old layout
                foreach($rows as $row => $columns) {
                    for ($col = 0; $col < $columns; $col++) {
                        if (isset($layout_old[$row]['columns'][$col]['controller']))
                            $layout[$row]['columns'][$col]['controller'] = $layout_old[$row]['columns'][$col]['controller'];
                    }
                }
                $this->dashboard->set_layout($layout);
                $this->page->set_status_updated();
                redirect('/dashboard');
            } catch (Exception $e) {
                $this->page->view_exception($e);
                return;
            }
        }

        // Load view data
        //---------------
        $data = array (
            'mode' => $mode,
            'layout' => $this->dashboard->get_layout()
        );

        // Load views
        //-----------

        $this->page->view_form('dashboard/settings', $data, lang('dashboard_app_name'));

    }
}
