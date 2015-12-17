@extends('layouts.master')

@section('title', 'Giant Vimeo Delivery Bot [Delivery Details]')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Giant Vimeo Delivery Bot</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
            <li><a href="/admin/deliveries">Deliveries</a></li>
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
  <div class="well delivery-details">
    <div class="row">
        <div class="form-group col-md-6 delivery-details">
          <h3>{{ $delivery->vimeo['name'] }} <small>{{ $delivery->getStatus() }}</small> <small class="text-primary delivery-progress"> {{ $delivery->progress }} </small> </h3>
          <hr>
          <h5>{{ $delivery->vimeo['description'] }}</h5>
          <hr>
          <div class="col-md-12">
              <h4><span>Feature</span> <br> {{ str_replace(['watchme/','/mnt/smb/ampas/'],'',$delivery->vimeo['mainVideo']) }}</h4>
              <h4><span>Feature Thumb</span> <br> {{ str_replace(['watchme/','/mnt/smb/ampas/'],'',$delivery->vimeo['thumb']) }}</h4>
              <h4><span>Trailer</span>  <br> {{ str_replace(['watchme/','/mnt/smb/ampas/'],'',$delivery->vimeo['trailerVideo'])}}</h4>
              <h4><span>Trailer Thumb</span>  <br> {{ str_replace(['watchme/','/mnt/smb/ampas/'],'',$delivery->vimeo['trailerThumb'])}}</h4>
          </div>
          <div class="col-md-4">
            <h4><span>Regions </span> <br> {{ str_replace(',',', ',$delivery->vimeo->regions) }}</h4>
            <h4><span>Rating </span> <br> {{ str_replace(',',', ',$delivery->vimeo->content_rating) }}</h4>
            <h4><span>Genres </span> <br> {{ $delivery->vimeo->genres() }}</h4>
            <h4><span>Tags </span> <br> {{ $delivery->vimeo->tags() }}</h4>
          </div>
          <div class="col-md-4">
            <h4><span>Available Date</span> <br> {{ str_replace(',',', ',$delivery->vimeo->availDate) }}</h4>
            <h4><span> Renting </span> <br> {{ $delivery->vimeo['rentActive'] == 1 ? 'Yes' : 'No' }}</h4>
            <h4><span> Renting Period </span> <br> {{ $delivery->vimeo['rentPeriod'] }}</h4>
            <h4><span> Renting Price </span> <br> {{ $delivery->vimeo['rentPrice'] }}</h4>
          </div>
          <div class="col-md-4">
            <h4><span> Buying </span> <br> {{ $delivery->vimeo['buyActive'] == 1 ? 'Yes' : 'No' }}</h4>
            <h4><span> Buy Price: </span> <br> {{ $delivery->vimeo['buyPrice'] }}</h4>
          </div>
        </div>
        <div class="form-group col-md-6 delivery-details">
          <h3>
            Events
            <small class="pull-right text-s">Upload Time: <span class="upload-time"> {{ $delivery->progress()['duration'] }} </span> </small>
          </h3>
          <hr>
          <ul class="list-group event-list">
            @foreach ($events as $event)
              @if ($payload = json_decode($event['payload'])) @endif
              @if ($event['message'] == 'onDemand Page created')
                <li class="list-group-item">
                  <a href="https://vimeo.com/ondemand/{{$payload->pageID}}" target="_blank">
                      <span class="glyphicon glyphicon-th-large pull-right" aria-hidden="true"></span>
                  </a>
                    {{ $event['message'] }}
                </li>
              @elseif ($event['message'] == 'Feature video uploaded successfully')
                <li class="list-group-item">
                  <a href="{{$payload->link}}" target="_blank">
                      <span class="glyphicon glyphicon-th-large pull-right" aria-hidden="true"></span>
                  </a>
                    {{ $event['message'] }}
                </li>
              @elseif ($event['message'] == 'Trailer video uploaded successfully')
                <li class="list-group-item">
                  <a href="{{$payload->link}}" target="_blank">
                      <span class="glyphicon glyphicon-th-large pull-right" aria-hidden="true"></span>
                  </a>
                    {{ $event['message'] }}
                </li>
              @else
                @if (!isset($payload->progress))
                  <li class="list-group-item">{{ $event['message'] }}</li>
                @endif
              @endif
            @endforeach
          </ul>
        </div>
        <div class="col-md-12">
            @if ($delivery->getStatus() == 'Pending')
              <button type="submit" class="btn btn-primary pull-right" onclick="processDelivery({{$delivery->vimeo['deliveryID']}})">
                <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> Process
              </button>
            @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script style="text/javascript">
var deliverID = {{$delivery->id}}
$(function(){
  var pollProgress = setInterval(pollDelivery, 1000)
  function pollDelivery(){
    $.ajax({
      url: url + '/api/v1/deliveries/' + deliverID + '/progress',
      type: 'get',
      success: function(data){
        if (data.progress !== $('.delivery-progress').html()) {
          $('.delivery-progress').html(data.progress)
          $('.upload-time').html(data.duration)
        }
        if (data.progress == '100%') clearInterval(pollProgress)
      }
    })
  }
})
</script>
@endsection
