<!DOCTYPE html>
<html lang="en">
<head>
  <title>CPKA</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/jquery/jquery-3.2.1.min.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/animsition/js/animsition.min.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/bootstrap/js/popper.js')?>"></script>
  <script src="<?=base_url('assets/login/vendor/bootstrap/js/bootstrap.min.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/select2/select2.min.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/daterangepicker/moment.min.js')?>"></script>
  <script src="<?=base_url('assets/login/vendor/daterangepicker/daterangepicker.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/vendor/countdowntime/countdowntime.js')?>"></script>
<!--===============================================================================================-->
  <script src="<?=base_url('assets/login/js/main.js')?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/bootstrap/css/bootstrap.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/fonts/iconic/css/material-design-iconic-font.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/animate/animate.css')?>">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/css-hamburgers/hamburgers.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/animsition/css/animsition.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/select2/select2.min.css')?>">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/vendor/daterangepicker/daterangepicker.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/css/util.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/css/main.css')?>">
<!--===============================================================================================-->
</head>
<body>
  
  <div class="limiter">
    <div class="container-login100" style="background-image: url('assets/login/images/bg-01.jpg');">
      <div class="wrap-login100">
        <form class="login100-form validate-form" id="form-login">
          <span class="login100-form-logo">
            <img src="<?=base_url('assets/login/images/cpka-logo.png')?>" width="130px">
          </span>

          <span class="login100-form-title p-b-34 p-t-27">
          PT. CPKA 
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Enter username">
            <input class="input100" type="text" name="username" placeholder="Username">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
          </div>

          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

  <div id="dropDownSelect1"></div>
  <script type="text/javascript">
    $(document).ready(function(){
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $(document).on('submit','#form-login',function(event){
        event.preventDefault();
        $.ajax({
          url: '<?php echo site_url('auth/login') ?>',
          data: $(this).serialize(),
          dataType: 'JSON',
          method: 'POST',
          success: function(response){
            if (response.status == "success") {
              Toast.fire({
                type: 'success',
                title: 'Berhasil masuk.'
              });
              window.location.href="<?php echo site_url('/'); ?>";
            } else {
              msg = ""
              if (response.msg) {
                $.each(response.msg,function(i,value){
                  msg += '* ' + response.msg[i] + "<br>";
                });
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  html: msg,
                });
              }            
            }
          },
          error: function(){
            Toast.fire({
              type: 'error',
              title: '<p style="color:red; font-size:12px">Kesalahan Internal.</p>'
            });
          }
        });
      });
    });
  </script>
</body>
</html>
