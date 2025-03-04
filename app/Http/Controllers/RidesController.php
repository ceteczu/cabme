<?php

namespace App\Http\Controllers;
use App\Models\Complaints;
use App\Models\UserNote;
use App\Models\Note;
use App\Models\Currency;
use App\Models\Requests;
use App\Models\Rides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RidesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(Request $request,$id=null)
    {

      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');

              $rides = Requests::query()
                  ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.ride_type','tj_requete.dispatcher_id','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant','tj_requete.user_info' ,'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->whereDate('tj_requete.creer', '>=', $fromDate)
                  ->whereDate('tj_requete.creer', '<=', $toDate)
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->orderBy('tj_requete.id','desc')->paginate(20);

        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');

                $rides = DB::table('tj_requete')
                    ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                    ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                    ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                    ->select('tj_requete.id', 'tj_requete.ride_type','tj_requete.dispatcher_id','tj_requete.user_info','tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                    ->whereDate('tj_requete.creer', '>=', $fromDate)
                    ->where('tj_requete.deleted_at', '=', NULL);
                    if($id!='' || $id!=null){
                      $rides->where('tj_requete.id_conducteur','=',$id);
                    }

               $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');

              $rides = DB::table('tj_requete')
                  ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id','tj_requete.ride_type','tj_requete.dispatcher_id' ,'tj_requete.user_info','tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->whereDate('tj_requete.creer', '<=', $toDate)
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

            $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);
        } else if ($request->selected_search == 'userName' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            //$searchs = explode(" ", $search);
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.ride_type', 'tj_requete.dispatcher_id', 'tj_requete.user_info', 'tj_requete.tip_amount', 'tj_requete.admin_commission', 'tj_requete.tax', 'tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image');
                  if($id!='' || $id!=null){
                    $rides->where('tj_user_app.prenom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                  }
                  else{
                    $rides->where('tj_user_app.prenom', 'LIKE', '%' . $search . '%');
                    $rides->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%');
                    $rides->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');

                  }
                  $rides->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

            $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);
        }
        else if ($request->selected_search == 'driverName' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            //$searchs = explode(" ", $search);
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.ride_type', 'tj_requete.dispatcher_id', 'tj_requete.user_info', 'tj_requete.tip_amount', 'tj_requete.admin_commission', 'tj_requete.tax', 'tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image');
                  if($id!='' || $id!=null){
                    $rides->where('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                }
                else{
                    $rides->where('tj_conducteur.prenom', 'LIKE', '%' . $search . '%');
                    $rides->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%');
                    $rides->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                }
                $rides->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

            $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');

              $rides = DB::table('tj_requete')
                  ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.ride_type','tj_requete.dispatcher_id','tj_requete.user_info','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->where('tj_requete.statut', 'LIKE', '%' . $search . '%')
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

            $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);
        }
        else if ($request->selected_search == 'type' && $request->has('ride_type') && $request->ride_type != '') {
            $search = $request->input('ride_type');

            $query = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.ride_type', 'tj_requete.dispatcher_id', 'tj_requete.user_info', 'tj_requete.tip_amount', 'tj_requete.admin_commission', 'tj_requete.tax', 'tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image');
                 // ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $query->where('tj_requete.id_conducteur','=',$id);
                  }
                  if($search == "dispatcher"){
                    $query->where('tj_requete.ride_type','dispatcher');
                     } elseif ($search == "driver_created") {
                      $query->where('tj_requete.ride_type', 'driver');

                    }else{
                    $query->where('tj_requete.ride_type',NULL);
                  }

            $rides = $query->orderBy('tj_requete.id', 'desc')->paginate(20);
        }
         else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.ride_type','tj_requete.dispatcher_id','tj_requete.user_info','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->where('tj_requete.deleted_at', '=', NULL);
                if($id!='' || $id!=null){
                  $rides->where('tj_requete.id_conducteur','=',$id);
                }
            $rides = $rides->orderBy('tj_requete.id', 'desc')->paginate(20);

        }

        return view("rides.all")->with("rides", $rides)->with('currency', $currency)->with('id',$id);
    }

    public function new(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
            }
            else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
                $search = $request->input('ride_status');
                $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
                }
            else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount','tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }

        return view("rides.new")->with("rides", $rides)->with('currency', $currency);
    }

    public function confirmed(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }

        return view("rides.confirmed")->with("rides", $rides)->with('currency', $currency);
    }


    public function onRide(Request $request)
    {

      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                       ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                       ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        return view("rides.onride")->with("rides", $rides)->with('currency', $currency);
    }

    public function rejected(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        //->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        //->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');
                        //->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        return view("rides.rejected")->with("rides", $rides)->with('currency', $currency);
    }

    public function completed(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
            ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
            ->orderBy('tj_requete.creer', 'DESC')
            ->where('tj_requete.statut', 'completed')
            ->where(function ($query) use ($search) {
                $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                    ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                    ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

            })
            ->where('tj_requete.deleted_at', '=', NULL)
            ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
            ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
            ->orderBy('tj_requete.creer', 'DESC')
            ->where('tj_requete.statut', 'completed')
            ->where(function ($query) use ($search) {
                $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                    ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

            })
            ->where('tj_requete.deleted_at', '=', NULL)
            ->paginate(20);
        }
         else {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app', 'tj_requete.id_conducteur', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);

        }
        return view("rides.completed")->with("rides", $rides)->with('currency', $currency);
    }

    public function filterRides(Request $request)
    {
        $page = $request->input('pageName');
        $fromDate = $request->input('datepicker-from');
        $toDate = $request->input('datepicker-to');

        if ($page == "allpage") {
            $rides = DB::table('tj_requete')
                ->leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle')
                ->orderBy('tj_requete.id', 'DESC')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->paginate(10);
            return view("rides.all")->with("rides", $rides);
        } else {

        }

    }

    public function deleteRide($id)
    {

        if ($id != "") {

            $id = json_decode($id);


            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $complaint = Complaints::where('id_ride', $id[$i]);
                    if ($complaint) {
                        $complaint->delete();
                    }
                    $Note = Note::where('ride_id', $id[$i]);
                    if ($Note) {
                        $Note->delete();
                    }
                    $userNote = UserNote::where('ride_id', $id[$i]);
                    if ($userNote) {
                        $userNote->delete();
                    }

                    $user = Requests::find($id[$i]);
                    $user->delete();
                }

            } else {
                $complaint = Complaints::where('id_ride', $id);
                if ($complaint) {
                    $complaint->delete();
                }
                $Note = Note::where('ride_id', $id);
                if ($Note) {
                    $Note->delete();
                }
                $userNote = UserNote::where('ride_id', $id);
                if ($userNote) {
                    $userNote->delete();
                }

                $user = Requests::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

     public function show($id)
     {

         $currency = Currency::where('statut', 'yes')->first();

         $ride = Requests::leftjoin('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
             ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
             ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
             ->join('tj_vehicule', 'tj_requete.id_conducteur', '=', 'tj_vehicule.id_conducteur')
             ->leftjoin('brands', 'tj_vehicule.brand', '=', 'brands.id')
             ->leftjoin('car_model', 'tj_vehicule.model', '=', 'car_model.id')
             ->select('tj_requete.*')
             ->addSelect('tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_conducteur.phone as driver_phone', 'tj_conducteur.email as driver_email', 'tj_conducteur.photo_path as driver_photo')
             ->addSelect('tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_user_app.phone as user_phone', 'tj_user_app.email as user_email','tj_user_app.photo_path')
             ->addSelect('tj_payment_method.libelle', 'tj_payment_method.image')
             ->addSelect('tj_vehicule.brand', 'tj_vehicule.model', 'tj_vehicule.car_make', 'tj_vehicule.numberplate', 'brands.name as brand', 'car_model.name as model')
             ->where('tj_requete.id', $id)->first();

         $id_conducteur = $ride->id_conducteur;
         $montant = $ride->montant;
         $tax = json_decode($ride->tax,true);
         $discount = $ride->discount;
         $tip = $ride->tip_amount;
         $totalAmount = floatval($montant) - floatval($discount);
         $totalTaxAmount = 0;
         $taxHtml = '';
         if (!empty($tax)) {
             for ($i = 0; $i < sizeof($tax); $i++) {
                 $data = $tax[$i];
                 if ($data['type'] == "Percentage") {
                     $taxValue = (floatval($data['value']) * $totalAmount) / 100;
                     $taxlabel = $data['libelle'];
                     $value = $data['value']."%";
                 } else {
                     $taxValue = floatval($data['value']);
                     $taxlabel = $data['libelle'];
                     if ($currency->symbol_at_right == "true") {
                         $value = number_format($data['value'],$currency->decimal_digit) . "" . $currency->symbole;
                     } else {
                         $value = $currency->symbole."".number_format($data['value'],$currency->decimal_digit);
                     }
                 }
                 $totalTaxAmount += floatval(number_format($taxValue,$currency->decimal_digit));
                 if ($currency->symbol_at_right == "true") {
                     $taxValueAmount = number_format($taxValue,$currency->decimal_digit) . "" . $currency->symbole;
                 } else {
                     $taxValueAmount = $currency->symbole . "" . number_format($taxValue,$currency->decimal_digit);
                 }
                 $taxHtml = $taxHtml."<tr><td class='label'>" . $taxlabel . "(" . $value . ")</td><td><span style='color:green'>+" . $taxValueAmount . "<span></td></tr>";
             }
            $totalAmount = floatval($totalAmount) + floatval($totalTaxAmount);

        }
             $totalAmount = floatval($totalAmount) + floatval($tip);
             $customer_review = DB::table('tj_note')->where('tj_note.ride_id', $id)->select('comment','niveau')->get();
             $driver_review = DB::table('tj_user_note')->where('tj_user_note.ride_id', $id)->select('comment','niveau_driver')->get();

        $driverRating = "0.0";

        $driver_rating = DB::table('tj_note')
            ->select(DB::raw("COUNT(id) as ratingCount"), DB::raw("SUM(niveau) as ratingSum"))
            ->where('id_conducteur', '=', $id_conducteur)
            ->first();
            if(!empty($driver_rating)){
                if($driver_rating->ratingCount>0){
                     $driverRating = number_format(($driver_rating->ratingSum / $driver_rating->ratingCount),1);
                }
            }
        $userRating = "0.0";

        if (!empty($ride->id_user_app)) {
            $id_user = $ride->id_user_app;
            $user_rating = DB::table('tj_user_note')
                ->select(DB::raw("COUNT(id) as ratingCount"), DB::raw("SUM(niveau_driver) as ratingSum"))
                ->where('id_user_app', '=', $id_user)
                ->first();
            if (!empty($user_rating)) {
                if ($user_rating->ratingCount > 0) {
                    $userRating = number_format(($user_rating->ratingSum / $user_rating->ratingCount));
                }
            }

        }
        $complaints = Complaints::select('title', 'description','user_type')->where('id_ride', $id)->get();


        return view("rides.show")->with("ride", $ride)->with("currency", $currency)
                 ->with("customer_review", $customer_review)
                 ->with("driver_review", $driver_review)
                 ->with("complaints", $complaints)
                 ->with('taxHtml', $taxHtml)
                 ->with('totalAmount', $totalAmount)
                 ->with('driverRating',$driverRating)
                 ->with('userRating',$userRating);
         
    }

    public function updateRide(Request $request, $id)
    {

        $rides = Rides::find($id);
        if ($rides) {
            $rides->statut = $request->input('order_status');
            $rides->save();
        }

        return redirect()->back();

    }

}
