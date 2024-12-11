<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\ParcelOrder;
use Illuminate\Http\Request;

class SearchDriverParcelOrdersController extends Controller
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


    public function getData(Request $request)
    {
        $months = array("January" => 'Jan', "February" => 'Feb', "March" => 'Mar', "April" => 'Apr', "May" => 'May', "June" => 'Jun', "July" => 'Jul', "August" => 'Aug', "September" => 'Sep', "October" => 'Oct', "November" => 'Nov', "December" => 'Dec');

        $source_lat = $request->get('source_lat');
        $source_lng = $request->get('source_lng');
        $destination_lat = $request->get('destination_lat');
        $destination_lng = $request->get('destination_lng');
        $date = $request->get('date');
        $source_city = $request->get('source_city');
        $driver_id = $request->get('driver_id');
        $driver=Driver::where('id', $driver_id)->where('is_verified','1')->first();
        if(empty($driver)){
            $response['success'] = 'Failed';
            $response['error'] = 'Your document is not verified. Contact to admin for approval';
            $response['message'] = null;

        }else{
        $output = [];
        if ((!empty($date)) || (!empty($source_lat) && !empty($source_lng)) || (!empty($destination_lat) && !empty($destination_lng))) {
            $ParcelOrder = ParcelOrder::join('tj_payment_method', 'tj_payment_method.id', '=', 'parcel_orders.id_payment_method')
                ->Join('tj_user_app', 'tj_user_app.id', '=', 'parcel_orders.id_user_app')
                ->join('parcel_category', 'parcel_category.id', '=', 'parcel_orders.parcel_type')
                ->select('parcel_orders.*',
                    'tj_payment_method.libelle as payment_method',
                    'parcel_category.title as parcel_type',
                    'tj_user_app.nom',
                    'tj_user_app.prenom',
                    'tj_user_app.phone as user_phone',
                    'tj_user_app.photo_path as user_photo'
                    );
            if (!empty($date)) {
                $ParcelOrder = $ParcelOrder->where('parcel_date', '=', $date);
            }
            if (!empty($source_lat) && !empty($source_lng)) {
                $ParcelOrder = $ParcelOrder->where('lat_source', '=', $source_lat)->where('lng_source', '=', $source_lng);
            }
            if (!empty($destination_lat) && !empty($destination_lng)) {
                $ParcelOrder = $ParcelOrder->where('lat_destination', '=', $destination_lat)->where('lng_destination', '=', $destination_lng);
            }
            $ParcelOrder = $ParcelOrder->where('parcel_orders.status', '=', 'new')->get();

            if ($ParcelOrder->isEmpty()) {
                $ParcelOrder = ParcelOrder::join('tj_payment_method', 'tj_payment_method.id', '=', 'parcel_orders.id_payment_method')
                    ->join('parcel_category', 'parcel_category.id', '=', 'parcel_orders.parcel_type')
                    ->Join('tj_user_app', 'tj_user_app.id', '=', 'parcel_orders.id_user_app')
                    ->select('parcel_orders.*',
                     'tj_payment_method.libelle as payment_method', 
                     'parcel_category.title as parcel_type', 
                     'tj_user_app.nom', 'tj_user_app.prenom', 
                     'tj_user_app.phone as user_phone', 
                     'tj_user_app.photo_path as user_photo')
                    ->where('source_city', '=', $source_city)->where('parcel_orders.status', '=', 'new')->get();
            }

            if (!$ParcelOrder->isEmpty()) {
                foreach ($ParcelOrder as $row) {
                    $row->id= (string)$row->id;
                    $row->user_name = (string)$row->prenom . " " . $row->nom;
                    if ($row->parcel_image != '') {
                        $parcelImage = json_decode($row->parcel_image, true);
                        $image_user = [];
                        foreach ($parcelImage as $value) {
                            if (file_exists(public_path('images/parcel_order/' . '/' . $value))) {
                                $image = asset('images/parcel_order/') . '/' . $value;
                            }
                            array_push($image_user, $image);
                        }
                        if (!empty($image_user)) {
                            $row->parcel_image = $image_user;
                        } else {
                            $row->parcel_image = asset('assets/images/placeholder_image.jpg');
                        }
                    }

                    if ($row->user_photo != '') {
                        if (file_exists(public_path('assets/images/users' . '/' . $row->user_photo))) {
                            $user_photo = asset('assets/images/users') . '/' . $row->user_photo;
                        } else {
                            $user_photo = asset('assets/images/placeholder_image.jpg');
                        }
                        $row->user_photo = $user_photo;
                    }
                    $row->created_at = date("d", strtotime($row->created_at)) . " " . $months[date("F", strtotime($row->created_at))] . ". " . date("Y", strtotime($row->created_at));

                    $output[] = $row;
                        
                }
                if (!empty($output)) {
                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'Parcel Order fetch successfully';
                    $response['data'] = $output;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'No Data Found';
                }

            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'No Data Found';
                $response['message'] = null;

            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field required';

        }
    }
        return response()->json($response);
    }

}
