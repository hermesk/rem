<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppMeta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * institute setting section content manage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function institute(Request $request)
    {


        //for save on POST request
        if ($request->isMethod('post')) {

            //validate form
            $messages = [
                'logo.max' => 'The :attribute size must be under 1MB.',
                'logo_small.max' => 'The :attribute size must be under 512kb.',
                'logo.dimensions' => 'The :attribute dimensions max be 230 X 50.',
                'logo_small.dimensions' => 'The :attribute dimensions max be 50 X 50.',
                'favicon.max' => 'The :attribute size must be under 512kb.',
                'favicon.dimensions' => 'The :attribute dimensions must be 32 X 32.',
            ];

            $rules = [
                'name' => 'required|min:5|max:255',
                'short_name' => 'required|min:3|max:255',
                'logo' => 'mimes:jpeg,jpg,png|max:1024|dimensions:max_width=230,max_height=50',
                'logo_small' => 'mimes:jpeg,jpg,png|max:512|dimensions:max_width=50,max_height=50',
                'favicon' => 'mimes:png|max:512|dimensions:min_width=32,min_height=32,max_width=32,max_height=32',
                'establish' => 'min:4|max:255',
                'website_link' => 'max:255',
                'email' => 'nullable|email|max:255',
                'phone_no' => 'required|min:8|max:15',
                'address' => 'required|max:500',
            ];

            
            $this->validate($request, $rules, $messages);



            if($request->hasFile('logo')) {
                $storagepath = $request->file('logo')->store('public/logo');
                $fileName = basename($storagepath);
                $data['logo'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogo','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['logo'] = $request->get('oldLogo','');
            }

            if($request->hasFile('logo_small')) {
                $storagepath = $request->file('logo_small')->store('public/logo');
                $fileName = basename($storagepath);
                $data['logo_small'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogoSmall','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['logo_small'] = $request->get('oldLogoSmall','');
            }

            if($request->hasFile('favicon')) {
                $storagepath = $request->file('favicon')->store('public/logo');
                $fileName = basename($storagepath);
                $data['favicon'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldFavicon','');
                if( $oldFile != ''){
                    $file_path = "public/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            }
            else{
                $data['favicon'] = $request->get('oldFavicon','');
            }

            $data['name'] = $request->get('name');
            $data['short_name'] = $request->get('short_name');
            $data['establish'] = $request->get('establish');
            $data['website_link'] = $request->get('website_link');
            $data['email'] = $request->get('email');
            $data['phone_no'] = $request->get('phone_no');
            $data['address'] = $request->get('address');

            //now crate
            AppMeta::updateOrCreate(
                ['meta_key' => 'institute_settings'],
                ['meta_value' => json_encode($data)]
            );



            Cache::forget('app_settings');

            //now notify the admins about this record
            $msg = "Institute settings updated by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end

            return redirect()->route('settings.institute')->with('success', 'Setting updated!');
        }

        //for get request
        $settings = AppMeta::where('meta_key', 'institute_settings')->first();
        $info = null;
        if($settings) {
            $info = json_decode($settings->meta_value);
        }


        $settings = AppMeta::all();

        $metas = [];
        foreach ($settings as $setting){
            $metas[$setting->meta_key] = $setting->meta_value;
        }


        $institute_type = isset($metas['institute_type']) ? $metas['institute_type'] : 1;



        return view(
            'backend.settings.institute', compact(
                'info',
                'metas',
            )
        );
    }




}
