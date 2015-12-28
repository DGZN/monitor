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
<div class="row">
        <div class="col-md-12">
            <div class="well well-lg">
              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Client</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Progress</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="deliveries-body">
                    @for ($i = 0; $i < count($deliveries); $i++)
                      <tr id="{{ 'row'.$i }}" style="cursor: pointer;" class="bg-primary">
                          <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$i+1}}</td>
                          <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->vimeo->client}}</td>
                          <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->name}}</td>
                          <td>Archived</td>
                          <td onclick="viewDetails({{$deliveries[$i]->id}})" >{{$deliveries[$i]->progress}}</td>
                          <td>
                              <i class="remove-icon"
                                 onclick="removeItem(this)"
                                 data-row="{{'row'.$i}}"
                                 data-id="{{$deliveries[$i]->id}}"
                                 data-resource="deliveries"></i>
                          </td>
                      </tr>
                    @endfor
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
      url: url + '/api/v1/deliveries/archived',
      success: function(data){
        var i=0;
        var rows = []
        rows = data.map(function(delivery){
          switch (delivery.status) {
            default:
              var status = 'Archived'
              var className = 'bg-success'
              break;
          }
          i++
          return '<tr id="row2" style="cursor: pointer;" class="'+ className +'">    \
                <td onclick="viewDetails('+delivery.id+')">'+i+'</td>                \
                <td onclick="viewDetails('+delivery.id+')">'+delivery.vimeo.client+'</td>   \
                <td onclick="viewDetails('+delivery.id+')">'+delivery.name+'</td>    \
                <td>'+status+'</td>                                                  \
                <td onclick="viewDetails('+delivery.id+')">'+delivery.progress+'</td>    \
                <td>                                                                 \
                    <i class="remove-icon" onclick="removeItem(this)" data-row="row2" data-id="'+delivery.id+'" data-resource="deliveries"></i> \
                </td>                                                                \
            </tr>'
        })
        $('#deliveries-body').html(rows)
      },
      dataType: 'JSON'
    });
  }
  setInterval(pollDeliveries, 10000)
})
</script>
@endsection
