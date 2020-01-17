@extends('layouts.app')

@section('heading', 'Dashboard')


@section('content')
  
<div class="col-md-12">

    @include('common.errors')


    <div class="row">
        <div class="col-md-8">
            <div class="mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">New Investments & New Investors</div>
                </div>
                <div class="pt-0 card-body">
                    <div id="investments-investor-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card no-gutters mt-1 px-0 col-md-12 row">
                <div class="col-md-12">
                    <h3 class="card-header-title font-size-lg text-capitalize font-weight-normal ml-3 pl-3 mt-3">This Month At A Glance</h3>
                    <hr>
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Number of Investments Maturing</div>
                                                <div class="widget-subheading">Total Number of Investments Maturing</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{num($thisMonth->maturing_investments)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Amount of Investments Maturing</div>
                                                <div class="widget-subheading">Total Amount of Investments Maturing</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{moneyFormat($thisMonth->maturing_investments_amount)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Number Of New Investments</div>
                                                <div class="widget-subheading">Total Number Of New Investments</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{num($thisMonth->new_investments)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Amount Of New Investments</div>
                                                <div class="widget-subheading">Total Amount Of New Investments</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{moneyFormat($thisMonth->new_investments_amount)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Number of New Fund Managers</div>
                                                <div class="widget-subheading">Total Number of New Fund Managers</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{num($thisMonth->new_fund_managers)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="bg-transparent list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">

                                                <div class="widget-heading">Number of New Investors</div>
                                                <div class="widget-subheading">Total Number of New Investors</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">{{num($thisMonth->new_investors)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="mb-3 dashboard-card card TabsAnimation-appear-active">
                    <div class="card-header-tab z-index-6 card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>All time statistics</div>
                        
                    </div>
                    <div class="no-gutters row">
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-10 bg-warning"></div><i class="lnr-laptop-phone text-dark opacity-8"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Number of issued earnings</div>
                                    <div class="widget-numbers">{{num($allTime->earnings)}}</div>
                                </div>
                            </div>
                            <div class="divider m-0 d-md-none d-sm-block"></div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-9 bg-danger"></div><i class="lnr-graduation-hat text-white"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Amount of issued earnings</div>
                                    <div class="widget-numbers"><span>{{moneyFormat($allTime->earnings_amount)}}</span></div>
                                </div>
                            </div>
                            <div class="divider m-0 d-md-none d-sm-block"></div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-9 bg-success"></div><i class="lnr-apartment text-white"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Average amount per earning</div>
                                    <div class="widget-numbers text-success"><span>{{moneyFormat($allTime->average_earning)}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="no-gutters row">
                        <div class="col-md-12 col-lg-4">
                            <ul class="list-group list-group-flush">
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Administrators</div>
                                                    <div class="widget-subheading">Total number of new Administrators</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-success">{{num($allTime->administrators)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Fund Managers</div>
                                                    <div class="widget-subheading">Total number of new fund managers</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-success">{{num($allTime->fund_managers)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Investors</div>
                                                    <div class="widget-subheading">Total number of new investors</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-success">{{num($allTime->investors)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <ul class="list-group list-group-flush">
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Number of Investments</div>
                                                    <div class="widget-subheading">Total number of new investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{num($allTime->investments)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Number of Mature Investments</div>
                                                    <div class="widget-subheading">Total number of new mature investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{num($allTime->mature_investments)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Number of Immature Investments</div>
                                                    <div class="widget-subheading">Total number of new immature investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{num($allTime->immature_investments)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <ul class="list-group list-group-flush">
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Amount of Investments</div>
                                                    <div class="widget-subheading">Total amount of new investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{moneyFormat($allTime->investments_amount)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Amount of Mature Investments</div>
                                                    <div class="widget-subheading">Total amount of new mature investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{moneyFormat($allTime->mature_investments_amount)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-transparent list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Amount of Immature Investments</div>
                                                    <div class="widget-subheading">Total amount of new immature investments</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary">{{moneyFormat($allTime->immature_investments_amount)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script stype="text/javascript">
        $(document).ready(() => {
            

            let chartOptions = {
                    chart: {
                        height: 397,
                        type: 'line',
                        toolbar: {
                            show: false,
                        }
                    },
                    series: [{
                        name: 'Investments',
                        type: 'column',
                        data: [{{implode(',', $investments)}}]
                    },
                    {
                        name: 'Investors',
                        type: 'line',
                        data: [{{implode(',', $investors)}}]
                    }],
                    stroke: {
                        width: [0, 4]
                    },
                    labels: ["{!! implode('","', $months) !!}"],
                    //labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
                    xaxis: {
                        type: 'month'
                    },
                    yaxis: [{
                        title: {
                            text: 'New Investments',
                        },

                    }, {
                        opposite: true,
                        title: {
                            text: 'New Investors'
                        }
                    }]

                };

             let investmentsInvestorChart = new ApexCharts(document.querySelector("#investments-investor-chart"), chartOptions).render();



             
        });
    </script>
@endsection
