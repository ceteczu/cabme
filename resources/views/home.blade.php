@extends('layouts.app')

@section('content')

<div id="main-wrapper" class="page-wrapper">

    <!-- start container-->

    <div class="container-fluid">

        <!-- start row -->
        <div class="card mb-3 mt-4 business-analytics">
            <div class="card-body">
                <div class="row trip-info total top">

                    <!-- column -->
                    <div class="col-lg-12">
                        <h3 class="card-title">{{trans('lang.dashboard_totals_trip')}}</h3>
                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                            <a href="{{ route('users') }}">
                                <div class="card-body d-flex icon-blue">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 users_count" id="users_count">{{ $total_users }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_users')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-account-multiple"></i>

                                    </div>

                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                            <a href="{{ route('drivers') }}">
                                <div class="card-body d-flex icon-red">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 driver_count" id="driver_count">{{ $total_drivers }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_drivers')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-car"></i>

                                    </div>

                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                                <div class="card-body d-flex icon-orange">


                                    <div class="card-left">
                                    <a href="{{ route('rides.completed')}}">

                                        <h3 class="m-b-0 text-dark font-medium mb-2 total_earning" id="">

                                            @if($currency->symbol_at_right=="true")
                                            {{ number_format($total_earnings,$currency->decimal_digit)." ".$currency->symbole }}
                                            @else
                                            {{ $currency->symbole." ".number_format($total_earnings,$currency->decimal_digit) }}
                                            @endif
                                        </h3>
                                        </a>
                                        <a href="{{ route('parcel.completed') }}">
                                        <h6 id="earnings_count_today_intercity">{{ trans('lang.dashboard_parcel_total_earnings') }}
                                            @if($currency->symbol_at_right=="true")
                                            {{ number_format($total_parcel_earnings,$currency->decimal_digit)." ".$currency->symbole }}
                                            @else
                                            {{ $currency->symbole." ".number_format($total_parcel_earnings,$currency->decimal_digit) }}
                                            @endif
                                        </h6>
                                        </a>
                                        <input type="number" value="{{$total_earnings}}" id="total_earning" hidden />
                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_earnings')}}</h5>




                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-wallet"></i>

                                    </div>

                                </div>
                           
                        </div>

                    </div>
                    <div class="col-lg-4">

                        <div class="card">
                            
                                <div class="card-body d-flex icon-orange">

                                    <div class="card-left">
                                    <a href="{{ route('rides.completed') }}">
                                        <h3 class="m-b-0 text-dark font-medium mb-2 admin_commission" id="">

                                            @if($currency->symbol_at_right=="true")
                                            {{ number_format($total_admin_commission,$currency->decimal_digit)." ".$currency->symbole }}

                                            @else
                                            {{ $currency->symbole." ".number_format($total_admin_commission,$currency->decimal_digit) }}
                                            @endif
                                        </h3>
                                    </a>
                                        <a href="{{ route('parcel.completed') }}">
                                        <h6 id="parcel_admin_commission">{{ trans('lang.dashboard_parcel_total_earnings') }}
                                            @if($currency->symbol_at_right=="true")
                                            {{ number_format($total_parcel_admin_commission,$currency->decimal_digit)." ".$currency->symbole }}
                                            @else
                                            {{ $currency->symbole." ".number_format($total_parcel_admin_commission,$currency->decimal_digit) }}
                                            @endif
                                        </h6>
                                        </a>
                                        <input type="number" value="{{$total_admin_commission}}" id="admin_commission" hidden />
                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_admin_commission')}}</h5>



                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-wallet"></i>

                                    </div>

                                </div>
                            
                        </div>

                    </div>

                </div>
                <!-- start row -->
                <div class="row trip-info total bottom">

                    <!-- column -->
                    <div class="col-lg-12 col-md-12">

                        <div class="row">

                            <div class="col-md-3">

                                <div class="card">
                                    <div class="card-body d-flex card-blue icon-white">

                                        <div class="card-left">
                                            <a href="{{ route('rides.completed') }}">

                                                <h2 class="m-b-0 text-white font-medium">{{ $completed_rides }}</h2>
                                            </a>
                                            <a href="{{ route('parcel.completed') }}">

                                                <h6 class="m-b-0 text-white font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $completed_parcel_rides }}</h2>
                                            </a>

                                            <h5 class="m-b-0 text-white small">{{trans('lang.dashboard_completed_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto">

                                            <i class="mdi mdi-calendar-check"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card">
                                    <div class="card-body d-flex card-graph icon-red">

                                        <div class="card-left">
                                            <a href="{{ route('rides.confirmed') }}">

                                                <h3 class="m-b-0 text-dark font-medium">{{ $confirmed_rides }}</h3>
                                            </a>
                                            <a href="{{ route('parcel.confirmed') }}">

                                                <h6 class="m-b-0 text-dark font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $confirmed_parcel_rides }}</h2>
                                            </a>

                                            <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_confirmed_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto">

                                            <i class="mdi mdi-car-connected"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card">

                                    <div class="card-body d-flex card-red icon-white">

                                        <div class="card-left">
                                            <a href="{{ route('rides.rejected') }}">
                                                <h2 class="m-b-0 text-white font-medium" id="users_count">{{ $canceled_rides }}</h2>

                                            </a>
                                            <a href="{{ route('parcel.rejected') }}">
                                                <h6 class="m-b-0 text-white font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $canceled_parcel_rides }}</h2>
                                            </a>
                                            <h5 class="m-b-0 text-white small">{{trans('lang.dashboard_cancelled_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto position-relative over-icon-box">

                                            <i class="mdi mdi-car"></i>
                                            <i class="mdi mdi-close position-absolute over-icon"></i>

                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->

        <!-- start row -->
        <div class="card mb-3 mt-4 business-analytics">

            <div class="card-body">

                <div class="row trip-info today top">

                    <!-- column -->
                    <div class="col-lg-12">
                        <h3 class="card-title">{{trans('lang.dashboard_today_trip')}}</h3>
                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                            <a href="{{ route('users') }}">
                                <div class="card-body d-flex icon-blue">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2">{{ $today_users }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_today_users')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-account-multiple-plus"></i>

                                    </div>

                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                            <a href="{{ route('drivers') }}">
                                <div class="card-body d-flex icon-red">

                                    <div class="card-left">

                                        <h3 class="m-b-0 text-dark font-medium mb-2">{{ $today_drivers }}</h3>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_today_drivers')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-car"></i>

                                    </div>

                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- column -->
                    <div class="col-lg-4">

                        <div class="card">
                           
                                <div class="card-body d-flex icon-red">

                                    <div class="card-left">
                                    <a href="{{ route('rides.completed') }}">
                                        <h3 class="m-b-0 text-dark font-medium mb-2">

                                            @if($currency->symbol_at_right=="true")
                                            {{number_format($today_earnings,$currency->decimal_digit)." ".$currency->symbole }}

                                            @else
                                            {{ $currency->symbole." ".number_format($today_earnings,$currency->decimal_digit) }}
                                            @endif
                                        </h3>
                                    </a>
                                    <a href="{{ route('parcel.completed') }}">
                                        <h6 id="parcel_total_earnings">{{ trans('lang.dashboard_parcel_total_earnings') }}
                                            @if($currency->symbol_at_right=="true")
                                            {{number_format($today_parcel_earnings,$currency->decimal_digit)." ".$currency->symbole }}

                                            @else
                                            {{ $currency->symbole." ".number_format($today_parcel_earnings,$currency->decimal_digit) }}
                                            @endif
                                        </h6>
                                    </a>

                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_earnings')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-car"></i>

                                    </div>

                                </div>
                            
                        </div>

                    </div>
                    <!-- column -->

                    <div class="col-lg-4">

                        <div class="card">
                            
                                <div class="card-body d-flex icon-orange">

                                    <div class="card-left">
                                    <a href="{{ route('rides.completed') }}">
                                        <h3 class="m-b-0 text-dark font-medium mb-2 admin_commission" id="admin_commission">

                                            @if($currency->symbol_at_right=="true")
                                            {{ number_format($today_admin_commission,$currency->decimal_digit)." ".$currency->symbole }}

                                            @else
                                            {{ $currency->symbole." ".number_format($today_admin_commission,$currency->decimal_digit) }}
                                            @endif
                                        </h3>
                                    </a>
                                        <a href="{{ route('parcel.completed') }}">
                                        <h6 id="parcel_admin_commission">{{ trans('lang.dashboard_parcel_total_earnings') }}
                                            @if($currency->symbol_at_right=="true")
                                            {{number_format($today_parcel_admin_commission,$currency->decimal_digit)." ".$currency->symbole }}

                                            @else
                                            {{ $currency->symbole." ".number_format($today_parcel_admin_commission,$currency->decimal_digit) }}
                                            @endif
                                        </h6>
                                        </a>
                                        <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_total_admin_commission')}}</h5>

                                    </div>

                                    <div class="card-right ml-auto">

                                        <i class="mdi mdi-wallet"></i>

                                    </div>

                                </div>
                           
                        </div>

                    </div>

                </div>

                <!-- start row -->
                <div class="row trip-info today bottom">

                    <!-- column -->
                    <div class="col-lg-12 col-md-12">

                        <div class="row">

                            <div class="col-md-3">

                                <div class="card">

                                    <div class="card-body d-flex card-blue icon-white">

                                        <div class="card-left">
                                            <a href="{{ route('rides.completed') }}">
                                                <h2 class="m-b-0 text-white font-medium">{{ $todays_completed_ride }}</h2>
                                            </a>
                                            <a href="{{ route('parcel.completed') }}">
                                                <h6 class="m-b-0 text-dark font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $today_parcel_completed_rides }}</h2>
                                            </a>
                                            <h5 class="m-b-0 text-white small">{{trans('lang.dashboard_completed_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto">

                                            <i class="mdi mdi-calendar-check"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card">
                                    <div class="card-body d-flex card-graph icon-red">

                                        <div class="card-left">
                                            <a href="{{ route('rides.confirmed') }}">

                                                <h3 class="m-b-0 text-dark font-medium">{{ $today_confirmed_rides }}</h3>
                                            </a>
                                            <a href="{{ route('parcel.confirmed') }}">

                                                <h6 class="m-b-0 text-dark font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $today_parcel_confirmed_rides }}</h2>
                                            </a>
                                            <h5 class="text-dark m-b-0 small">{{trans('lang.dashboard_confirmed_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto">

                                            <i class="mdi mdi-car-connected"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="card">

                                    <div class="card-body d-flex card-red icon-white">

                                        <div class="card-left">
                                            <a href="{{ route('rides.rejected') }}">
                                                <h2 class="m-b-0 text-white font-medium" id="users_count">{{ $today_canceled_rides }}</h2>
                                            </a>
                                            <a href="{{ route('parcel.rejected') }}">
                                                <h6 class="m-b-0 text-dark font-medium">{{ trans('lang.dashboard_parcel_total_earnings') }}{{ $today_parcel_canceled_rides }}</h2>
                                            </a>
                                            <h5 class="m-b-0 text-white small">{{trans('lang.dashboard_cancelled_trip')}}</h5>

                                        </div>

                                        <div class="card-right ml-auto position-relative over-icon-box">

                                            <i class="mdi mdi-car"></i>
                                            <i class="mdi mdi-close position-absolute over-icon"></i>

                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->

        <!--charts Start-->
        <div class="row daes-sec-sec">

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.total_sales')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2"> <i class="fa fa-square" style="color:#2EC7D9"></i> {{trans('lang.dashboard_this_year')}} </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.service_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex-row">
                            <canvas id="visitors" height="200"></canvas>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.sales_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex-row">
                            <canvas id="commissions" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--charts End-->

    </div>
    <!-- end container -->

</div>
<!-- end page-wrapper -->

@endsection

@section('scripts')

<script src="{{asset('js/chart.js')}}"></script>

<script type="text/javascript">
    var currency = '<?php echo $currency->symbole . " "; ?>';
    var decimal_point = '<?php echo $currency->decimal_digit . " "; ?>';
    var symbol_at_right = '<?php echo $currency->symbol_at_right ?>';
    $(document).ready(function() {

        setVisitors();
        setCommision();

        $.ajax({
            url: "home/sales_overview",
            method: "GET",
            success: function(data) {
                obj = JSON.parse(data);
                v01 = obj['v1'];
                v02 = obj['v2'];
                v03 = obj['v3'];
                v04 = obj['v4'];
                v05 = obj['v5'];
                v06 = obj['v6'];
                v07 = obj['v7'];
                v08 = obj['v8'];
                v09 = obj['v9'];
                v10 = obj['v10'];
                v11 = obj['v11'];
                v12 = obj['v12'];
                var data = [v01, v02, v03, v04, v05, v06, v07, v08, v09, v10, v11, v12];
                var labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                var $salesChart = $('#sales-chart');
                renderChart($salesChart, data, labels);
            }

        });
    });

    function renderChart(chartNode, data, labels) {
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };

        var mode = 'index';
        var intersect = true;
        return new Chart(chartNode, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: '#2EC7D9',
                    borderColor: '#2EC7D9',
                    data: data
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                if (symbol_at_right == "true") {
                                    return +value.toFixed(decimal_point);
                                } else {
                                    return +value.toFixed(decimal_point);

                                }
                            }


                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    }

    function setVisitors() {

        const data = {
            labels: [

                "{{trans('lang.dashboard_total_users')}}",
                "{{trans('lang.dashboard_total_drivers')}}",
            ],
            datasets: [{
                data: [jQuery("#driver_count").text(), jQuery("#users_count").text()],
                backgroundColor: [
                    '#218be1',
                    '#B1DB6F',

                ],
                hoverOffset: 4
            }]
        };

        return new Chart('visitors', {
            type: 'doughnut',
            data: data,
            options: {
                maintainAspectRatio: false,
            }
        })
    }

    function setCommision() {
        const data = {
            labels: [
                "{{trans('lang.dashboard_total_earnings')}}",
                "{{trans('lang.admin_commission')}}"
            ],
            datasets: [{
                data: [jQuery("#total_earning").val(), jQuery("#admin_commission").val()],
                backgroundColor: [
                    '#feb84d',
                    '#9b77f8',
                    '#fe95d3'
                ],
                hoverOffset: 4
            }]

        };
        return new Chart('commissions', {
            type: 'doughnut',
            data: data,
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItems, data) {
                            var amount = '';
                            if (symbol_at_right == "true") {
                                amount = parseFloat(data.datasets[0].data[tooltipItems.index]).toFixed(decimal_point) + "" + currency;
                            } else {
                                amount = currency + "" + parseFloat(data.datasets[0].data[tooltipItems.index]).toFixed(decimal_point)
                            }
                            return data.labels[tooltipItems.index] + ': ' + amount;
                        }
                    }
                }
            }
        })
    }
</script>

@endsection