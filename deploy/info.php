<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'dashboard';
$app['version'] = '2.0.21';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('dashboard_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('dashboard_app_name');
$app['category'] = lang('base_category_system');
$app['subcategory'] = lang('base_subcategory_base');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['dashboard']['title'] = $app['name'];

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_requires'] = array(
    'app-base-core >= 1:1.4.22',
);

$app['core_file_manifest'] = array(
    'dashboard.conf' => array(
        'target' => '/etc/clearos/dashboard.conf',
        'mode' => '0644',
        'config' => TRUE,
        'config_params' => 'noreplace',
    ),
);
