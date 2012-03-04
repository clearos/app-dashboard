<?php

/**
 * Developer widge controller.
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
 * Developer widge controller.
 *
 * @category   Apps
 * @package    Dashboard
 * @subpackage Controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

class Developer extends ClearOS_Controller
{
    /**
     * Developer widget default controller.
     *
     * @return view
     */

    function index()
    {
        // FIXME
        // Add wizard test link in devel mode
        if ($_SERVER['SERVER_PORT'] == 1501) {
            if ($this->session->userdata('wizard'))
                $wizard_link = "<a href='/app/base/wizard/stop'>Stop Wizard Test</a>";
            else
                $wizard_link = "<a href='/app/base/wizard/start'>Start Wizard Test</a>";
        } else {
            $wizard_link = '';
        }

        echo $wizard_link;
    }
}
