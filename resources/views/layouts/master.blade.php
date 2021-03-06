<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                /*font-family: 'Lato';*/
                background-image: url('/images/panel_bck.jpg');
            }

            .content {
                text-align: center;
                padding-top: 20px;
            }

            .title {
                font-size: 46px;
            }

            .navbar-header {
                font-weight: 20px;
                font-weight: 900;
                font-family: 'Lato', sans-serif !important;
            }

            .api-routes {
                font-size: 16px;
                font-weight: 300 !important;
                /*font-family: 'Lato', sans-serif !important;*/
            }

            .view-icon {
                position: relative;
                left: 20px;
                top: 5px;
                font-size: 12px;
                margin: 1px 5px 2px 5px;
            }

            .remove-icon {
                position: relative;
                font-size: 12px;
                margin: 1px 5px 2px 5px;
            }

            .remove-icon:before, .remove-icon:after {
                position: absolute;
                background: red;
                height: 12px;
                width: 2px;
                content: "";
                cursor: pointer;
            }

            .remove-icon:before {
                height: 12px;
                left: 14px;
                top: 5px;
                transform: rotate(-45deg);
            }

            .archive-icon {
                position: relative;
                top: 3px;
                font-size: 12px;
                margin: 5px 5px 2px 25px;
                color: #7cfc00;
            }

            .add-item {
                position: relative;
                font-size: 12px;
                margin: 1px 5px 2px 5px;
                color: #5cb85c;
                cursor: pointer;
            }

            .well {
              background: white;
            }

            .table {
              color: black;
            }

            .remove-icon:after {
                height: 12px;
                right: -15px;
                top: 5px;
                transform: rotate(45deg);
            }

            .confirmRemoveModal-content {
              width: 420px !important;
            }

            .modal-footer {
              border-top: 0px !important;
            }

            .delivery-details {
              min-height: 600px;
              display: block;
            }

            .delivery-details h4 {
              font-weight: bold;
              font-size: 16px;
              line-height: 25px;
            }

            .delivery-details h4 span{
              font-weight: 300;
            }

            .delivery-details h5 {
              font-weight: 300;
              line-height: 16px;
            }


            .delivery-details h5 span {
              font-weight: bold;
            }

            .event-list {
                font-weight: 300;
                font-size: 14px;
            }

            .event-list label {
              font-weight: 300 !important;
              margin-bottom: 0px !important;
            }

            .event-list .glyphicon {
              position: relative;
              display: block;
              float: right;
              color: green;
            }

            .view-on-vimeo {
              color: #337ab7 !important;
            }

            .delivery-error{
              color: red !important;
            }

            .event-list .error {
              background-color: #f2dede !important;
            }

            .error-detail {
              position: relative;
              font-size: 12px;
              font-weight: bold;
              color: red;
              display: block;
              margin-top: 8px;
            }

            .progress {
              margin-bottom: 0px !important;
            }


        </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            @yield('navbar')
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>

        <div class="modal fade" id="confirmRemoveModal" tabindex="-1" role="dialog" aria-labelledby="confirmRemoveModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content confirmRemoveModal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmRemoveModalLabel">Are you sure you want to delete this record?</h4>
              </div>
                <div class="modal-footer">
                  <form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" id="confirmRemoveButton" onclick="confirmRemove()" class="btn btn-danger">Yes</button>
                  </form>
                </div>
            </div>
          </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script>
    var path = location.href.split( '/' );
    var url = path[0] + '//' + path[2];
    function viewDetails(id){
      window.location.href = '/admin/deliveries/' + id
    }
    function processDelivery(id){
      $.ajax({
        url: url + '/api/v1/deliveries/' + id,
        type: 'patch',
        data:  {
          "status": 2
        , "events": false
        },
        success: function(data){
          window.location.href = '/admin'
        }
      })
    }
    function addItem(){
      $('#addItemModal').modal()
    }
    function playVideo(name){
      $('#videoPreview').modal()
      $('#videoName').html(name)
      $('#videoPlayer').attr('src', '/uploads/' + name)
    }
    $("#addItemForm").on( "submit", function( event ) {
      event.preventDefault();
      var resource = this.getAttribute("data-resource")
      var params = {};
      $.each($(this).serializeArray(), function(_, kv) {
        params[kv.name] = kv.value;
      });
      $.ajax({
        url: url + '/' + resource,
        type: 'post',
        data:  params,
        success: function(data){
          if (data['errors']) {
            var errors = '';
            for (error in data['errors']) {
              if (data['errors'][error][0].length)
                errors += '<li>' + data['errors'][error][0] + '</li>'
            }
            $('#errors').css('display', 'block').html('<ul>' + errors + '</ul>')
          } else {
            location.reload()
          }
        },
        error: function(data){
          var fields = data.responseJSON
          for (field in fields) {
            var _field = $('#'+field)
            var message = fields[field].toString().replace('i d', 'ID')
            _field.parent().addClass('has-error')
            _field.prop('placeholder', message)
          }
        }
      })
    });
    var remove = false,
    removing;
    function removeItem(item){
      var id = item.getAttribute("data-id")
      var row = item.getAttribute("data-row")
      var resource = item.getAttribute("data-resource")
      if (!remove){
        removing = item
        $('#confirmRemoveModal').modal()
        return;
      } else {
        $('#confirmRemoveModal').modal('toggle')
      }
      $.ajax({
        url: url + '/api/v1/' + resource + '/' + id,
        type: 'post',
        data: {_method: 'delete'},
        success: function(data){
          $('#'+row).remove()
        }
      })
    }
    function archiveItem(item){
      var id = item.getAttribute("data-id")
      var row = item.getAttribute("data-row")
      var resource = item.getAttribute("data-resource")
      $.ajax({
        url: url + '/api/v1/' + resource + '/' + id,
        type: 'put',
        data: {status: 6},
        success: function(data){
          $('#'+row).remove()
        }
      })
    }
    function confirmRemove(){
      remove = true
      return removeItem(removing)
    }
    </script>
    @yield('scripts')
    </body>
</html>
