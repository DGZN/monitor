@extends('layouts.master')

@section('title', 'Giant Approval Site Admin Details')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Giant Vimeo Delivery</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
            <li><a href="/deliveries">Deliveries</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/auth/logout">Logout</a></li>
              </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="well delivery-details">
      <div class="form-group col-md-6 delivery-details">
        <h4>{{ $vimeo['name'] }}</h4>
        <h5>{{ $vimeo['description'] }}</h5>
        <h5><span> Renting: </span>{{ $vimeo['rentActive'] == 1 ? 'True' : 'False' }}</h5>
        <h5><span> Renting Period: </span>{{ $vimeo['rentPeriod'] }}</h5>
        <h5><span> Renting Price: </span>{{ $vimeo['rentPrice'] }}</h5>
        <h5><span> Buying </span>{{ $vimeo['buyActive'] == 1 ? 'True' : 'False' }}</h5>
        <h5><span> Buy Price: </span>{{ $vimeo['buyPrice'] }}</h5>
      </div>
    </div>
  </div>
</div>
@endsection
