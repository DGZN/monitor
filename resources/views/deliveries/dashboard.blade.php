@extends('layouts.master')

@section('title', 'Giant Vimeo Delivery Bot Dashboard')

@section('navbar')
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Giant Vimeo Delivery Bot</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left api-routes">
          <li><a href="/admin/deliveries/archived">Archived</a></li>
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
            <div class="well well-lg">
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 3%;"></th>
                      <th style="width: 7%;"></th>
                      <th style="width: 15%;"></th>
                      <th style="width: 20%;"></th>
                      <th style="width: 50%;"></th>
                      <th style="width: 5%;"></th>
                    </tr>
                  </thead>
                  <tbody id="deliveries-body">
                    @if (isset($deliveries))
                      @for ($i = 0; $i < count($deliveries); $i++)
                        <tr id="{{ 'row'.$i }}" style="cursor: pointer;" class="{{ $deliveries[$i]->getClass() OR '' }}">
                            <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$i+1}}</td>
                            <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->vimeo->client}}</td>
                            <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->name}}</td>
                            <td>
                              {{$deliveries[$i]->getStatus()}}
                            </td>
                            <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->progress}}</td>
                            <td>
                                <i class="remove-icon"
                                   onclick="removeItem(this)"
                                   data-row="{{'row'.$i}}"
                                   data-id="{{$deliveries[$i]->id}}"
                                   data-resource="deliveries"></i>
                                 <i class="archive-icon"
                                    onclick="archiveItem(this)"
                                    data-row="{{'row'.$i}}"
                                    data-id="{{$deliveries[$i]->id}}"
                                    data-resource="deliveries">&#10004;</i>

                            </td>
                        </tr>
                      @endfor
                  @endif
                  </tbody>
              </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Client</h4>
          </div>
            <div class="modal-body">
              <div class="form-group col-md-6">
                <label for="company">Company</label>
                <input type="text" class="form-control" name="company" id="company" placeholder="Company">
              </div>
              <div class="form-group col-md-6">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact">
              </div>
              <div class="form-group col-md-12">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script style="text/javascript">
$(function(){
  function pollDeliveries(){
    $.ajax({
      url: url + '/api/v1/deliveries/',
      success: function(data){
        var i=0;
        var rows = []
        rows = data.map(function(delivery){
          switch (delivery.status) {
            case '2':
                var status = 'Processing'
              break;
            case '3':
                var status = 'Uploading'
                var className = 'bg-info'
              break;
            case '4':
                var status = 'Delivered'
                var className = 'bg-success'
              break;
            case '5':
                var status = 'Error'
                var className = 'bg-danger'
              break;
            default:
                var status = 'Pending'
                var className = ''
              break;
          }
          var progress = '<div class="progress">                                                                                                                     \
            <div class="progress-bar" role="progressbar" aria-valuenow="'+delivery.progress+'" aria-valuemin="0" aria-valuemax="100" style="width: '+delivery.progress+'%;">            \
            </div>                                                                                                                                                   \
          </div>'
          if (delivery.status > 3)
            progress = ''
          i++
          return '<tr id="row2" style="cursor: pointer;" class="'+ className +'">    \
                <td onclick="viewDetails('+delivery.id+')">'+i+'</td>                \
                <td onclick="viewDetails('+delivery.id+')">'+delivery.vimeo.client+'</td>   \
                <td onclick="viewDetails('+delivery.id+')">'+delivery.name+'</td>    \
                <td>'+taskName(delivery.activeTask)+'</td>                                                  \
                <td onclick="viewDetails('+delivery.id+')">'+progress+'</td>    \
                <td>                                                                 \
                    <i class="remove-icon"  onclick="removeItem(this)"  data-row="row2" data-id="'+delivery.id+'" data-resource="deliveries"></i> \
                    <i class="archive-icon" onclick="archiveItem(this)" data-row="row2" data-id="'+delivery.id+'" data-resource="deliveries">&#10004;</i> \
                </td>                                                                \
            </tr>'
        })
        $('#deliveries-body').html(rows)
      },
      dataType: 'JSON'
    });
  }
  setInterval(pollDeliveries, 1000)
})

function taskName(str){
  var name = 'Processing ' + ucFirst(str)
  if (str.indexOf('upload')>=0)
    var name = 'Uploding ' + ucFirst(str.replace('upload',''))
  return name;
}

function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>
@endsection
