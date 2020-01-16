@extends('layouts.app')

@section('heading', 'Dashboard')


@section('content')
  
<div class="col-md-12">

    @include('common.errors')

    <div class="mb-3 dashboard-card card TabsAnimation-appear-active"><div class="card-header-tab z-index-6 card-header"><div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>At a glance</div><div class="btn-actions-pane-right text-capitalize"><span class="d-inline-block ml-2" style="width: 200px;"><select name="selectedOption" id="selectedOption" class="form-control"><option value="allTime">All Time</option><option value="7days">Last 7 Days</option><option value="30days">Last 30 Days</option><option value="3months">Last 3 Months</option><option value="6months">Last 6 Months</option><option value="1year">Last 1 Year</option></select></span></div></div><div class="no-gutters row"><div class="col-sm-6 col-md-4 col-xl-4"><div class="card no-shadow rm-border bg-transparent widget-chart text-left"><div class="icon-wrapper rounded-circle"><div class="icon-wrapper-bg opacity-10 bg-warning"></div><i class="lnr-laptop-phone text-dark opacity-8"></i></div><div class="widget-chart-content"><div class="widget-subheading">Number of issued earnings</div><div class="widget-numbers">1</div></div></div><div class="divider m-0 d-md-none d-sm-block"></div></div><div class="col-sm-6 col-md-4 col-xl-4"><div class="card no-shadow rm-border bg-transparent widget-chart text-left"><div class="icon-wrapper rounded-circle"><div class="icon-wrapper-bg opacity-9 bg-danger"></div><i class="lnr-graduation-hat text-white"></i></div><div class="widget-chart-content"><div class="widget-subheading">Amount of issued earnings</div><div class="widget-numbers"><span>$83,13</span></div></div></div><div class="divider m-0 d-md-none d-sm-block"></div></div><div class="col-sm-12 col-md-4 col-xl-4"><div class="card no-shadow rm-border bg-transparent widget-chart text-left"><div class="icon-wrapper rounded-circle"><div class="icon-wrapper-bg opacity-9 bg-success"></div><i class="lnr-apartment text-white"></i></div><div class="widget-chart-content"><div class="widget-subheading">Average amount per earning</div><div class="widget-numbers text-success"><span>$83,13</span></div></div></div></div></div><div class="no-gutters row"><div class="col-md-12 col-lg-4"><ul class="list-group list-group-flush"><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Regional Fund Managers</div><div class="widget-subheading">Total number of new regional fund managers</div></div><div class="widget-content-right"><div class="widget-numbers text-success">1</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Fund Managers</div><div class="widget-subheading">Total number of new fund managers</div></div><div class="widget-content-right"><div class="widget-numbers text-success">3</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Investors</div><div class="widget-subheading">Total number of new investors</div></div><div class="widget-content-right"><div class="widget-numbers text-success">1</div></div></div></div></div></li></ul></div><div class="col-md-12 col-lg-4"><ul class="list-group list-group-flush"><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Number of Investments</div><div class="widget-subheading">Total number of new investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">1</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Number of Mature Investments</div><div class="widget-subheading">Total number of new mature investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">1</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Number of Immature Investments</div><div class="widget-subheading">Total number of new immature investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">0</div></div></div></div></div></li></ul></div><div class="col-md-12 col-lg-4"><ul class="list-group list-group-flush"><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Amount of Investments</div><div class="widget-subheading">Total amount of new investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">$3,325.00</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Amount of Mature Investments</div><div class="widget-subheading">Total amount of new mature investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">$3,325.00</div></div></div></div></div></li><li class="bg-transparent list-group-item"><div class="widget-content p-0"><div class="widget-content-outer"><div class="widget-content-wrapper"><div class="widget-content-left"><div class="widget-heading">Amount of Immature Investments</div><div class="widget-subheading">Total amount of new immature investments</div></div><div class="widget-content-right"><div class="widget-numbers text-primary">0</div></div></div></div></div></li></ul></div></div></div>






    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Traffic Sources</div>
                    <div class="btn-actions-pane-right text-capitalize">
                        <button class="btn btn-warning">Actions</button>
                    </div>
                </div>
                <div class="pt-0 card-body">
                    <div id="chart-combined"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
