<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php echo (isset($title) ? $title  . ' - ' : '');?> E-Games</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="assets/bootstrap/css/tether.min.css"/>
        <link rel="stylesheet" href="assets/bootstrap/css/font-awesome/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="assets/bootstrap/css/form_builder.css"/>
        
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/nestable/nestable.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.buttons.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.nonblock.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/sweetalert2/dist/sweetalert2.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/backoffice/assets/css/custom.min.css');?>" rel="stylesheet">                 

        <script src="<?php echo base_url('assets/backoffice/assets/vendors/jquery/dist/jquery.min.js');?>"></script>
        <style type="text/css">
            .table thead th {
                vertical-align: middle;
            }   
            .table>caption+thead>tr:first-child>td, 
            .table>caption+thead>tr:first-child>th, 
            .table>colgroup+thead>tr:first-child>td, 
            .table>colgroup+thead>tr:first-child>th, 
            .table>thead:first-child>tr:first-child>td, 
            .table>thead:first-child>tr:first-child>th {
                vertical-align: middle;
            }

            .table-bordered>thead>tr>th, 
            .table-bordered>tbody>tr>th, 
            .table-bordered>tfoot>tr>th, 
            .table-bordered>thead>tr>td, 
            .table-bordered>tbody>tr>td, 
            .table-bordered>tfoot>tr>td{
                padding: 6px;
                font-size: 13px;
            } 
            .progress{
                margin-bottom: 0px !important;
            }
        </style>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <?php $this->load->view('partials/v_backoffice_sidebar');?>
                    </div>
                </div>
                <?php $this->load->view('partials/v_backoffice_header');?>

                <div class="right_col" role="main">
                    <div>
                        <?php $this->load->view($contents);?>
                    </div>
                </div>                

                <footer>
                    <div class="pull-right">
                        &copy; <?php date('Y');?> <a href="<?php echo base_url();?>">E-Games</a>. All Rights Reserved.
                    </div>
                    <div class="clearfix"></div>
                </footer>
            </div>
        </div>

        <div class="modal fade" id="MyModalDetailNotifikasi" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="MyModalDetailNotifikasiTitle">Detail Notifikasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id="MyModalDetailNotifikasiBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-power-off"></i> Tutup
                        </button>
                        <button type="button" class="btn btn-success btn-modal-accept" style="display: none;">
                            <i class="fa fa-check"></i> Accept
                        </button>
                        <button type="button" class="btn btn-danger btn-modal-reject" style="display: none;">
                            <i class="fa fa-times"></i> Rejected
                        </button>
                        <a href="" class="btn btn-warning btn-modal-edit text-white" style="display: none;">
                            <i class="fa fa-edit"></i> Ubah Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="MyMusic"></div>
        
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/nestable/jquery.nestable.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.buttons.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/pnotify/dist/pnotify.nonblock.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/sweetalert2/dist/sweetalert2.all.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/moment/min/moment.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/switchery/dist/switchery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');?>"></script>
        <script src="<?php echo base_url('assets/backoffice/assets/js/custom.min.js');?>"></script>

         <script>
            $(document).ready(function() {

                var progress_bar = '<div class="text-center text-primary font-weight-bold">'+
                            '<div class="progress">'+
                                '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'+
                            '</div>'+
                            'LOADING DATA'+
                        '</div>';
                
                <?php if($this->session->flashdata('success')):?>
                    Swal.fire('Sukses!', '<?php echo $this->session->flashdata('success'); ?>', 'success');
                <?php endif;?>
                
                <?php if($this->session->flashdata('warning')):?>
                    Swal.fire('Mohon Maaf!', '<?php echo $this->session->flashdata('warning'); ?>', 'warning');
                <?php endif;?>
                
                <?php if($this->session->flashdata('danger')):?>
                    Swal.fire('Error!', '<?php echo $this->session->flashdata('danger'); ?>', 'danger');
                <?php endif;?>

                $(document).on("click", ".btn-logout", function() {
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Anda harus login kembali untuk menggunakan sistem!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#73879C',
                        confirmButtonText: 'Ya, Keluar Sistem!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='<?php echo base_url('auth/login/do-logout');?>';
                        }
                    });
                });

                $(document).on("click", ".btn-detail-notifikasi", function(e){
                    var get_url = $(this).data('url');

                    $("#MyModalDetailNotifikasi").modal('show');
                    $("#MyModalDetailNotifikasiBody").html(progress_bar); 

                    $.get(get_url, function(response) {
                        $("#MyModalDetailNotifikasiBody").html(response); 
                    });
                });

                function auto_ajax_notifikasi_sidebar(){
                    var notifikasi_sidebar;
                    window.onclick = reset_ajax_notifikasi_sidebar; 

                    function ajax_notifikasi_sidebar(){
                        $.ajax({
                            url : "<?php echo base_url('backoffice/dashboard/ajax-notifikasi-sidebar');?>",
                            type: 'GET',
                            dataType: "JSON",
                            success: function(response){
                                if(response.status){                            
                                    $(".notif-waiting-registers").html(response.notif_waiting_registers);
                                    $(".notif-waiting-deposits").html(response.notif_waiting_deposits);
                                    $(".notif-waiting-withdraws").html(response.notif_waiting_withdraws);
                                    $(".notif-waiting-deposits-hari-ini").html(response.notif_waiting_deposits_hari_ini);
                                    $(".notif-waiting-withdraws-hari-ini").html(response.notif_waiting_withdraws_hari_ini);
                                } else {
                                    console.log(response.status);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                    notifikasi_sidebar = setInterval(function(){ ajax_notifikasi_sidebar() }, 3000);            

                    function reset_ajax_notifikasi_sidebar(){
                        clearTimeout(notifikasi_sidebar);
                        auto_ajax_notifikasi_sidebar();
                    }
                }
                auto_ajax_notifikasi_sidebar();

                function auto_ajax_notifikasi_topbar(){
                    var notifikasi_topbar;
                    window.onclick = reset_ajax_notifikasi_topbar; 

                    function ajax_notifikasi_topbar(){
                        $.get("<?php echo base_url('backoffice/dashboard/ajax_notifikasi_topbar');?>", function(response) {
                            $(".badge-notif-topbar").html(response);
                        });
                    }
                    notifikasi_topbar = setInterval(function(){ ajax_notifikasi_topbar() }, 3000);            

                    function reset_ajax_notifikasi_topbar(){
                        clearTimeout(notifikasi_topbar);
                        auto_ajax_notifikasi_topbar();
                    }
                }
                auto_ajax_notifikasi_topbar();

                function auto_ajax_notifikasi_topbar_panel(){
                    var notifikasi_topbar_panel;
                    window.onclick = reset_ajax_notifikasi_topbar_panel; 

                    function ajax_notifikasi_topbar_panel(){
                        $.get("<?php echo base_url('backoffice/dashboard/ajax_notifikasi_topbar_panel');?>", function(response) {
                            if(!$(".msg_list").hasClass("show")){
                                $(".nav-item-remove").remove();
                                $(".msg_list").prepend(response);   
                            }
                        });
                    }
                    notifikasi_topbar_panel = setInterval(function(){ ajax_notifikasi_topbar_panel() }, 3000);            

                    function reset_ajax_notifikasi_topbar_panel(){
                        clearTimeout(notifikasi_topbar_panel);
                        auto_ajax_notifikasi_topbar_panel();
                    }
                }
                auto_ajax_notifikasi_topbar_panel();

                function auto_ajax_notifikasi_after_submit(){
                    var notifikasi_after_submit;
                    //window.onclick = reset_ajax_notifikasi_after_submit; 

                    function ajax_after_submit(){
                        $("#MyMusic").html('');
                        $.ajax({
                            url: "<?php echo base_url('backoffice/dashboard/notifikasi_after_submit');?>",
                            type: "GET",
                            dataType: 'JSON',
                            success: function(response){
                                if(response.status){
                                    var data_notif = response.data;
                                    var nomor = 0;
                                    $.each(data_notif, function(index, value){                                        
                                        nomor++;
                                        new PNotify({
                                              title: value.title,
                                              text: value.text,
                                              type: 'info',
                                              addclass: 'dark'
                                          });      

                                        //if(nomor == 1){
                                            var html ='<audio autoplay>'+
                                                      '<source src="<?php echo base_url('assets/backoffice/assets/message_recieved.mp3');?>" type="audio/mpeg">'+
                                                    '</audio>';
                                            $("#MyMusic").append(html);
                                        //}                                  
                                    });
                                }
                            },
                            error: function() {
                                console.log("ERROR");
                            }
                        });
                    }
                    notifikasi_after_submit = setInterval(function(){ ajax_after_submit() }, 5000);            

                    // function reset_ajax_notifikasi_after_submit(){
                    //     clearTimeout(notifikasi_after_submit);
                    //     auto_ajax_notifikasi_after_submit();
                    // }
                }
                auto_ajax_notifikasi_after_submit();
            });
        </script>
    </body>
</html>