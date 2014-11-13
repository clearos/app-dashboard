
Name: app-dashboard
Epoch: 1
Version: 1.6.7
Release: 1%{dist}
Summary: Dashboard
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
The Dashboard provides a high-level overview of your system.

%package core
Summary: Dashboard - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-base-core >= 1:1.4.22

%description core
The Dashboard provides a high-level overview of your system.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/dashboard
cp -r * %{buildroot}/usr/clearos/apps/dashboard/


%post
logger -p local6.notice -t installer 'app-dashboard - installing'

%post core
logger -p local6.notice -t installer 'app-dashboard-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/dashboard/deploy/install ] && /usr/clearos/apps/dashboard/deploy/install
fi

[ -x /usr/clearos/apps/dashboard/deploy/upgrade ] && /usr/clearos/apps/dashboard/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-dashboard - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-dashboard-core - uninstalling'
    [ -x /usr/clearos/apps/dashboard/deploy/uninstall ] && /usr/clearos/apps/dashboard/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/dashboard/controllers
/usr/clearos/apps/dashboard/htdocs
/usr/clearos/apps/dashboard/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/dashboard/packaging
%dir /usr/clearos/apps/dashboard
/usr/clearos/apps/dashboard/deploy
/usr/clearos/apps/dashboard/language
