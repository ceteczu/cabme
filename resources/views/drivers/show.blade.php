@extends('layouts.app')

@section('content')

<div class="page-wrapper userdetail-page">

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">Driver Detail</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="{!! url('/dashboard') !!}">Dashboard</a></li>

				<li class="breadcrumb-item"><a href="{!! url('drivers') !!}">Drivers</a></li>

				<li class="breadcrumb-item active">Driver Detail</li>

			</ol>

		</div>

	</div>

	<div class="container-fluid">

		<div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body p-0 pb-5">

						<div class="user-top">

							<div class="row align-items-center">

								<div class="user-profile col-md-2">

									<div class="profile-img">

										@if (file_exists(public_path('assets/images/driver'.'/'.$driver->photo_path)) &&
										!empty($driver->photo_path))
										<td><img class="profile-pic"
												src="{{asset('assets/images/driver').'/'.$driver->photo_path}}"
												alt="image"></td>
										@else
										<td><img class="profile-pic"
												src="{{asset('assets/images/placeholder_image.jpg')}}" alt="image"></td>

										@endif
									</div>

								</div>
								<div class="user-title col-md-7">
									<h4 class="card-title"> Details of {{$driver->prenom}} {{$driver->nom}}</h4>
								</div>
								<div class="col-md-3">
									<a href="javascript:void(0)" data-toggle="modal" data-target="#addWalletModal"
										class="text-white add-wallate btn btn-success"><i class="fa fa-plus"></i> Add
										Wallet Amount</a>
								</div>

							</div>
						</div>


						<div class="user-detail" role="tabpanel">

							<!-- Nav tabs -->
							<ul class="nav nav-tabs">

								<li role="presentation" class="">
									<a href="#information" aria-controls="information" role="tab" data-toggle="tab"
										class="{{ (Request::get('tab') == 'information' || Request::get('tab') == '') ? 'active show' : '' }}">Information</a>
								</li>

								<li role="presentation" class="">
									<a href="#rides" aria-controls="rides" role="tab" data-toggle="tab"
										class="{{ (Request::get('tab') == 'rides') ? 'active show' : '' }}">Rides</a>
								</li>
								<li role="presentation" class="">
									<a href="#parcels" aria-controls="parcels" role="tab" data-toggle="tab"
										class="{{ (Request::get('tab') == 'parcels') ? 'active show' : '' }}">{{trans('lang.parcel')}}</a>
								</li>

								<li role="presentation" class="">
									<a href="#vehicle" aria-controls="vehicle" role="tab" data-toggle="tab"
										class="{{ (Request::get('tab') == 'vehicle') ? 'active show' : '' }}">Vehicle</a>
								</li>

								<li role="presentation" class="">
									<a href="#transaction" aria-controls="transaction" role="tab" data-toggle="tab"
										class="{{ (Request::get('tab') == 'transaction') ? 'active show' : '' }}">Wallet
										Transaction</a>
								</li>

							</ul>

							<!-- Tab panes -->
							<div class="tab-content">

								<div role="tabpanel"
									class="tab-pane {{ (Request::get('tab') == 'information' || Request::get('tab') == '') ? 'active' : '' }}"
									id="information">

									<div class="row">

										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.user_phone')}}:</label>
												<span>{{ $driver->phone}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.email')}}:</label>
												<span>{{ $driver->email}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.bank_name')}}:</label>
												<span>{{ $driver->bank_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.branch_name')}}:</label>
												<span>{{ $driver->branch_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.status')}}
													:</label>
												@if($driver->statut=="yes")
												<span class="badge badge-success">Enabled</span>
												@else
												<span class="badge badge-warning">Disabled</span>
												@endif
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.holder_name')}}:</label>
												<span>{{ $driver->holder_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.account_no')}}
													:</label>
												<span>{{$driver->account_no}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.ifsc_code')}}
													:</label>
												<span>{{$driver->ifsc_code}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.Other_info')}}
													:</label>
												<span>{{$driver->other_info}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.created_at')}}
													:</label>
												<span class="date">{{ date('d F Y',strtotime($driver->creer))}}</span>
												<span class="time">{{ date('h:i A',strtotime($driver->creer))}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.edited')}}
													:</label>
												@if($driver->modifier!='0000-00-00 00:00:00')
												<span class="date">{{ date('d F
													Y',strtotime($driver->modifier))}}</span>
												<span class="time">{{ date('h:i
													A',strtotime($driver->modifier))}}</span>
												@endif
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.wallet_balance')}}
													:</label>
												<span>
													@if($currency->symbol_at_right=="true")
													@if(substr($driver->amount,0,1)=="-")
													<span
														style="color:red">-{{number_format(floatval(substr($driver->amount,1)),$currency->decimal_digit)."".$currency->symbole
														}}</span>
													@else
													<span
														style="color:green">{{number_format(floatval($driver->amount),$currency->decimal_digit)."".$currency->symbole
														}}</span>
													@endif
													@else
													@if(substr($driver->amount,0,1)=="-")
													<span style="color:red">-{{
														$currency->symbole."".number_format(floatval(substr($driver->amount,1)),$currency->decimal_digit)
														}}</span>
													@else
													<span style="color:green">{{
														$currency->symbole."".number_format(floatval($driver->amount),$currency->decimal_digit)
														}}</span>
													@endif
													@endif
												</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.rating')}}
													:</label>
												<span><i class="fa fa-star" style="color:yellow"></i> {{$driverRating}}
												</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group-btn">
												@if ($driver->statut=="no")
												<a href="{{route('driver.changeStatus', ['id' => $driver->id])}}"
													class="btn btn-success btn-sm" data-toggle="tooltip"
													data-original-title="Activate">{{trans('lang.enable_account')}}<i
														class="fa fa-check"></i> </a>
												@else
												<a href="{{route('driver.changeStatus', ['id' => $driver->id])}}"
													class="btn btn-warning btn-sm" data-toggle="tooltip"
													data-original-title="Activate"> Disable account <i
														class="fa fa-check"></i> </a>
												@endif
											</div>
										</div>



									</div>

								</div>

								<div role="tabpanel"
									class="tab-pane {{ Request::get('tab') == 'rides' ? 'active' : '' }}" id="rides">
									@if(count($rides) > 0)
									<div class="table-responsive">
										<table
											class="display nowrap table table-hover table-striped table-bordered table table-striped">
											<thead>
												<tr>
													<th>{{trans('lang.ride_id')}}</th>
													<th>{{trans('lang.driver_name')}}</th>
													<th>{{trans('lang.ride_type')}}</th>
													<!-- <th >{{trans('lang.depart')}}</th>
			                                        <th >{{trans('lang.destination')}}</th> -->
													<th>{{trans('lang.status')}}</th>
													<th>{{trans('lang.created')}}</th>
													<th>{{trans('lang.actions')}}</th>
												</tr>
											</thead>
											<tbody id="append_list12">
												@foreach($rides as $ride)
												<tr>
													<td><a href="{{route('ride.show', ['id' => $ride->id])}}">{{
															$ride->id}}</a></td>
													<td><a href="{{route('driver.show', ['id' => $ride->driver_id])}}">{{
															$ride->driverPrenom}} {{ $ride->driverNom}}</a></td>
													<td>@if($ride->ride_type=="dispatcher")
														{{ trans('lang.dispatcher')}}
														@else
														{{ trans('lang.normal')}}
														@endif
													</td>
													<!-- <td>{{ $ride->depart_name}}</td>
			                                        <td>{{ $ride->destination_name}}</td> -->
													<td>
														@if($ride->statut=="completed")
														<span class="badge badge-success">{{ $ride->statut }}<span>
																@elseif($ride->statut=="rejected")
																<span class="badge badge-danger">{{ $ride->statut
																	}}<span>
																		@else
																		<span class="badge badge-warning">{{
																			$ride->statut }}<span>
																				@endif
													</td>
													<td>{{ date('d F Y h:i A',strtotime($ride->creer))}}</td>
													<td class="action-btn">
														<a href="{{route('ride.show', ['id' => $ride->id])}}" class=""
															data-toggle="tooltip" data-original-title="Details"><i
																class="fa fa-ellipsis-h"></i></a>
														<a id="'+val.id+'" class="do_not_delete" name="user-delete"
															href="{{route('ride.delete', ['rideid' => $ride->id])}}"><i
																class="fa fa-trash"></i></a>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<nav aria-label="Page navigation example" class="custom-pagination">
											{{ $rides->appends(['tab'=>'rides'])->links() }}

										</nav>
										{{ $rides->appends(['tab'=>'rides'])->links('pagination.pagination') }}

									</div>
									@else
									<p>
										<center>No results found.</center>
									</p>
									@endif
								</div>
								<div role="tabpanel"
									class="tab-pane {{ Request::get('tab') == 'parcels' ? 'active' : '' }}"
									id="parcels">
									@if(count($parcelOrders) > 0)
									<div class="table-responsive">
										<table
											class="display nowrap table table-hover table-striped table-bordered table table-striped">
											<thead>
												<tr>
													<th>{{trans('lang.parcel_id')}}</th>
													<th>{{trans('lang.userName')}}</th>
													<th>{{trans('lang.status')}}</th>
													<th>{{trans('lang.created')}}</th>
													<th>{{trans('lang.actions')}}</th>
												</tr>
											</thead>
											<tbody id="append_list12">
												@foreach($parcelOrders as $parcel)
												<tr>
													<td><a href="{{route('parcel.show', ['id' => $parcel->id])}}">{{
															$parcel->id}}</a></td>
													<td><a href="{{route('users.show', ['id' => $parcel->user_id])}}">{{
															$parcel->userPrenom}} {{
															$parcel->userNom}}</a></td>
													<td>
														@if($parcel->status=="completed")
														<span class="badge badge-success">{{ $parcel->status }}<span>
																@elseif($parcel->status == "confirmed")
																<span class="badge badge-success">{{ $parcel->status
																	}}<span>
																		@elseif($parcel->status == "new")
																		<span class="badge badge-primary">{{
																			$parcel->status }}<span>
																				@elseif($parcel->status=="rejected")
																				<span class="badge badge-danger">{{
																					$parcel->status }}<span>
																						@elseif($parcel->status=="driver_rejected")
																						<span
																							class="badge badge-danger">{{trans("lang.driver_rejected")}}<span>
																								@else
																								<span
																									class="badge badge-warning">{{
																									$parcel->status
																									}}<span>
																										@endif
													</td>
													<td>{{ date('d F Y h:i A',strtotime($parcel->created_at))}}</td>
													<td class="action-btn">
														<a href="{{route('parcel.show', ['id' => $parcel->id])}}"
															class="" data-toggle="tooltip"
															data-original-title="Details"><i
																class="fa fa-ellipsis-h"></i></a>
														<a id="'+val.id+'" class="do_not_delete" name="user-delete"
															href="{{route('parcel.delete', ['rideid' => $parcel->id])}}"><i
																class="fa fa-trash"></i></a>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<nav aria-label="Page navigation example" class="custom-pagination">
											{{ $parcelOrders->appends(['tab'=>'parcels'])->links() }}

										</nav>
										{{
										$parcelOrders->appends(['tab'=>'parcels'])->links('pagination.pagination')
										}}

									</div>
									@else
									<p>
										<center>No results found.</center>
									</p>
									@endif
								</div>

								<div role="tabpanel"
									class="tab-pane {{ Request::get('tab') == 'vehicle' ? 'active' : ''}}" id="vehicle">

									<div class="row">
										@if($vehicle)
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.brand')}}:</label>

												<span>{{ $vehicle->brand}}</span>


											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.vehicle_model')}}:</label>

												<span>{{ $vehicle->model}}</span>

											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.car_number')}}:</label>
												<span>{{ $vehicle->numberplate}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.number_of_pessanger')}}:</label>
												<span>{{ $vehicle->passenger}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.vehicle_color')}}:</label>
												<span>{{ $vehicle->color}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.vehicle_milage')}}:</label>
												<span>{{ $vehicle->milage}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for=""
													class="font-weight-bold">{{trans('lang.vehicle_km')}}:</label>
												<span>{{ $vehicle->km}}</span>
											</div>
										</div>
										@endif
										{{--<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.status')}}
													:</label>
												@if($vehicle->statut=="yes")
												<span class="badge badge-success">Enabled</span>
												@else
												<span class="badge badge-warning">Disabled</span>
												@endif
											</div>
										</div>--}}

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.created_at')}}
													:</label>
												<span class="date">{{ date('d F Y',strtotime($driver->creer))}}</span>
												<span class="time">{{ date('h:i A',strtotime($driver->creer))}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.edited')}}
													:</label>
												@if($driver->modifier!='0000-00-00 00:00:00')
												<span class="date">{{ date('d F
													Y',strtotime($driver->modifier))}}</span>
												<span class="time">{{ date('h:i
													A',strtotime($driver->modifier))}}</span>
												@endif
											</div>
										</div>

									</div>

								</div>

								<div role="tabpanel"
									class="tab-pane {{ Request::get('tab') == 'transaction' ? 'active' : '' }}"
									id="transaction">
									@if(count($transactions) > 0)
									<div class="table-responsive">
										<table
											class="display nowrap table table-hover table-striped table-bordered table table-striped">
											<thead>
												<tr>
													<th>{{trans('lang.transaction_id')}}</th>
													<th>{{trans('lang.amount')}}</th>
													<th>{{trans('lang.date')}}</th>
													<th>{{trans('lang.payment_method')}}</th>
													<th>{{trans('lang.status')}}</th>
												</tr>
											</thead>
											<tbody id="append_list12">
												@foreach($transactions as $transaction)
												<tr>
													<td>{{ $transaction->id}}</td>
													<td>
														@if($currency->symbol_at_right=="true")
														@if(substr($transaction->amount,0,1)=="-")
														<span
															style="color:red">(-{{number_format(floatval(substr($transaction->amount,1)),$currency->decimal_digit)."".$currency->symbole
															}})</span>
														@else
														<span
															style="color:green">{{number_format(floatval($transaction->amount),$currency->decimal_digit)."".$currency->symbole
															}}</span>
														@endif
														@else
														@if(substr($transaction->amount,0,1)=="-")
														<span style="color:red">(-{{
															$currency->symbole."".number_format(floatval(substr($transaction->amount,1)),$currency->decimal_digit)
															}})</span>
														@else
														<span style="color:green">{{
															$currency->symbole."".number_format(floatval($transaction->amount),$currency->decimal_digit)
															}}</span>
														@endif

														@endif
													</td>
													<td>{{ date('d F Y h:i A',strtotime($transaction->creer))}}</td>

													@if($transaction->image)
													<td><img class="rounded" style="width:50px"
															src="{{asset('/assets/images/payment_method/'.$transaction->image)}}"
															alt="image"></td>
													@else
													<td>{{ $transaction->payment_method}}"</td>
													@endif

													<td>
														<span
															class="badge badge-success">{{trans("lang.success")}}<span>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<nav aria-label="Page navigation example" class="custom-pagination">
											{{ $transactions->appends(['tab'=>'transaction'])->links() }}
										</nav>
									</div>
									@else
									<p>
										<center>No results found.</center>
									</p>
									@endif
								</div>



							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addWalletModal" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered location_modal">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title locationModalTitle">{{trans('lang.add_wallet_amount')}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>

			<div class="modal-body">

				<form action="{{route('driver.wallet',$driver->id)}}" method="post" class="">
					@csrf

					<div class="form-row">

						<div class="form-group row">

							<div class="form-group row width-100">
								<label class="col-12 control-label">{{
									trans('lang.amount')}}</label>
								<div class="col-12">
									<input type="number" name="amount" class="form-control" id="amount"
										placeholder="Enter Amount">
									<div id="wallet_error" style="color:red"></div>
								</div>
							</div>

						</div>

					</div>


					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="add-wallet-btn">{{trans('submit')}}</a>
						</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
							{{trans('close')}}</a>
						</button>

					</div>
				</form>


			</div>
		</div>

	</div>

</div>

@endsection

@section('scripts')
<script>
	$("#add-wallet-btn").click(function () {
		var amount = $('#amount').val();
		if (amount == '') {
			$('#wallet_error').text('{{trans("lang.add_wallet_amount_error")}}');
			return false;
		}

	});
</script>

@endsection