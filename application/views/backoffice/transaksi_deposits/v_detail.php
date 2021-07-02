<form action="<?php echo current_url();?>" method="post" enctype="multipart/form-data">
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Kode Member
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->kode_member ? $edit->kode_member : '-');?>
        </div>
    </div> 
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nama Client
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nama_client ? $edit->nama_client : '-');?>
        </div>
    </div> 
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nama Member
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nama_lengkap ? $edit->nama_lengkap : '-');?>
        </div>
    </div>                              
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Jumlah Deposit
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo number_format( $edit->jumlah_deposit);?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nama Permainan
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nama_permainan ? $edit->nama_permainan : '-');?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nama Bank
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nama_bank ? $edit->nama_bank : '-');?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nomor Rekening Bank
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nomor_rekening_bank ? $edit->nomor_rekening_bank : '-');?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Nama Rekening Bank
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->nama_rekening_bank ? $edit->nama_rekening_bank : '-');?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Waktu Submit
        </label>
        <div class="col-md-9 col-sm-9">
            <?php echo ($edit->created_at ? date('d M Y, H:i:s',strtotime($edit->created_at)) : '-');?>
        </div>
    </div>
    <div class="form-group row ">
        <label class="control-label col-md-3 font-weight-bold">
            Status
        </label>
        <div class="col-md-9 col-sm-9">
            <?php
            if($edit->flag_status == 'A'){
                $flag_status = '<div class="text-center text-success font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    ACCEPTED
                                    <br>
                                    <small>
                                        '.date('d M Y', strtotime($edit->accepted_at)).'
                                        <br>
                                        '.date('H:i:s', strtotime($edit->accepted_at)).'
                                    </small>
                                </div>';
            } else if($edit->flag_status == 'W'){
                $flag_status = '<div class="text-center text-warning font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    WAITING
                                </div>';
            } else {
                $flag_status = '<div class="text-center text-danger font-weight-bold">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                    REJECTED
                                    <br>
                                    <small>
                                        '.date('d M Y', strtotime($edit->rejected_at)).'
                                        <br>
                                        '.date('H:i:s', strtotime($edit->rejected_at)).'
                                    </small>
                                </div>';
            }

            echo $flag_status;
            ?>
        </div>
    </div>
</form>
<script>
    $("#MyModalDetailNotifikasiTitle").html('Detail Notifikasi Deposit');

     $(document).ready(function() {
        var url_edit    = '<?php echo base_url('backoffice/transaksi-deposits/edit/' . encode($edit->id));?>';
        var url_accept  = '<?php echo base_url('backoffice/transaksi-deposits/accept/' . encode($edit->id));?>';
        var url_reject  = '<?php echo base_url('backoffice/transaksi-deposits/reject/' . encode($edit->id));?>';

        $(".btn-modal-edit").attr('href', url_edit);
        $(".btn-modal-edit").show();
        $(".btn-modal-accept").hide();
        $(".btn-modal-reject").hide();

        <?php if($edit->flag_status == 'A'){ ?> 


        <?php } elseif($edit->flag_status == 'W'){ ?>
            
            $(".btn-modal-accept").show();
            $(".btn-modal-accept").attr('data-url', url_accept);

            $(".btn-modal-reject").show();
            $(".btn-modal-reject").attr('data-url', url_reject);

        <?php } else { ?>

            $(".btn-modal-accept").show();
            $(".btn-modal-accept").attr('data-url', url_accept);

        <?php } ?>

        function append_data(){
            var get_url_detail_append = '<?php echo base_url('backoffice/transaksi-deposits/detail-append/' . encode($edit->id));?>';
            $.get(get_url_detail_append, function(response) {
                $("#Deposit_<?php echo $edit->id;?>").html(response); 
            });
        }

        /*
        |--------------------------------------------------------------------------
        | AKSI UNTUK MENYETUJUI
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-modal-accept", function() {
            var get_url = $(this).data('url');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang telah disetujui tidak dapat diubah statusnya kembali",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#26B99A',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : get_url,
                        type: 'GET',
                        dataType: "JSON",
                        success: function(response){
                            if(response.status == 1){                            
                                Swal.fire('Sukses!', 'Data berhasil disetujui!', 'success');
                                $("#MyModalDetailNotifikasi").modal('hide');
                                
                                append_data();

                                $(".btn-modal-edit").hide();
                                $(".btn-modal-accept").hide();
                                $(".btn-modal-reject").hide();

                            } else if(response.status == 2){
                                Swal.fire('Mohon Maaf!','Limit Counter Kode Member Habis! Silahkan Contact Administrator!', 'warning');
                            } else {
                                Swal.fire('Error!','Please Contact Administrator!', 'warning');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire('Error!',errorThrown, 'warning');
                        }
                    });
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | AKSI UNTUK MENOLAK
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-modal-reject", function() {
            var get_url = $(this).data('url');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang diproses akan di reject",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Reject!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : get_url,
                        type: 'GET',
                        dataType: "JSON",
                        success: function(response){
                            if(response.status){                            
                                Swal.fire('Sukses!', 'Data berhasil direject!', 'success');
                                $("#MyModalDetailNotifikasi").modal('hide');

                                append_data();

                                $(".btn-modal-edit").hide();
                                $(".btn-modal-accept").hide();
                                $(".btn-modal-reject").hide();
                            } else {
                                Swal.fire('Error!','Please Contact Administrator!', 'warning');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire('Error!',errorThrown, 'warning');
                        }
                    });
                }
            });
        });
    });
</script>