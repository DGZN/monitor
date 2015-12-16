@extends('auth.layouts.master-no-nav')

@section('title', 'Giant Vimeo Delivery Bot [Login]')

@section('content')
  <div class="container">
      <div class="row vertical-offset-100">
      	<div class="col-md-4 col-md-offset-4">
      		<div class="panel panel-default">
  			  	<div class="panel-heading">
  			    	<h3 class="panel-title">Please sign in</h3>
  			 	</div>
  			  	<div class="panel-body">
  			    	<form accept-charset="UTF-8" role="form" method="post" action="/auth/login">
                      <fieldset>
  			    	  	<div class="form-group">
  			    		    <input class="form-control" placeholder="E-mail" name="email" type="text">
  			    		</div>
  			    		<div class="form-group">
  			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
  			    		</div>
  			    		<div class="checkbox">
  			    	    	<label>
  			    	    		<input name="remember" type="checkbox" value="Remember Me"> Remember Me
  			    	    	</label>
  			    	    </div>
  			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
  			    	</fieldset>
  			      	</form>
  			    </div>
  			</div>
  		</div>
  	</div>
  </div>
@endsection

@section('scripts')
<script style="text/javascript">
$(function(){
  $(document).mousemove(function(e){
     TweenLite.to($('body'),
        .5,
        { css:
            {
                backgroundPosition: ""+ parseInt(event.pageX/8) + "px "+parseInt(event.pageY/'12')+"px, "+parseInt(event.pageX/'15')+"px "+parseInt(event.pageY/'15')+"px, "+parseInt(event.pageX/'30')+"px "+parseInt(event.pageY/'30')+"px"
            }
        });
  });
});
</script>
@endsection
