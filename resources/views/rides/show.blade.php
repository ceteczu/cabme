@extends('layouts.app')

@section('content')

<div class="page-wrapper ridedetail-page">

	<div class="row page-titles non-printable">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">{{trans('lang.ride_detail')}}</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item">
					<a href="{!! url('/dashboard') !!}">{{trans('lang.home')}}</a>
				</li>

				<li class="breadcrumb-item">
					<a href="{!! route('rides.all') !!}">{{trans('lang.all_rides')}}</a>
				</li>

				<li class="breadcrumb-item active">
					{{trans('lang.ride_detail')}}
				</li>

			</ol>

		</div>
	</div>

	<div class="container-fluid">

		<div class="row">

			<div class="col-12">

				<div class="card">
					<div class="card-body">

						{{-- <div class="row">

						<div class="col-12">

							<div class="box">
								<div class="box-header bb-2 border-primary">
									<h3 class="box-title">{{trans('lang.map_view')}}</h3>
					</div>
					<div class="box-body">
						<div id="map" style="height:300px">
						</div>
					</div>
				</div>
			</div>
		</div>--}}
		<div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
		<div class="col-md-12">
			<div class="print-top non-printable mt-3">
				<div class="text-right print-btn non-printable">
					<button type="button" class="fa fa-print non-printable" onclick="printDiv('printableArea')"></button>
				</div>
			</div>

			<hr class="non-printable">
		</div>

		<form method="post" action="{{ route('rides.update',$ride->id) }}" enctype="multipart/form-data">
			@csrf
			@method("PUT")
			<div class="order_detail printableArea" id="order_detail">
				<div class="order_detail-top mb-3 ">
					<div class="row">
						<div class="order_edit-genrl col-md-6">
							<div class="card">
								<div class="card-header bg-white">
									<h3>{{trans("lang.general_details")}}</h3>
								</div>
								<div class="card-body">
									<div class="order_detail-top-box">
										<div class="form-group row widt-100 gendetail-col">
											<label class="col-12 control-label"><strong>{{trans('lang.ride_id')}}
													: </strong><span id="ride_id">{{ $ride->id}}</span></label>
										</div>


										<div class="form-group row widt-100 gendetail-col">
											<label class="col-12 control-label"><strong>{{trans('lang.date_created')}}
													: </strong><span id="createdAt">{{ date('d F Y h:i A',strtotime($ride->creer))}}</span></label>
										</div>

										<div class="form-group row widt-100 gendetail-col payment_status">
											<label class="col-12 control-label"><strong>{{trans('lang.payment_status')}}
													: </strong>
												<span id="payment_status">

													@if ($ride->statut_paiement=="yes")
													<span class="badge badge-success py-2 px-3">Paid</span>
													@else
													<span class="badge badge-warning py-2 px-3">Not paid</span>
													@endif

												</span>
											</label>
										</div>

										<div class="form-group row widt-100 gendetail-col payment_method">
											<label class="col-12 control-label"><strong>{{trans('lang.payment_methods')}}
													: </strong>
												<span id="payment_method">

													@if($ride->image)
													<img class="rounded" style="width:70px" src="{{asset('/assets/images/payment_method/'.$ride->image)}}" alt="image">
													@endif
												</span>
											</label>

										</div>

										<div class="form-group row widt-100 gendetail-col payment_status">
											<label class="col-12 control-label"><strong>{{trans('lang.ride_distance')}}
													: </strong><span id="trip_objective">{{$ride->distance." ".$ride->distance_unit }}</span></label>
											</span>
											</label>
										</div>

										{{--<div class="form-group row widt-100 gendetail-col payment_status">
								<label class="col-12 control-label"><strong>{{trans('lang.trip_objective')}}
										: </strong><span id="trip_objective">{{$ride->trip_objective }}</span></label>
										</span>
										</label>


									</div>--}}
									<div class="form-group row widt-100 gendetail-col payment_status">
										<label class="col-12 control-label"><strong>{{trans('lang.how_many_passanger')}}
												: </strong><span id="no_passanger">{{ $ride->number_poeple}}</span></label>
										</span>
										</label>


									</div>
									<div class="form-group row widt-100 gendetail-col payment_status">
										<label class="col-12 control-label"><strong>{{trans('lang.any_childern')}}
												: </strong><span id="any_childern">
												@if(!empty($ride->age_children1) || !empty($ride->age_children2) || !empty($ride->age_children3))
												{{"Yes"}}
												@else{{"No"}}
												@endif</span></label>
									</div>
									@if(!empty($ride->age_children1) || !empty($ride->age_children2) || !empty($ride->age_children3))
									<div class="form-group row widt-100 gendetail-col payment_status">
										<label class="col-12 control-label"><strong>{{trans('lang.age_of_childern')}}
												: </strong><span id="age_children">{{$ride->age_children1}}
												{{!empty($ride->age_children2)? ','.$ride->age_children2 : ""}} {{!empty($ride->age_children3) ? ",".$ride->age_children3 :""}}</span></label>
										</span>
										</label>


									</div>
									@endif
									<div class="form-group row widt-100 gendetail-col payment_status">
										<label class="col-12 control-label"><strong>{{trans('lang.booked_by')}}
												: </strong>
											@if($ride->ride_type=="driver")
											<span id="age_children">Driver</span>
											@elseif($ride->ride_type=="dispatcher")
											<span id="age_children">dispatcher User
												@else
												<span id="age_children">Customer</span>@endif


											</span>
										</label>

									</div>

									<div class="form-group row width-100 ">
										<label class="col-3 control-label">{{trans('lang.ride_status')}}
											:</label>
										<div class="col-7">

											@php
											$status = ['new' => 'new', 'confirmed' => 'confirmed', 'on ride'
											=> 'on ride', 'completed' => 'completed', 'canceled' => 'canceled', 'rejected' => 'rejected']

											@endphp

											<select name="order_status" class="form-control">
												@foreach ($status as $key => $value)
												<option value="{{ $key }}" {{ ( $key == $ride->statut) ? 'selected' : '' }}> {{ $value }} </option>
												@endforeach

											</select>

										</div>
									</div>

								</div>

							</div>
						</div>
					</div>

					<div class="order_edit-genrl col-md-6">
						<div class="card">
							<div class="card-header bg-white">
								<h3>{{ trans('lang.billing_details')}}</h3>
							</div>
							<div class="card-body">
								<div class="address order_detail-top-box user-details">
									@php $userInfo=json_decode($ride->user_info,true) @endphp

									<p>
										<strong>{{trans("lang.name")}}: </strong>
										<span class="billing_name d-flex">
											@if(file_exists(public_path('assets/images/users'.'/'.$ride->photo_path)) && !empty($ride->photo_path))
											<span class="user-img"><img class="rounded" style="width:50px" src="{{asset('assets/images/users/'.$ride->photo_path)}}" alt="Image"></span>

											<span class="drove-det ml-2"><span class="drv-name">
													@if($ride->ride_type=="driver"){{!empty($userInfo) ? $userInfo['name'] : " "}}@else{{$ride->userPrenom}} {{$ride->userNom}}@endif </span>

												<br><span class="badge badge-warning text-white ml-auto"><i class="fa fa-star"></i>{{$userRating}}</span>

											</span>


											@else
											<span class="user-img"><img class="rounded" style="width:50px" src="{{asset('assets/images/placeholder_image.jpg')}}" alt="Image"></span>
											<span class="drove-det ml-2"><span class="drv-name">
													@if($ride->ride_type=="driver"){{!empty($userInfo) ? $userInfo['name'] : ''}}@else{{$ride->userPrenom}} {{$ride->userNom}}@endif </span>
												<br><span class="badge badge-warning text-white ml-auto"><i class="fa fa-star"></i>{{$userRating}}</span>

												@endif

											</span>

									</p>

									<p><strong>{{trans("lang.email")}}:</strong>
										<span id="billing_email">@if($ride->ride_type=="driver"){{!empty($userInfo) ? $userInfo['email'] : ''}}@else{{$ride->user_email}}@endif</span>
									</p>
									<p><strong>{{trans("lang.phone")}}:</strong>
										<span id="billing_phone">@if($ride->ride_type=="driver"){{!empty($userInfo) ? $userInfo['phone'] : '' }}@else{{$ride->user_phone}}@endif</span>
									</p>
								</div>
							</div>
						</div>
						<div class="card non-printable">
							<div class="card-body">
								<div class="row">

									<div class="col-12">

										<div class="box">
											<div class="box-header bb-2 border-primary">
												<h3 class="box-title">{{trans('lang.map_view')}}</h3>
											</div>
											<div class="box-body">
												<div id="map" style="height:300px">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>


			<div class="order-deta-btm mt-4">
				<div class="row">
					<div class="col-md-7 order-deta-btm-left">
						<div class="card">
							<div class="box card-body p-0">
								<div class="box-header bb-2 card-header bg-white">
									<h3 class="box-title">{{trans("lang.location_details")}}</h3>
								</div>
								<div class="card-body">
									<div class="live-tracking-list">
										<div class="live-tracking-box track-from">


											<div class="live-tracking-inner">
												<div class="location-ride">

													<div class="from-ride">{{$ride->depart_name}}</div>

													<div class="to-ride">{{$ride->destination_name}}</div>

												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="order_addre-edit ">
								<div class="card-header bg-white">
									<h3>{{trans("lang.price_details")}}</h3>
								</div>
								<div class="card-body price_detail">
									<div class="order-deta-btm-right">
										<div class="order-totals-items pt-0">
											<div class="row">
												<div class="col-md-12 ml-auto">
													<div class="table-responsive bk-summary-table">
														<table class="order-totals">

															<tbody id="order_products_total">
																@if(!empty($ride->transaction_id))
																<tr class="transaction_id_48fc3f15-66f1-45a7-b4b8-123563426fe4">
																	<td class="label">
																		<strong>{{trans("lang.transaction_id")}}</strong>
																	</td>
																	<td>
																		<strong>{{$ride->transaction_id}}</strong>
																	</td>
																</tr>
																@endif
																<tr>
																	<td class="seprater" colspan="2">
																		<hr>
																		<span>{{trans("lang.sub_total")}}</span>
																	</td>
																</tr>

																<tr class="final-rate">
																	<td class="label">{{trans("lang.sub_total")}}</td>
																	<td>
																		@if($currency->symbol_at_right=="true")
																		{{number_format(floatval($ride->montant),$currency->decimal_digit)."".$currency->symbole}}
																		@else
																		{{$currency->symbole."".number_format(floatval($ride->montant),$currency->decimal_digit)}}
																		@endif
																	</td>
																</tr>
																@if($ride->discount > 0)
																<tr>
																	<td class="seprater" colspan="2">
																		<hr>
																		<span>{{trans("lang.discount")}}</span>
																	</td>
																</tr>

																<tr>
																	<td class="label">{{trans("lang.discount")}}</td>
																	<td>
																		<span style="color:red">
																			@if($currency->symbol_at_right=="true")
																			(- {{number_format(floatval($ride->discount),$currency->decimal_digit)."".$currency->symbole}})
																			@else
																			(-{{$currency->symbole."".number_format(floatval($ride->discount),$currency->decimal_digit)}})
																			@endif
																		</span>
																	</td>
																</tr>
																@endif
																@if(!empty($taxHtml))
																<tr>
																	<td class="seprater" colspan="2">
																		<hr>
																		<span>{{trans("lang.tax_calculation")}}</span>
																	</td>
																</tr>

																{!! $taxHtml !!}
																@endif
																@if($ride->tip_amount > 0)
																<tr>
																	<td class="seprater" colspan="2">
																		<hr>
																		<span>{{trans("lang.tip")}}</span>
																	</td>
																</tr>

																<tr>
																	<td class="label">{{trans("lang.tip_amount")}}</td>
																	<td>
																		@if($currency->symbol_at_right=="true")
																		{{number_format(floatval($ride->tip_amount),$currency->decimal_digit)."".$currency->symbole}}
																		@else
																		{{$currency->symbole."".number_format(floatval($ride->tip_amount),$currency->decimal_digit)}}
																		@endif
																	</td>
																</tr>
																@endif
																<tr>
																	<td class="seprater" colspan="2">
																		<hr>
																	</td>
																</tr>

																<tr class="grand-total">
																	<td class="label">{{trans("lang.total_amount")}}</td>
																	<td class="total_price_val">
																		@if($currency->symbol_at_right=="true")
																		{{number_format(floatval($totalAmount),$currency->decimal_digit)."".$currency->symbole}}
																		@else
																		{{$currency->symbole."".number_format(floatval($totalAmount),$currency->decimal_digit)}}
																		@endif
																	</td>
																</tr>
																@if($ride->admin_commission != '')
																<tr>
																	<td class="label">
																		<small> {{trans("lang.admin_commission")}} </small>
																	</td>
																	<td class="adminCommission_val">
																		<small>
																			<span style="color:red">
																				@if($currency->symbol_at_right=="true")
																				({{number_format(floatval($ride->admin_commission),$currency->decimal_digit)."".$currency->symbole}})

																				@else
																				( {{$currency->symbole."".number_format(floatval($ride->admin_commission),$currency->decimal_digit)}})

																				@endif
																			</span>
																		</small>
																	</td>
																</tr>
																@endif

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

					<div class="col-md-5 order-deta-btm-right">
						<div class="resturant-detail">
							<div class="card">
								<div class="card-header bg-white">
									<h3 class="box-title">{{trans('lang.driver_detail')}}</h3>
								</div>

								<div class="card-body">
									<a href="#" class="row redirecttopage" id="resturant-view">
										<div class="col-4">
											@if (file_exists(public_path('assets/images/drivers'.'/'.$ride->driver_photo)) && !empty($ride->driver_photo))
											<span id="billing_name" class="d-flex"><span class="user-img"><img class="rounded" style="width:50px" src="{{asset('assets/images/drivers/'.$ride->driver_photo)}}" alt="Image"></span>
												@else
												<span id="billing_name" class="d-flex"><span class="user-img"><img class="rounded" style="width:50px" src="{{asset('assets/images/placeholder_image.jpg')}}" alt="Image"></span>
													@endif
										</div>
										<div class="col-8">
											<h4 class="vendor-title">{{$ride->driverPrenom}} {{$ride->driverNom}}</h4>
											<span class="badge badge-warning text-white ml-auto"><i class="fa fa-star"></i>{{$driverRating}}</span>
										</div>
									</a>

									<h5 class="contact-info">{{trans('lang.contact_info')}}
										:</h5>
									<p><strong>{{trans('lang.email')}}:</strong>
										<span id="vendor_email">{{$ride->driver_email}}</span>
									</p>
									<p><strong>{{trans('lang.phone')}}:</strong>
										<span id="vendor_phone">{{$ride->driver_phone}}</span>
									</p>

									<h5 class="contact-info">{{trans('lang.car_info')}}
										:</h5>

									<p>
										<strong style="width:auto !important;">{{trans('lang.brand')}}
											:</strong>
										<span id="driver_carName">{{$ride->brand}}</span>
									</p>
									<p>
										<strong style="width:auto !important;">{{trans('lang.car_number')}}
											:</strong>
										<span id="driver_carNumber">{{$ride->numberplate}}</span>
									</p>
									<p>
										<strong style="width:auto !important;">{{trans('lang.car_model')}}
											:</strong>
										<span id="driver_carNumber">{{$ride->model}}</span>
									</p>

									<p>
										<strong style="width:auto !important;">{{trans('lang.car_make')}}
											:</strong>
										<span id="driver_car_make">{{$ride->car_make}}</span>
									</p>

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-white">
					<h3 class="box-title">{{trans('lang.ride_customer_review')}}</h3>
				</div>
				<div class="card-body">
					<p> @if($customer_review->isEmpty())
						 {{trans("lang.no_review_found")}}
						@else
						@foreach($customer_review as $review)
                           <div class="d-inline-block d-flex">                                                     
                            {{$review->comment }} 
                               <div class="ml-auto">
                                <ul class="rating" data-rating="{{$review->niveau}}">
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                </ul>
                                                                
                              </div>
                           </div> 
                         @endforeach						
						@endif
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-white">
					<h3 class="box-title">{{trans('lang.ride_driver_review')}}</h3>
				</div>
				<div class="card-body">
					<p class="text-center">@if($driver_review->isEmpty())
						{{trans('lang.no_review_found')}}
						@else
						@foreach($driver_review as $review)
                           <div class="d-inline-block d-flex">                                                     
                            {{$review->comment }} 
                               <div class="ml-auto">
                                <ul class="rating" data-rating="{{$review->niveau_driver}}">
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                <li class="rating__item"></li>
                                </ul>
                                                                
                              </div>
                           </div> 
                         @endforeach						
						@endif
					</p>
				</div>
			</div>
		</div>


	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="order_addre-edit ">
				<div class="card-header bg-white">
					<h3 class="box-title">{{trans('lang.complaints')}}</h3>
				</div>
					<div class="card-body price_detail">
						<div class="order-deta-btm-right">
							<div class="order-totals-items pt-0">
								<div class="row">
									<div class="col-md-12 ml-auto">
										<div class="table-responsive bk-summary-table">
											<table class="order-totals complaint-table">

												<tbody id="order_products_total">
													
													@if($complaints->count() == 0)
													
														<p class=" text-center">{{trans("lang.no_complaint_found")}}</p>
														
													
													@else

													@foreach($complaints as $complaint)
													<tr>
														<td class="seprater" colspan="2">
															<hr>
															<span>{{trans("lang.by")}} {{ $complaint->user_type }}</span>
														</td>
													</tr>
													
													<tr>
														<td class="label">{{trans("lang.title")}}</td>
														<td>
														{{ $complaint->title }}
														</td>
													</tr>
													<tr>
														<td class="label">{{trans("lang.message")}}</td>
														<td>
														{{ $complaint->description }}
														</td>
													</tr>
													@endforeach
													
													@endif
													

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>


						</div>


						<!--  </div> -->
					</div>
				</div>
			</div>
		</div>
			


						<div class="form-group col-12 text-center btm-btn non-printable">
							<button type="submit" class="btn btn-primary save_order_btn"><i class="fa fa-save"></i> {{trans('lang.save')}}</button>
							<a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>

						</div>

						</form>
					</div>
					</div>
					</div>
		</div>
	</div>
</div>


@endsection
@section('scripts')

<script type="text/javascript">
	var map;
	var marker;


	var myLatlng = new google.maps.LatLng({
		!!$ride - > latitude_arrivee!!
	}, {
		!!$ride - > longitude_arrivee!!
	});
	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();

	var mapOptions = {
		zoom: 10,
		center: myLatlng,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("map"), mapOptions);

	marker = new google.maps.Marker({
		map: map,
		position: myLatlng,
		draggable: true
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent('{!! $ride->destination_name !!}');
		infowindow.open(map, marker);
	});

	//Set direction route
	let directionsService = new google.maps.DirectionsService();
	let directionsRenderer = new google.maps.DirectionsRenderer();

	directionsRenderer.setMap(map);

	const origin = {
		lat: {
			!!$ride - > latitude_depart!!
		},
		lng: {
			!!$ride - > longitude_depart!!
		}
	};
	const destination = {
		lat: {
			!!$ride - > latitude_arrivee!!
		},
		lng: {
			!!$ride - > longitude_arrivee!!
		}
	};

	const route = {
		origin: origin,
		destination: destination,
		travelMode: 'DRIVING'
	}

	directionsService.route(route, function(response, status) {
		if (status !== 'OK') {
			window.alert('Directions request failed due to ' + status);
			return;
		} else {
			directionsRenderer.setDirections(response);
			var directionsData = response.routes[0].legs[0];
		}
	});

	function printDiv(divName) {
		var css = '@page { size: portrait; }',
			head = document.head || document.getElementsByTagName('head')[0],
			style = document.createElement('style');
		style.type = 'text/css';
		style.media = 'print';

		if (style.styleSheet) {
			style.styleSheet.cssText = css;
		} else {
			style.appendChild(document.createTextNode(css));
		}

		head.appendChild(style);

		var printContents = document.getElementsByClassName(divName).html;
		window.print();

	}
</script>

@endsection