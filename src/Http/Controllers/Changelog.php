<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;

class Changelog extends AdminController
{
    public null|string|array $requiredPermissions = ['Paolorox.Restapro.Dashboard'];

    public function __construct()
    {
        parent::__construct();
        AdminMenu::setContext('settings', 'system');
        Template::setTitle('lang:paolorox.restapro::default.nav_changelog');
    }

    public function index()
    {
        return $this->makeView('paolorox.restapro::changelog.index');
    }
}
