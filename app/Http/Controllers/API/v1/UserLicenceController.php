<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use DB;
class UserLicenceController extends Controller
{

   public function __construct()
   {
      $this->limit=20;
   }
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

  public function updateUserLicence(Request $request)
  {

        $image= $request->file('image');
        $id_user = $request->get('id_driver');
        $date_heure = date('Y-m-d H:i:s');

        if(empty($image))
        {
            $response['success']= 'Failed';
            $response['error']= 'Image Not Found';
        } else
        {

        $file = $request->file('image');
        $extenstion = $file->getClientOriginalExtension();
        $time = time().'.'.$extenstion;
        $filename = 'Driver_Licence_'.$time;
        $file->move(public_path('assets/images/driver'), $filename);

        $updatedata = DB::update('update tj_conducteur set photo_licence = ?,photo_licence_path = ?,modifier = ? where id = ?',[$image,$filename,$date_heure,$id_user]);

        if($updatedata > 0){
            if(!empty($image))

            //$updatedatas = DB::update('update tj_conducteur set statut_licence = ? where id = ?',['uploaded',$id_user]);

            $get_user = Driver::where('id',$id_user)->first();
            $row = $get_user->toArray();
            $row['id']=(string)$row['id'];
            $image_user = $row['photo_path'];
            $photo = '';
            $row['photo'] = $photo;
            $row['photo_nic'] = $photo;
            $row['photo_car_service_book'] = $photo;
            $row['photo_licence'] = $photo;
            $row['photo_road_worthy'] = $photo;
            if($image_user != ''){
                if(file_exists(public_path('assets/images/driver'.'/'.$image_user )))
                {
                    $image_user = asset('assets/images/driver').'/'. $image_user;
                }
                else
                {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $row['photo_path'] = $image_user;
            }
            $image = $row['photo_nic_path'];

            if($image != ''){
                if(file_exists(public_path('assets/images/driver'.'/'.$image )))
                {
                    $image = asset('assets/images/driver').'/'. $image;
                }
                else
                {
                    $image = asset('assets/images/placeholder_image.jpg');

                }
                $row['photo_nic_path'] = $image;
            }
            $car = $row['photo_car_service_book_path'];
            if($car != ''){
              if(file_exists(public_path('assets/images/driver'.'/'.$car )))
              {
                  $car = asset('assets/images/driver').'/'. $car;
              }
              else
              {
                  $car = asset('assets/images/placeholder_image.jpg');

              }
              $row['photo_car_service_book_path'] = $car;
          }
          $licence = $row['photo_licence_path'];
          if($licence != ''){
            if(file_exists(public_path('assets/images/driver'.'/'.$licence )))
            {
                $licence = asset('assets/images/driver').'/'. $licence;
            }
            else
            {
                $licence = asset('assets/images/placeholder_image.jpg');

            }
            $row['photo_licence_path'] = $licence;
        }
        if($row['photo_road_worthy_path'] != ''){
            if(file_exists(public_path('assets/images/driver'.'/'.$row['photo_road_worthy_path'] )))
            {
                $road = asset('assets/images/driver').'/'. $row['photo_road_worthy_path'];
            }
            else
            {
                $road = asset('assets/images/placeholder_image.jpg');

            }
            $row['photo_road_worthy_path'] = $road;
        }
            $response['success']= 'Success';
            $response['error']= null;
            $response['message']= 'Licence Updated';
            $response['data'] = $row;
        } else {
          $response['success']= 'Failed';
          $response['error']= 'Licence Not Updated';
        }
      }


    return response()->json($response);
  }

}
