<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($title) ? $title  : 'E-Form');?></title>
        
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/css/custom.min.css');?>" rel="stylesheet">

        <style type="text/css">
            .login{
                background: #000;
            }    
            .form-group {
                margin-bottom: 1rem;
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
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/jquery/dist/jquery.min.js');?>"></script>
        
    </head>
    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>
            
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <?php $this->load->view($contents);?>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
