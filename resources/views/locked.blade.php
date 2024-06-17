<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>HR</title>

  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/locked.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/responsive.css') }}">
</head>

<body>
  <div class="form-bg">
    <div class="black-overlay"></div>
    <div class="form-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <div class="form-wrapper">
              <div class="form-logo-wrapper">
                <img src="{{ asset('theme/images/logo-small.png') }}">
              </div>
              <form class="pin-confirmation" method="POST" action="{{ route('unlock') }}">
                @csrf
                <p>Welcome back</p>
                <p>Please enter the pin to get started</p>
                <div class="form-group row">
                  <div class="col-12">
                    <input type="password" class="form-control" id="inputPassword" name="pin" placeholder="Pin" inputmode="numeric" pattern="[0-9]*" autofocus>
                  </div>
                  <div class="col-12">
                    <a href="#" class="pull-right contact-admin" style="display:none;">Contact Admin</a>
                  </div>
                </div class="form-group row">
                <div class="col-12">
                  <button type="submit" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-enter btn-sm">Enter</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-logo-section">
      <div class="bottom-section-content">
        <div class="logo-bottom-wrapper">
          <img src="{{ asset('theme/images/logo-big.png') }}">
        </div>
        <p>Powered by Pocket Studio</p>
      </div>
    </div>
  </div>
</div>

</body>

</html>