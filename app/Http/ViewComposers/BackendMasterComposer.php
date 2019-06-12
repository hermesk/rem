<?php

namespace App\Http\ViewComposers;
use App\Http\Helpers\AppHelper;
use Illuminate\Contracts\View\View;

class BackendMasterComposer
{
    public function compose(View $view)
    {

        // get app settings
        $appSettings = AppHelper::getAppSettings();

        $view->with('maintainer', 'Jakiwa Solutions');
        $view->with('maintainer_url', 'http://jakiwasolutions.com');
        $view->with('appSettings', $appSettings);
        $view->with('languages', AppHelper::LANGUEAGES);
        $view->with('idc', '36237fc442afd31e37c0acab35ad6b19d96c232a');
        $view->with('institute_category', AppHelper::getInstituteCategory());
    }
}