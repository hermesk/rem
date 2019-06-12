<?php
namespace App\Http\Helpers;

use App\Event;
use App\Jobs\ProcessSms;
use App\Notifications\UserActivity;
use App\Permission;
use App\Registration;
use App\SiteMeta;
use App\Template;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\AppMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Picqer\Barcode\BarcodeGeneratorPNG;


class AppHelper
{

    const LANGUEAGES = [
        'en' => 'English',
 
    ];
    const USER_ADMIN = 1;
    const USER_TEACHER = 2;
    const USER_STUDENT = 3;
    const USER_PARENTS = 4;
    const USER_ACCOUNTANT = 5;
    const USER_LIBRARIAN = 6;
    const USER_RECEPTIONIST = 7;
    const ACTIVE = '1';
    const INACTIVE = '0';
    const EMP_TEACHER = AppHelper::USER_TEACHER;
    const EMP_SHIFTS = [
        1 => 'Day',
        2 => 'Night'
    ];
    const GENDER = [
        1 => 'Male',
        2 => 'Female'
    ];
 



    const SUBJECT_TYPE = [
        1 => 'Core',
        2 => 'Electives'
    ];

    const ATTENDANCE_TYPE = [
        0 => 'Absent',
        1 => 'Present'
    ];

    const TEMPLATE_TYPE = [
        1 => 'SMS',
        2 => 'EMAIL',
        3 => 'ID CARD'
    ];

    const SMS_GATEWAY_LIST = [
        1 => 'Bulk SMS Route',
        2 => 'IT Solutionbd',
        3 => 'Zaman IT',
        4 => 'MIM SMS',
        5 => 'Twilio',
        6 => 'Log Locally',
    ];

    const LEAVE_TYPES = [
        1 => 'Casual leave (CL)',
        2 => 'Sick leave (SL)',
        3 => 'Maternity leave (ML)',
        4 => 'paternity leave (PL)',
        5 => 'Undefined leave (UL)'
    ];

    const MARKS_DISTRIBUTION_TYPES = [
      1 => "End Term Exam",
      2 => "MidTerm Exam",
      3 => "Opener Exam",
      4 => "CAT 1",
      5 => "CAT 2",
      6 => "Attendance",
      7 => "Assignment",
      8 => "Lab Report",
      9 => "Practical",

    ];

    const GRADE_TYPES = [
        1 => 'A',
        2 => 'A-',
        3 => 'B+',
        4 => 'B',
        5 => 'B-',
        6 => 'C+',
        7 => 'C',
        8 => 'C-',
        9 => 'D+',
       10 => 'D',
       11 => 'D-',
       12 => 'E',
    ];
    const PASSING_RULES = [1 => 'Over All', 2 => 'Individual', 3 => 'Over All & Individual' ];


    /**
     * Get institution category for app settings
     * school or college
     * @return mixed
     */
    public static function getInstituteCategory() {

        $iCategory = env('INSTITUTE_CATEGORY', 'school');
        if($iCategory != 'school' && $iCategory != 'college'){
            $iCategory = 'school';
        }

        return $iCategory;
    }

   

    /**
     * @return string
     */

    public static function getUserSessionHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/resources/views/backend/partial/footer.blade.php';
        $contents = file_get_contents($path);
        $c_sha1 = sha1($contents);
        return substr($c_sha1, 0, 7);
    }

    public static function getShortName($phrase)
    {
        /**
         * Acronyms generator of a phrase
         */
        return preg_replace('~\b(\w)|.~', '$1', $phrase);
    }

    public static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function getJwtAssertion($private_key_file)
    {

        $json_file = file_get_contents($private_key_file);
        $info = json_decode($json_file);
        $private_key = $info->{'private_key'};

        //{Base64url encoded JSON header}
        $jwtHeader = self::base64url_encode(json_encode(array(
            "alg" => "RS256",
            "typ" => "JWT"
        )));

        //{Base64url encoded JSON claim set}
        $now = time();
        $jwtClaim = self::base64url_encode(json_encode(array(
            "iss" => $info->{'client_email'},
            "scope" => "https://www.googleapis.com/auth/analytics.readonly",
            "aud" => "https://www.googleapis.com/oauth2/v4/token",
            "exp" => $now + 3600,
            "iat" => $now
        )));

        $data = $jwtHeader.".".$jwtClaim;

        // Signature
        $Sig = '';
        openssl_sign($data,$Sig,$private_key,'SHA256');
        $jwtSign = self::base64url_encode($Sig);

        //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
        $jwtAssertion = $data.".".$jwtSign;
        return $jwtAssertion;
    }

    public static function getGoogleAccessToken($private_key_file)
    {

        $result = [
            'success' => false,
            'message' => '',
            'token' => null
        ];

        if (Cache::has('google_token')) {
            $result['token'] = Cache::get('google_token');
            $result['success'] = true;
            return $result;
        }

        if(!file_exists($private_key_file)){
            $result['message'] = 'Google json key file missing!';
            return $result;

        }

        $jwtAssertion = self::getJwtAssertion($private_key_file);

        try {

            $client = new Client([
                'base_uri' => 'https://www.googleapis.com',
            ]);
            $payload = [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwtAssertion
            ];

            $response = $client->request('POST', 'oauth2/v4/token', [
                'form_params' => $payload
            ]);

            $data = json_decode($response->getBody());
            $result['token'] = $data->access_token;
            $result['success'] = true;

            $expiresAt = now()->addMinutes(58);
            Cache::put('google_token', $result['token'], $expiresAt);

        } catch (RequestException $e) {
            $result['message'] = $e->getMessage();
        }


        return $result;

    }

    

    /**
     *
     *    Application settings fetch
     *
     */
    public static function getAppSettings($key=null){
        $appSettings = null;
        if (Cache::has('app_settings')) {
            $appSettings = Cache::get('app_settings');
        }
        else{
            $settings = AppMeta::all();

            $metas = [];
            foreach ($settings as $setting){
                $metas[$setting->meta_key] = $setting->meta_value;
            }
            if(isset($metas['institute_settings'])){
                $metas['institute_settings'] = json_decode($metas['institute_settings'], true);
            }
            $appSettings = $metas;
            Cache::forever('app_settings', $metas);

        }

        if($key){
            return $appSettings[$key] ?? 0;
        }

        return $appSettings;
    }



    /**
     *
     *    Application Permission
     *
     */
    public static function getPermissions(){

        if (Cache::has('app_permissions')) {
            $permissions = Cache::get('app_permissions');
        }
        else{
            try{

                $permissions = Permission::get();
                Cache::forever('app_permissions', $permissions);

            } catch (\Illuminate\Database\QueryException $e) {
                $permissions = collect();
            }
        }

        return $permissions;
    }

    /**
     *
     *    Application users By group
     *
     */
    public static function getUsersByGroup($groupId){

            try{

                $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
                    ->where('user_roles.role_id', $groupId)
                    ->select('users.id')
                    ->get();

            } catch (\Illuminate\Database\QueryException $e) {
                $users = collect();
            }


        return $users;
    }

    /**
     *
     *    Send notification to users
     *
     */
    public static function sendNotificationToUsers($users, $type, $message){
        Notification::send($users, new UserActivity($type, $message));

        return true;
    }

    /**
     *
     *    Send notification to Admin users
     *
     */
    public static function sendNotificationToAdmins($type, $message){
        $admins = AppHelper::getUsersByGroup(AppHelper::USER_ADMIN);
        return AppHelper::sendNotificationToUsers($admins, $type, $message);
    }



}