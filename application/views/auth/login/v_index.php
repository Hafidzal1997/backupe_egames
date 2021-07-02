<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($title) ? $title  . ' - ' : '');?> E-Games</title>
        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
        <!-- Animate.css -->
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/animate.css/animate.min.css');?>" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="<?php echo base_url('assets/backoffice/assets/css/custom.min.css');?>" rel="stylesheet">

        <style type="text/css">
            .login{
                background: #0F2027;  /* fallback for old browsers */
                background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

            }    
            .login_content h1:before {
                background: #00c0ff;
                background: -webkit-gradient(linear, right top, left top, from(#00c0ff), to(#fff));
                background: linear-gradient(to left, #00c0ff 0%, #fff 100%);
                left: 0;
            }
            .login_content h1:after {
                background: #00c0ff;
                background: -webkit-gradient(linear, left top, right top, from(#00c0ff), to(#fff));
                background: linear-gradient(to right, #00c0ff 0%, #fff 100%);
                right: 0;
            }
            .login_content h1{
                color: #FFFFFF;
            }
            .login_content{
                color: #FFFFFF;
                text-shadow: unset;
            }
            .login_content form input[type="text"], .login_content form input[type="email"], .login_content form input[type="password"]{
                -webkit-box-shadow: unset;
                box-shadow: unset;
                color: #000;
                margin-bottom: 0px;
            }
            .key-code{
                margin: 5px -4px;
                cursor: pointer;
            }
            .request-code{
                cursor: pointer;
                color: #FFFFFF;
            }
        </style>

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/jquery/dist/jquery.min.js');?>"></script>
        
    </head>
    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>
            
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">

                        <h3 class="pb-3">
                            <i class="fa fa-gamepad text-warning"></i> E-Games
                        </h3>


                        <form action="<?php echo current_url();?>" method="post">
                            <h1>Login</h1>
                            <div class="form-group text-left">
                                <label>
                                    <strong>
                                        Email
                                    </strong>
                                </label>
                                <div>
                                    <input type="text" name="param1" value="<?php echo set_value('param1');?>" class="form-control" placeholder="Masukkan Email" required="" />
                                    <?php echo form_error('param1', '<strong class="text-danger">', '</strong>');?>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <label>
                                    <strong>
                                        Password
                                    </strong>
                                </label>
                                <div>
                                    <input type="password" name="param2" class="form-control" placeholder="Masukkan Password" required="" autocomplete="off" />
                                    <?php echo form_error('param2', '<strong class="text-danger">', '</strong>');?>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <label>
                                    <strong>
                                        Kode Captcha
                                    </strong>
                                </label>
                                <div class="row">
                                    <div class="col-9">
                                        <div class="key-code">
                                            <?php echo $captcha; ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="py-3">
                                            <i title="KLIK DISINI UNTUK MENGUBAH KODE CAPTCHA" class="fa fa-refresh fa-2x request-code"  style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="param3" class="form-control" placeholder="Masukkan Kode Captcha" required="" autocomplete="off" />
                                    <?php echo form_error('param3', '<strong class="text-danger">', '</strong>');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-warning btn-block" type="submit">Login</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <p>&copy; E-Games <?php echo date('Y');?> All Rights Reserved.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <script>
            $(".request-code").click(function(){
                $(".request-code").css({WebkitTransform:"rotate(340deg)"});
                $(".request-code").css({"-moz-transform":"rotate(340deg)"});
                $.ajax({
                    url:"<?php echo base_url('auth/login/request_code');?>",
                    type:"GET",
                    success:function(reponse){
                        $(".key-code").html(reponse);
                        $(".request-code").css({WebkitTransform:"rotate(0deg)"});
                        $(".request-code").css({"-moz-transform":"rotate(0deg)"});
                    },error:function(e,t,o){
                        console.log(t,o);
                    }
                });
            });
        </script>
    </body>
</html>
