<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Referral;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->limit = 20;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = UserApp::all();
        //$users = UserApp::paginate($this->limit);
        return response()->json($users);

    }

    public function register(Request $request)
    {
        $prenom = $request->get('firstname');
        $prenom = str_replace("'", "\'", $prenom);
        $nom = $request->get('lastname');
        $nom = str_replace("'", "\'", $nom);
        $phone = $request->get('phone');
        $email = $request->get('email');
        $mdp = $request->get('password');
        $mdp = str_replace("'", "\'", $mdp);
        $login_type = $request->get('login_type');
        $tonotify = $request->get('tonotify');
        $account_type = $request->get('account_type');
        $referral_code = $request->get('referral_code');
        $mdp = md5($mdp);
        $date_heure = date('Y-m-d H:i:s');
        //$address = $request->get('address');


        if ($account_type == "customer") {

            $chkephone = UserApp::where('phone', $phone)->first();
            $chkemail = UserApp::where('email', $email)->first();

            if (!empty($chkephone) or !empty($chkemail)) {
                if (!empty($chkephone)) {
                    $row = $chkephone->toArray();
                    if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                        $response['success'] = 'Social Login';
                        $response['error'] = null;
                        $response['message'] = 'Login successful';

                        unset($row['mdp']);
                        $response['user'] = $row;
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Phone number already exist...';

                    }
                }

                if (!empty($chkemail)) {
                    $row = $chkemail->toArray();

                    if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                        $response['success'] = 'Social Login';
                        $response['error'] = null;

                        unset($row['mdp']);
                        $response['user'] = $row;
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Email already exist...';

                    }

                }
            } else {
                $gender = $request->get('gender');
                $age = $request->get('age');


                /*$insertdata = mysqli_query($con, "insert into tj_user_app(prenom,phone,mdp,statut,login_type,tonotify,creer,email,address,age,gender)
                values('$prenom','$phone','$mdp','yes','$login_type','$tonotify','$date_heure','$email','$address','$age','$gender')");*/
                $insertdata = DB::insert("insert into tj_user_app(prenom,nom,phone,mdp,statut,login_type,tonotify,creer,statut_nic,email,age,gender)
                    values('" . $prenom . "','" . $nom . "','" . $phone . "','" . $mdp . "','yes','" . $login_type . "','" . $tonotify . "','" . $date_heure . "','no','" . $email . "','" . $age . "','" . $gender . "')");

                $id = DB::getPdo()->lastInsertId();
                //$id = mysqli_insert_id($con);
                $referralBy = '';
                if($referral_code!=''){
                    $query=Referral::Where('referral_code',$referral_code)->first();
                    if(!empty($query)){
                        $referralBy=$query->user_id;
                    }

                }
                $uniqid = uniqid();
                $rand_start = rand(1,5);
                $userReferralCode= substr($uniqid,$rand_start,5);
                Referral::insert([

                    'user_id'=>$id,
                    'referral_by_id'=>$referralBy ? $referralBy : null,
                    'referral_code'=>$userReferralCode,
                    'code_used'=>'false',
                    'creer'=>$date_heure
                    ]);



                if ($id > 0) {
                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'User Registered successfully';

                    $get_user = UserApp::where('id', $id)->first();
                    $row = $get_user->toArray();
                    unset($row['mdp']);
                    $row['user_cat'] = "user_app";
                    $row['accesstoken'] = $this->adduseraccess($row['id'], 'customer');
                    /*$get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                    $row_currency = $get_currency->fetch_assoc();*/
                    $get_currency = Currency::where('statut', 'yes')->first();
                    $row_currency = $get_currency->toArray();
                    $row['currency'] = $row_currency['symbole'];
                    $row['decimal_digit'] = $row_currency['decimal_digit'];

                    /*$get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                    $row_country = $get_country->fetch_assoc();*/
                    $row['country'] = '';
                    $get_country = Country::where('statut', 'yes')->first();
                    if (!empty($get_country)) {
                        $row_country = $get_country->toArray();
                        $row['country'] = $row_country['code'];

                    }


                    $row['country'] = $row_country['code'];
                    $get_admin_commission = DB::table('tj_commission')->select('*')->where('statut', '=', 'yes')->get();
                    foreach ($get_admin_commission as $row_commission) {
                        $row['admin_commission'] = $row_commission->value;
                    }
                    $row['referral_code']=$userReferralCode;
                    $row['referral_by']=$referralBy ? $referralBy : null;
                    $row['id']=(string)$id;
                    $response['data'] = $row;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Id Not Found';
                }
            }
        } elseif ($account_type == "driver") {
            $chkephone = Driver::where('phone', $phone)->first();
            $chkemail = Driver::where('email', $email)->first();

            if (!empty($chkephone) or !empty($chkemail)) {
                if (!empty($chkephone)) {
                    $row = $chkephone->toArray();

                    if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                        $response['success'] = 'Social Login';
                        $response['error'] = null;

                        unset($row['mdp']);
                        $response['user'] = $row;
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Phone number already exist...';

                    }
                }
                if (!empty($chkemail)) {
                    $row = $chkemail->toArray();

                    if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                        $response['success'] = 'Social Login';
                        $response['error'] = null;


                        unset($row['mdp']);
                        $response['user'] = $row;
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Email already exist...';
                    }
                }

            } else {

                $insertdata = DB::insert("insert into tj_conducteur(online,prenom,nom,phone,mdp,statut,login_type,tonotify,creer,updated_at,status_car_image,statut_vehicule,email,address,amount,parcel_delivery)
                values('yes','" . $prenom . "','" . $nom . "','" . $phone . "','" . $mdp . "','no','" . $login_type . "','" . $tonotify . "','" . $date_heure . "','" . $date_heure . "','no','no','" . $email . "','','0','yes')");
                $id = DB::getPdo()->lastInsertId();
                //$id = mysqli_insert_id($con);
                if ($id > 0) {
                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'Driver Registered Success';

                    $get_user = Driver::where('id', $id)->first();
                    $row = $get_user->toArray();
                    unset($row['mdp']);

                    $row['accesstoken'] = $this->adduseraccess($row['id'], 'driver');
                    //print_r($row['accesstoken']);die();
                    $row['user_cat'] = "driver";
                    // $get_user = mysqli_query($con, "select * from tj_conducteur where id=$id");
                    // foreach($get_user as $row){
                    // //$row = $get_user->fetch_assoc();
                    // unset($row['mdp']);
                    // $row['user_cat'] = "conducteur";

                    $get_currency = Currency::where('statut', 'yes')->first();
                    $row_currency = $get_currency->toArray();
                    $row['currency'] = $row_currency['symbole'];

                    // $get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                    // $row_currency = $get_currency->fetch_assoc();
                    // $row['currency'] = $row_currency['symbole'];
                    $row['country'] = '';
                    $get_country = Country::where('statut', 'yes')->first();
                    if(!empty($get_country)){
                        $row_country = $get_country->toArray();
                        $row['country'] = $row_country['code'];

                    }

                    // $get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                    // $row_country = $get_country->fetch_assoc();
                    $get_admin_commission = DB::table('tj_commission')->select('*')->where('statut', '=', 'yes')->get();
                    foreach ($get_admin_commission as $row_commission) {
                        $row['admin_commission'] = $row_commission->value;
                    }
                    $row['id']=(string)$id;
                    $response['data'] = $row;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Id Not Found';

                }
                $emailsubject = '';
                $emailmessage = '';
                $emailtemplate = DB::table('email_template')->select('*')->where('type', 'new_registration')->first();
                if (!empty($emailtemplate)) {
                    $emailsubject = $emailtemplate->subject;
                    $emailmessage = $emailtemplate->message;
                    $send_to_admin = $emailtemplate->send_to_admin;
                }

                $email = DB::table('tj_settings')->select('contact_us_email')->value('contact_us_email');
                $email = $email ? $email : 'none@none.com';
                $to = '';
                if ($send_to_admin == "true") {
                    $to = $email;
                }

                $app_name = env('APP_NAME', 'Cabme');
                $date = date('d F Y');
                $emailmessage = str_replace("{AppName}", $app_name, $emailmessage);
                $emailmessage = str_replace("{UserName}", $row['nom'] . " " . $row['prenom'], $emailmessage);
                $emailmessage = str_replace("{UserEmail}", $row['email'], $emailmessage);
                $emailmessage = str_replace("{UserPhone}", $row['phone'], $emailmessage);
                $emailmessage = str_replace('{UserId}', $row['id'], $emailmessage);
                $emailmessage = str_replace('{Date}', $date, $emailmessage);


                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: ' . $app_name . '<' . $email . '>' . "\r\n";
                mail($to, $emailsubject, $emailmessage, $headers);
                // }
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Not Found';
        }


        return response()->json($response);
    }

    public static function url()
    {
        $actual_link = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = preg_replace('/^www\./', '', parse_url($actual_link, PHP_URL_HOST));
        if (($_SERVER['HTTPS'] && $_SERVER['HTTPS'] === 'on')) {
            return "https://" . $site_url;
        } else {
            return "http://" . $site_url;
        }

    }

    public function adduseraccess($user_id, $user_type)
    {
        $token = $this->getUniqAccessToken();
        $user = DB::table('users_access')->where('user_id', $user_id)->where('user_type', $user_type)->first();
        if ($user) {
            DB::table('users_access')
                ->where('id', $user->id)
                ->update(['accesstoken' => $token]);
        } else {
            DB::table('users_access')->insert(['user_id' => $user_id, 'accesstoken' => $token, 'user_type' => $user_type]);
        }
        return $token;
    }

    public function getUniqAccessToken()
    {
        $accessget = 0;
        $accessToken = '';
        while ($accessget == 0) {
            $accessToken = md5(uniqid(mt_rand(), true));
            $user = DB::table('users_access')->where('accesstoken', $accessToken)->first();
            if (!$user) {
                $accessget = 1;
            }
        }
        return $accessToken;
    }


}
