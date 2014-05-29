<?php

/**
 * Dashboard class.
 *
 * @category   apps
 * @package    dashboard
 * @subpackage libraries
 * @author     ClearCenter <developer@clearcenter.com>
 * @copyright  2014 ClearCenter
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\dashboard;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('dashboard');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

// Classes
//--------

use \clearos\apps\base\Configuration_File as Configuration_File;
use \clearos\apps\base\Engine as Engine;
use \clearos\apps\log_viewer\Log_Viewer as Log_Viewer;
use \clearos\apps\base\File as File;

clearos_load_library('base/Configuration_File');
clearos_load_library('base/Engine');
clearos_load_library('base/File');

// Exceptions
//-----------

use \clearos\apps\base\Engine_Exception as Engine_Exception;
use \clearos\apps\base\Validation_Exception as Validation_Exception;

clearos_load_library('base/Engine_Exception');
clearos_load_library('base/Validation_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Dashboard class.
 *
 * @category   apps
 * @package    dashboard
 * @subpackage libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dashboard/
 */

class Dashboard extends Engine
{
    ///////////////////////////////////////////////////////////////////////////////
    // C O N S T A N T S
    ///////////////////////////////////////////////////////////////////////////////

    const FILE_CONFIG = '/etc/clearos/dashboard.conf';
    const MAX_ROWS = 5;

    ///////////////////////////////////////////////////////////////////////////////
    // V A R I A B L E S
    ///////////////////////////////////////////////////////////////////////////////

    protected $loaded = FALSE;
    protected $config = array();

    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Dashboard constructor.
     */

    function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);
    }

    /**
     * Set layout.
     *
     * @param array $layout Layout
     *
     * @return void
     * @throws Engine_Exception
     */

    function set_layout($layout)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_layout($layout));

        $this->_set_parameter('layout', json_encode($layout));
    }

    /**
     * Get max rows.
     *
     * @return int
     * @throws Engine_Exception
     */

    function get_max_rows()
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! $this->loaded)
            $this->_load();

        if (empty($this->config['max_rows']))
            return self::MAX_ROWS;

        return $this->config['max_rows'];
    }

    /**
     * Get layout.
     *
     * @return array
     * @throws Engine_Exception
     */

    function get_layout()
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! $this->loaded)
            $this->_load();

        if (empty($this->config['layout']))
            return array(
                0 => array(
                    'columns' => array(
                        0 => array (
                            'controller' => 'intrusion_prevention_report/dashboard_widget',
                            'controller_index' => 0,
                        ),
                        1 => array (
                            'controller' => 'smtp/trusted',
                            'controller_index' => 1,
                        )
                    )
                ),
                1 => array(
                    'columns' => array(
                        0 => array (
                            'controller' => 'smtp/forwarding',
                            'controller_index' => 3,
                        )
                    )
                )
            );

        return json_decode($this->config['layout'], TRUE);
    }

    ///////////////////////////////////////////////////////////////////////////////
    // P R I V A T E   M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Load and parse configuration files.
     *
     * @access private
     *
     * @return void
     * @throws Engine_Exception
     */

    protected function _load()
    {
        clearos_profile(__METHOD__, __LINE__);

        $this->loaded = FALSE;

        // Dashboard Config file
        $configfile = new Configuration_File(self::FILE_CONFIG);

        $this->config = $configfile->load();

        $this->loaded = TRUE;
    }

    /**
     * Generic set routine.
     *
     * @param string $key   key name
     * @param string $value value for the key
     *
     * @return  void
     * @throws Engine_Exception
     */

    private function _set_parameter($key, $value)
    {
        clearos_profile(__METHOD__, __LINE__);

        try {
            $file = new File(self::FILE_CONFIG, TRUE);
            $match = $file->replace_lines("/^$key\s*=.*/", "$key = $value\n");
            if (!$match)
                $file->add_lines("$key = $value\n");
        } catch (Exception $e) {
            throw new Engine_Exception(clearos_exception_message($e), CLEAROS_ERROR);
        }

        $this->is_loaded = FALSE;
    }

    ///////////////////////////////////////////////////////////////////////////////
    // V A L I D A T I O N   M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Validation routine for layout.
     *
     * @param array $layout layout array
     *
     * @return mixed void if layout is OK, errmsg otherwise
     */

    public function validate_layout($layout)
    {
        clearos_profile(__METHOD__, __LINE__);
        if (!is_array($layout) && !empty($layout))
            return lang('dashboard_invalid_layout');
        foreach ($layout as $columns) {
            if (!is_numeric($columns))
                return lang('dashboard_invalid_layout');
        }
    }

}
