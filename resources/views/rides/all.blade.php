@extends('layouts.app')

@section('content')
<div class="page-wrapper">

  <div class="row page-titles">

    <div class="col-md-5 align-self-center">

      <h3 class="text-themecolor">{{trans('lang.all_rides')}}</h3>

    </div>

    <div class="col-md-7 align-self-center">

      <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

        <li class="breadcrumb-item active">{{trans('lang.all_rides')}}</li>

      </ol>

    </div>

    <div>

    </div>

  </div>


  <div class="container-fluid">

    <div class="row">

      <div class="col-12">

        <div class="card">

          <div class="card-body">

            <h4 class="card-title"></h4>

            <div class="userlist-topsearch d-flex mb-3">
                            <!-- <div class="userlist-top-left">
                                  <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#typeVehicleModal"><i class="fa fa-plus mr-2"></i>{{trans('lang.create_new_ride')}}</a>
                                </div>  -->

                                <div id="users-table_filter" class="ml-auto">
                                  <label>{{ trans('lang.search_by')}}
                                    <div class="form-group  mb-0">
                                      @if($id!='')
                                      <form action="{{ url('rides/all',['id'=>$id]) }}" method="get">
                                        @else
                                        <form action="{{ route('rides.all') }}" method="get">
                                          @endif
                                          @if(isset($_GET['selected_search']) &&  $_GET['selected_search'] != '')
                                          <select name="selected_search" id="selected_search"
                                          class="form-control input-sm">
                                          <option value="userName"
                                          @if($_GET['selected_search']=='userName')
                                          selected="selected" @endif>{{trans('lang.user_name')}}</option>
                                          <option value="driverName"
                                          @if($_GET['selected_search']=='driverName')
                                          selected="selected" @endif>{{trans('lang.driver_name')}}</option>
                                          <option value="status" @if($_GET['selected_search']=='status')
                                          selected="selected" @endif>{{trans('lang.status')}}</option>
                                          <option value="type" @if($_GET['selected_search']=='type')
                                          selected="selected" @endif>{{trans('lang.ride_type')}}</option>
                                        </select>
                                        @else
                                        <select name="selected_search" id="selected_search"
                                        class="form-control input-sm">
                                        <option value="userName">{{trans('lang.user_name')}}</option>
                                        <option value="driverName">{{trans('lang.driver_name')}}</option>
                                        <option value="status">{{trans('lang.status')}}</option>
                                        <option value="type">{{trans('lang.ride_type')}}</option>

                                      </select>
                                      @endif

                                      <div class="search-box position-relative">
                                        @if(isset($_GET['search']) &&  $_GET['search'] != '')
                                        <input type="text" class="search form-control" name="search"
                                        id="search" value="{{$_GET['search']}}" >
                                        <select id="ride_status" class="form-control"
                                        name="ride_status" style="display: none">
                                        <option value="confirmed" >{{ trans('lang.confirmed')}}</option>
                                        <option  value="new">{{ trans('lang.new')}}</option>
                                        <option value="on ride" >{{ trans('lang.on_ride')}}</option>
                                        <option value="completed" >{{ trans('lang.completed')}}</option>
                                        <option value="rejected" >{{ trans('lang.rejected')}}</option>
                                        <option value="driver_rejected" >{{ trans('lang.driver_rejected')}}</option>
                                      </select>

                                      @elseif(isset($_GET['ride_status']) && $_GET['ride_status']!='')
                                      <input type="text" class="search form-control" name="search"
                                      id="search" style="display:none">
                                      <select id="ride_status" class="search form-control" name="ride_status" >
                                        <option @if($_GET['ride_status']=='confirmed')selected="selected"
                                        @endif  value="confirmed" >{{ trans('lang.confirmed')}}</option>

                                        <option @if($_GET['ride_status']=='new')selected="selected"
                                        @endif  value="new">{{ trans('lang.new')}}</option>

                                        <option @if($_GET['ride_status']=='on ride')selected="selected"
                                        @endif  value="on ride" >{{ trans('lang.on_ride')}}</option>

                                        <option @if($_GET['ride_status']=='completed')selected="selected"
                                        @endif  value="completed" >{{ trans('lang.completed')}}</option>

                                        <option @if($_GET['ride_status']=='rejected')selected="selected"
                                        @endif  value="rejected" >{{ trans('lang.rejected')}}</option>

                                        <option @if($_GET['ride_status']=='driver_rejected')selected="selected"
                                        @endif  value="driver_rejected" >{{ trans('lang.driver_rejected')}}</option>

                                      </select>

                                      @else
                                      <input type="text" class="search form-control" name="search"
                                      id="search">
                                      <select id="ride_status" class="search form-control"
                                      name="ride_status" style="display: none">
                                      <option value="confirmed" >{{ trans('lang.confirmed')}}</option>
                                      <option  value="new">{{ trans('lang.new')}}</option>

                                      <option value="on ride" >{{ trans('lang.on_ride')}}</option>
                                      <option value="completed" >{{ trans('lang.completed')}}</option>
                                      <option value="rejected" >{{ trans('lang.rejected')}}</option>
                                      <option value="driver_rejected" >{{ trans('lang.driver_rejected')}}</option>

                                    </select>
                                    @endif

                                    @if(isset($_GET['search_one']) &&  $_GET['search_one'] != '')
                                    <input type="text" class="search form-control" name="search_one"
                                    id="search_one" value="{{$_GET['search_one']}}" style="display: none">
                                    <select id="ride_type" class="form-control"
                                    name="ride_type" style="display: none">
                                    <option value="normal" >{{ trans('lang.normal')}}</option>
                                    <option  value="dispatcher">{{ trans('lang.dispatcher')}}</option>
                                    <option  value="driver_created">{{ trans('lang.created_driver')}}</option>

                                  </select>

                                  @elseif(isset($_GET['ride_type']) && $_GET['ride_type']!='')
                                  <input type="text" class="search form-control" name="search_one"
                                  id="search_one" style="display:none">
                                  <select id="ride_type" class="search form-control" name="ride_type" >
                                    <option @if($_GET['ride_type']=='normal')selected="selected"
                                    @endif  value="normal" >{{ trans('lang.normal')}}</option>

                                    <option @if($_GET['ride_type']=='dispatcher')selected="selected"
                                    @endif  value="dispatcher">{{ trans('lang.dispatcher')}}</option>
                                    <option @if($_GET['ride_type']=='driver_created')selected="selected"
                                    @endif  value="driver_created">{{ trans('lang.created_driver')}}</option>

                                  </select>

                                  @else
                                  <input type="text" class="search form-control" name="search_one"
                                  id="search_one"style="display: none">
                                  <select id="ride_type" class="search form-control"
                                  name="ride_type" style="display: none">
                                  <option value="normal" >{{ trans('lang.normal')}}</option>
                                  <option  value="dispatcher">{{ trans('lang.dispatcher')}}</option>
                                </select>
                                @endif



                                <button type="submit" class="btn-flat position-absolute"><i
                                  class="fa fa-search"></i></button>
                                </div>
                                <button onclick="searchtext();" class="btn btn-warning btn-flat">{{trans('lang.search')}}</button>
                                <a class="btn btn-warning btn-flat" href="{{url('rides/all')}}">Clear</a>

                              </form>

                            </div>
                          </label>

                        </div>


                      </div>

                      <div class="table-responsive m-t-10">

                        <table id="example24"
                        class="display nowrap table table-hover table-striped table-bordered table table-striped"
                        cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th class="delete-all"><input type="checkbox" id="is_active"><label
                              class="col-3 control-label" for="is_active"><a id="deleteAll"
                              class="do_not_delete"
                              href="javascript:void(0)"><i
                              class="fa fa-trash"></i> All</a></label></th>
                              <th>{{trans('lang.ride_id')}}</th>
                              <th>{{trans('lang.user_name')}}</th>
                              <th>{{trans('lang.driver_name')}}</th>
                              {{--<th>{{trans('lang.source_amount')}}</th>
                              <th>{{trans('lang.destination_address')}}</th>--}}
                              <th>{{trans('lang.cost_amount')}}</th>
                              <th>{{trans('lang.ride_type')}}</th>
                              <th>{{trans('lang.status')}}</th>

                              <th>{{trans('lang.created')}}</th>
                              <th>{{trans('lang.actions')}}</th>

                            </tr>
                          </thead>
                          <tbody id="append_list12">
                            @if(count($rides) > 0)
                            @foreach($rides as $ride)
                            <tr>
                              <td class="delete-all"><input type="checkbox"
                                id="is_open_{{$ride->id}}"
                                class="is_open"
                                dataid="{{$ride->id}}"><label
                                class="col-3 control-label"
                                for="is_open_{{$ride->id}}"></label></td>

                                <td><a href="{{route('ride.show', ['id' => $ride->id])}}">{{ $ride->id}}</a>
                                </td>
                                <td>
                                  @if($ride->user_id!=null)
                                  <a href="{{route('users.show', ['id' => $ride->user_id])}}">{{ $ride->userPrenom}} {{ $ride->userNom}}
                                  </a>
                                  @else
                                  @php 
                                  $userInfo=json_decode($ride->user_info,true); 
                                  @endphp
                                  {{ $userInfo ? $userInfo['name'] : ''}} 
                                  @endif
                                </td>
                                <td><a href="{{route('driver.show', ['id' => $ride->driver_id])}}">{{ $ride->driverPrenom}} {{ $ride->driverNom}}</a></td>
                                {{--  <td class="address-td">{{ $ride->depart_name}}</td>
                                <td class="address-td">{{ $ride->destination_name}}</td>--}}
                                <?php $montant=floatval($ride->montant);
                                $total_price =$montant;

                                $discount=$ride->discount;
                                if($discount)
                                {
                                  $total_price =$montant-$discount;
                                }
                                $tax=json_decode($ride->tax,true);
                                $totalTaxAmount=0;
                                if(!empty($tax)){
                                  for ($i = 0; $i < sizeof($tax); $i++) {
                                    $data = $tax[$i];
                                    if ($data['type'] == "Percentage") {
                                     $taxValue = (floatval($data['value']) * $total_price) / 100;
                                   }else{
                                    $taxValue = floatval($data['value']);

                                  }
                                  $totalTaxAmount += floatval(number_format($taxValue,$currency->decimal_digit));

                                }
                                $total_price=floatval($total_price)+$totalTaxAmount;
                              }
                              if($ride->tip_amount){
                                $total_price=floatval($total_price)+floatval($ride->tip_amount);
                              }

                              ?>
                              <td>
                                @if($currency->symbol_at_right=="true")
                                {{number_format(floatval($total_price),$currency->decimal_digit)."".$currency->symbole}}
                                @else
                                {{$currency->symbole."".number_format(floatval($total_price),$currency->decimal_digit)}}
                                @endif
                              </span>
                            </td>
                            <td>@if($ride->ride_type=="dispatcher")
                              {{ trans('lang.dispatcher')}}
                              @elseif($ride->ride_type=="driver")
                              {{trans('lang.created_driver')}}
                              @else
                              {{ trans('lang.normal')}}
                              @endif
                            </td>
                            <td>
                              @if($ride->statut=="completed")
                              <span class="badge badge-success">{{ $ride->statut }}<span>
                                @elseif($ride->statut == "confirmed")
                                <span class="badge badge-success">{{ $ride->statut }}<span>
                                  @elseif($ride->statut == "new")
                                  <span class="badge badge-primary">{{ $ride->statut }}<span>
                                    @elseif($ride->statut=="rejected")
                                    <span class="badge badge-danger">{{ $ride->statut }}<span>
                                      @elseif($ride->statut=="driver_rejected")
                                      <span class="badge badge-danger">{{trans("lang.driver_rejected")}}<span>        
                                        @else
                                        <span class="badge badge-warning">{{ $ride->statut }}<span>
                                          @endif
                                        </td>
                                        <td class="dt-time"><span class="date">{{ date('d F Y',strtotime($ride->creer))}}</span>
                                          <span class="time">{{ date('h:i A',strtotime($ride->creer))}}</span>

                                        </td>
                                        <td class="action-btn">
                                          <a href="{{route('ride.show', ['id' => $ride->id])}}" class=""
                                           data-toggle="tooltip" data-original-title="Details"><i
                                           class="fa fa-eye"></i></a>
                                           {{--
                                            @if($ride->statut=="completed" or $ride->statut=="on ride" or $ride->statut=="confirmed")
                                            @else
                                            <a id="'+val.id+'" class="do_not_delete" name="user-delete" href="{{route('ride.delete', ['id' => $ride->id])}}"><i class="fa fa-trash"></i></a>
                                            @endif
                                            --}}



                                            <a id="'+val.id+'"
                                            class="do_not_delete"
                                            name="user-delete"
                                            href="{{route('ride.delete', ['rideid' => $ride->id])}}"><i
                                            class="fa fa-trash"></i></a>
                                          </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr><td colspan="11" align="center">{{trans("lang.no_result")}}</td></tr>
                                        @endif
                                      </tbody>
                                    </table>

                                    <nav aria-label="Page navigation example" class="custom-pagination">
                                      <!-- {{ $rides->withQueryString()->links() }} -->
                                      {{$rides->appends(request()->query())->links()}}
                                    </nav>
                                    {{ $rides->withQueryString()->links('pagination.pagination') }}
                                  </div>
                                </div>

                              </div>

                            </div>

                          </div>

                        </div>

                      </div>

                    </div>
                  </div>

                  @endsection

                  @section('scripts')

                  <script type="text/javascript">
                    $("#is_active").click(function () {
                      $("#example24 .is_open").prop('checked', $(this).prop('checked'));

                    });

                    $("#deleteAll").click(function () {
                      if ($('#example24 .is_open:checked').length) {
                        
                        if (confirm('Are You Sure want to Delete Selected Data ?')) {
                          var arrayUsers = [];
                          $('#example24 .is_open:checked').each(function () {
                            var dataId = $(this).attr('dataId');
                            arrayUsers.push(dataId);

                          });

                          arrayUsers = JSON.stringify(arrayUsers);
                          var url = "{{url('ride/delete', 'rideid')}}";
                          url = url.replace('rideid', arrayUsers);

                          $(this).attr('href', url);
                        }
                      } else {
                        alert('Please Select Any One Record .');
                      }
                    });
                    
                    $(document).ready(function () {

                     if($('#selected_search').val()=="status"){
                      jQuery('#search_one').hide();
                      jQuery('#search').val('');
                    }else{
                      jQuery('#search_one').hide();
                      jQuery('#ride_status').val('');

                    }
                    if($('#selected_search').val()=="type"){
                      jQuery('#search').hide();
                      jQuery('#search_one').val('');
                    }else{
            //jQuery('#search').hide();
            jQuery('#ride_type').val('');

          }

        })
                    $(document.body).on('change', '#selected_search', function () {

                     if (jQuery(this).val() == 'status') {
                      jQuery('#search_one').hide();
                      jQuery('#ride_status').show();
                      jQuery('#ride_status').val('new');
                      jQuery('#search').val('');
                      jQuery('#search').hide();
                    } else {
                      jQuery('#search_one').hide();
                      jQuery('#ride_status').hide();
                      jQuery('#ride_status').val('');
                      jQuery('#search').show();

                    }

                    if (jQuery(this).val() == 'type') {
                      jQuery('#search').hide();
                      jQuery('#ride_type').show();
                      jQuery('#ride_type').val('normal');
                      jQuery('#search_one').val('');
                      jQuery('#search_one').hide();
                    } else {
            //jQuery('#search').hide();
            jQuery('#ride_type').hide();
            jQuery('#ride_type').val('');
              // jQuery('#search_one').show();

            }

          });
        </script>
        @endsection
