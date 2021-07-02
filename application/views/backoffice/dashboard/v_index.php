<div class="page-title">
    <div class="title_left">
        <h3><small><?php echo $title;?></small></h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <form class="form-horizontal" id="form_filter">
                    <div class="row">
                        <div class="col-md-7">                            
                            <div class="form-group row">
                                <label class="control-label col-lg-3 col-sm-2 font-weight-bold">
                                    Filter Periode
                                </label>
                                <div class="col-lg-9 col-sm-10">
                                    <div class="row">
                                        <div class="col-2 col-sm-2 text-center pt-2">
                                            <label for="filter_tanggal">
                                                <input type="checkbox" id="filter_tanggal" name="filter_tanggal" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL" checked>
                                            </label>
                                        </div>
                                        <div class="col-5 col-sm-5">
                                            <div class="input-group date">
                                                <input onkeydown="event.preventDefault()" type="text" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo date('d/m/Y');?>">
                                                <span class="input-group-addon input-group-tanggal-awal">
                                                    <span class="fa fa-calendar py-1"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-5 col-sm-5">
                                            <div class="input-group date">
                                                <input onkeydown="event.preventDefault()" type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo date('d/m/Y');?>">
                                                <span class="input-group-addon input-group-tanggal-akhir">
                                                    <span class="fa fa-calendar py-1"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                      
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">                            
                            <div class="form-group row">
                                <label class="control-label col-lg-2 col-md-2 font-weight-bold">Client</label>
                                <div class="col-lg-10 col-md-10">
                                    <select id="clients_id" name="clients_id" class="form-control" onchange="ajax_summary_dashboard()">
                                        <option value="">- Pilih Client -</option>
                                        <?php
                                        if($clients){
                                            foreach($clients as $row_client){
                                                echo '<option value="'.$row_client->id.'">'.$row_client->nama.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="MyProgressBar"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-users"></i></div>
            <div class="count"><small id="total_member_terdaftar">0</small></div>
            <h3><small>Total Member</small></h3>
            <p class="font-weight-bolder">Total seluruh member dalam sistem.</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-money"></i></div>
            <div class="count"><small id="total_deposit_disetujui">0</small></div>
            <h3><small>Total Deposit</small></h3>
            <p class="font-weight-bolder">Total deposit disetujui.</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-money"></i></div>
            <div class="count"><small id="total_withdraw_disetujui">0</small></div>
            <h3><small>Total Withdraw</small></h3>
            <p class="font-weight-bolder">Total withdraw disetujui.</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-user-md"></i></div>
            <div class="count"><small id="total_member_disetujui">0</small></div>
            <h3><small>Total Member Disetujui</small></h3>
            <p class="font-weight-bolder">Total member disetujui.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <?php
                $jam = date('H');
                $ses_nama   = $this->session->userdata('nama');

                if($jam >= 18){
                    $salam = 'Selamat Malam,';
                } else if($jam >= 15){
                    $salam = 'Selamat Sore,';
                } else if($jam >= 11){
                    $salam = 'Selamat Siang,';
                } else {
                    $salam = 'Selamat Pagi,';
                }

                echo $salam .' ' . $ses_nama;
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    var progress_bar = '<div class="text-center text-primary font-weight-bold">'+
                            '<div class="progress">'+
                                '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'+
                            '</div>'+
                            'LOADING DATA'+
                        '</div>';
    $("#MyProgressBar").html(progress_bar);

    $(document).ready(function() {

        $('#tanggal_awal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#tanggal_akhir').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | FILTER PERIODE
    |--------------------------------------------------------------------------
    */
    $(document).on("change", "#filter_tanggal",function() {
        var created_at = $("input[name='filter_tanggal']:checked").val();
        if(created_at){
            $("#tanggal_awal").attr('disabled', false);
            $("#tanggal_akhir").attr('disabled', false);
        } else {
            $("#tanggal_awal").attr('disabled', true);
            $("#tanggal_akhir").attr('disabled', true);
        }
        ajax_summary_dashboard();
    });

    $(document).on("change","#tanggal_awal",function() {
        ajax_summary_dashboard();
    });

    $(document).on("change","#tanggal_akhir",function() {
        ajax_summary_dashboard();
    });

    $(document).on("click",".input-group-tanggal-awal",function() {
        $('#tanggal_awal').focus();
    });        

    $(document).on("click",".input-group-tanggal-akhir",function() {
        $('#tanggal_akhir').focus();
    });

    function ajax_summary_dashboard(){
        $("#MyProgressBar").show();
        $.ajax({
            url : "<?php echo base_url('backoffice/dashboard/ajax_summary_dashboard');?>",
            type: 'POST',
            data: $("#form_filter").serialize(),
            dataType: "JSON",
            success: function(response){
                if(response.status){                            
                    $("#total_member_disetujui").html(response.total_member_disetujui);
                    $("#total_withdraw_disetujui").html(addCommas(response.total_withdraw_disetujui));
                    $("#total_deposit_disetujui").html(addCommas(response.total_deposit_disetujui));
                    $("#total_member_terdaftar").html(response.total_member_terdaftar);
                    $("#MyProgressBar").hide();
                } else {
                    $("#MyProgressBar").hide();
                    Swal.fire('Error!','Please Contact Administrator!', 'warning');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!',errorThrown, 'warning');
            }
        });
    }
    ajax_summary_dashboard();

    /*
    |--------------------------------------------------------------------------
    | HELPER COMMAS MONEY
    |--------------------------------------------------------------------------
    */
    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>