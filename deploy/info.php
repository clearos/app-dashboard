<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'dashboard';
$app['version'] = '1.4.22';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('dashboard_app_description');

$app['sidebar_title'] = lang('base_shutdown_restart');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('dashboard_app_name');
$app['category'] = lang('base_category_spotlight');
$app['subcategory'] = lang('base_subcategory_overview');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['dashboard']['title'] = $app['name'];
$app['controllers']['shutdown']['title'] = lang('base_shutdown_restart');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_requires'] = array(
    'app-base-core >= 1:1.4.22',
    'app-reports-core',
);

// app-*-reports are not really a requirement, but provide a
// sane upgrade path from pre 6.4 releases.  Feel free to remove one day.

$app['requires'] = array(
    'app-system-report',
    'app-network-report',
    'app-resource-report',
);
