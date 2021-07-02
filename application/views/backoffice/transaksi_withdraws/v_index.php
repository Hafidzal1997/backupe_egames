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
                <div class="accordion mb-3" id="accordion">
                    <div class="card">
                        <div class="card-header bg-dark px-3 py-2">
                            <a role="tab" id="heading-filter" data-toggle="collapse" data-parent="#accordion" href="#collapse-filter" aria-expanded="true" aria-controls="collapse-filter">
                                <h4 class="text-white">
                                    <i class="fa fa-filter"></i> Filter Data
                                </h4>
                            </a>
                        </div>
                        <div id="collapse-filter" class="collapse" aria-labelledby="heading-filter">
                            <div class="card-body border-bottom">
                                <form class="form-horizontal" id="form_filter" method="post" action="<?php echo base_url('backoffice/transaksi-withdraws/export-excel');?>">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 font-weight-bold">Status</label>
                                        <div class="col-md-5">
                                            <select id="flag_status" class="form-control">
                                                <option value="">- Pilih Status -</option>
                                                <option value="A">Accepted</option>
                                                <option value="W">Waiting</option>
                                                <option value="R">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 font-weight-bold">Client</label>
                                        <div class="col-md-5">
                                            <select id="clients_id" name="clients_id" class="form-control">
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
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3 col-sm-3 font-weight-bold">
                                            Filter By Waktu Withdraw
                                        </label>
                                        <div class="col-lg-5 col-sm-9">
                                            <div class="row">
                                                <div class="col-2 col-sm-2 text-center pt-2">
                                                    <label for="filter_created_at">
                                                        <input type="checkbox" id="filter_created_at" name="filter_created_at" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                                    </label>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="created_at_awal" value="<?php echo date('01/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-created-at-awal">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="created_at_akhir" value="<?php echo date('t/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-created-at-akhir">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                      
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3 col-sm-3 font-weight-bold">
                                            Filter By Waktu Accepted
                                        </label>
                                        <div class="col-lg-5 col-sm-9">
                                            <div class="row">
                                                <div class="col-2 col-sm-2 text-center pt-2">
                                                    <label for="filter_accepted_at">
                                                        <input type="checkbox" id="filter_accepted_at" name="filter_accepted_at" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                                    </label>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="accepted_at_awal" value="<?php echo date('01/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-accepted-at-awal">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="accepted_at_akhir" value="<?php echo date('t/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-accepted-at-akhir">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                      
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3 col-sm-3 font-weight-bold">
                                            Filter By Waktu Rejected
                                        </label>
                                        <div class="col-lg-5 col-sm-9">
                                            <div class="row">
                                                <div class="col-2 col-sm-2 text-center pt-2">
                                                    <label for="filter_rejected_at">
                                                        <input type="checkbox" id="filter_rejected_at" name="filter_rejected_at" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                                    </label>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="rejected_at_awal" value="<?php echo date('01/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-rejected-at-awal">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-5 col-sm-5">
                                                    <div class="input-group date">
                                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="rejected_at_akhir" value="<?php echo date('t/m/Y');?>" disabled>
                                                        <span class="input-group-addon input-group-rejected-at-akhir">
                                                            <span class="fa fa-calendar py-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                      
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3 col-sm-3 font-weight-bold">
                                            Filter By Hapus Data
                                        </label>
                                        <div class="col-lg-5 col-sm-9">
                                            <div class="row">
                                                <div class="col-2 col-sm-2 text-center pt-2">
                                                    <label for="flag_delete">
                                                        <input type="checkbox" id="flag_delete" name="flag_delete" value="1" title="KLIK DISINI UNTUK MENAMPILKAN DATA YANG SUDAH DIHAPUS">
                                                    </label>
                                                </div>
                                                <div class="col-10 col-sm-10 pt-2">
                                                    <label for="flag_delete">
                                                        <small>CENTANG UNTUK MENAMPILKAN DATA YANG TELAH DIHAPUS</small>
                                                    </label>
                                                </div>
                                            </div>                      
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                         <div class="col-md-3"></div>
                                         <div class="col-md-5 text-center">
                                             <button type="button" class="btn btn-secondary btn-filter">
                                                 <i class="fa fa-filter"></i> Filter Data
                                             </button>
                                             <button type="button" class="btn btn-outline btn-warning btn-reset text-white">
                                                 <i class="fa fa-reply"></i> Reset Filter
                                             </button>                                 
                                            <button type="button" class="btn btn-success btn-export">
                                                 <i class="fa fa-file-excel-o"></i> Export Data
                                            </button>
                                         </div>
                                     </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if($roles_id == 1){?>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger btn-hapus-terpilih" title="Hapus Data Terpilih" disabled>
                                <i class="fa fa-trash-o"></i> Hapus Terpilih
                            </button>
                        </div>
                    </div>
                    
                <?php } ?>

                <form id="MyFormTable">
                    <div class="table-responsive">
                       <table id="MyTable" class="table table-hover table-bordered table-striped dt-responsive nowrap jambo_table bulk_action" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th class="no-sort">No</th>
                                   <th class="no-sort">
                                        <input type="checkbox" name="posting_all" id="posting_all" title="CLICK HERE TO CHECK ALL IN CURRENT PAGE">
                                   </th>
                                   <th>Kode Member /<br>Nama Member /<br>Nama Client</th>
                                   <th>Waktu Withdraw</th>
                                   <th>Jumlah Withdraw</th>
                                   <th>Nama Permainan</th>
                                   <th>No. Rek Bank /<br> A.n Rek Bank</th>
                                   <th>Status</th>
                                   <th class="no-sort">Opsi</th>
                               </tr>
                           </thead>
                           <tbody></tbody>
                       </table>
                   </div>                       
                </form>                
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        /*
        |--------------------------------------------------------------------------
        | DATATABLES
        |--------------------------------------------------------------------------
        */
        var dataTable = $('#MyTable').DataTable({
            "serverSide": true,
            "stateSave" : false,
            "bAutoWidth": true,
            "oLanguage": {
                "sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
                "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman ",
                "sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                "sInfoFiltered": "(difilter dari _MAX_ total data)", 
                "sZeroRecords": "Pencarian tidak ditemukan", 
                "sEmptyTable": "Data kosong", 
                "sLoadingRecords": "Harap Tunggu...", 
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aaSorting": [[ 7, "asc" ]],
            "columnDefs": [ 
                {"aTargets":[0], "width" : 50, "sClass": "text-center"},
                {"aTargets":[1], "width" : 20, "sClass": "text-center"},
                {"aTargets":[2], "width" : 160},
                {"aTargets":[3], "width" : 70, "sClass": "text-center"},
                {"aTargets":[4], "sClass": "text-right"},
                {"aTargets":[5], "width" : 100},
                {"aTargets":[6], "width" : 100},
                {"aTargets":[7], "width" : 70, "sClass": "text-center"},
                {"aTargets":[8], "width" : 70, "sClass": "text-center"},
                {"targets": 'no-sort', "orderable": false,}
            ],
            "sPaginationType": "simple_numbers", 
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            "ajax":{
                url :"<?php echo base_url('backoffice/transaksi-withdraws/withdraws_json'); ?>",
                type: "POST",
                "data": function (data) {
                    data.flag_status = $("#flag_status").val();
                    data.clients_id = $("#clients_id").val();
                    data.flag_delete = $("input[name='flag_delete']:checked").val();

                    data.filter_created_at = $("input[name='filter_created_at']:checked").val();
                    data.created_at_awal = $('#created_at_awal').val();
                    data.created_at_akhir = $('#created_at_akhir').val();

                    data.filter_accepted_at = $("input[name='filter_accepted_at']:checked").val();
                    data.accepted_at_awal = $('#accepted_at_awal').val();
                    data.accepted_at_akhir = $('#accepted_at_akhir').val();

                    data.filter_rejected_at = $("input[name='filter_rejected_at']:checked").val();
                    data.rejected_at_awal = $('#rejected_at_awal').val();
                    data.rejected_at_akhir = $('#rejected_at_akhir').val();
                },
                error: function(){ 
                    console.log("ERROR DATA");
                }
            }, "rowCallback": function(row,data,index,iDisplayIndexFull){
                    if(data[9] == 'Y'){
                        $('td', row).css({'background-color': '#e87c87', 'color': '#FFFFFF'});
                    } else{
                        //$('td', row).addClass('bg-warning');
                    }
            }
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK FILTER
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-filter",function() {
            dataTable.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK CLEAR/RESET FORM FILTER
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-reset",function() {
            $('#filter_created_at').prop('checked', false);
            $('#filter_accepted_at').prop('checked', false);
            $('#filter_rejected_at').prop('checked', false);
            $('#form_filter')[0].reset();
            dataTable.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK EXPORT DATA
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-export",function() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang diproses akan di export sesuai dengan filter yang dilakukan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#26B99A',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_filter').submit();
                    dataTable.ajax.reload();
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY STATUS PENDAFTARAN
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#flag_status", function() {
            dataTable.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY CLIENT
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#clients_id", function() {
            dataTable.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY HAPUS DATA
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#flag_delete", function() {
            dataTable.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY WAKTU DAFTAR
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#filter_created_at",function() {
            var created_at = $("input[name='filter_created_at']:checked").val();
            if(created_at){
                $("#created_at_awal").attr('disabled', false);
                $("#created_at_akhir").attr('disabled', false);
            } else {
                $("#created_at_awal").attr('disabled', true);
                $("#created_at_akhir").attr('disabled', true);
            }
            dataTable.ajax.reload();
        });

        $(document).on("change","#created_at_awal",function() {
            dataTable.ajax.reload();
        });

        $(document).on("change","#created_at_akhir",function() {
            dataTable.ajax.reload();
        });

        $(document).on("click",".input-group-created-at-awal",function() {
            $('#created_at_awal').focus();
        });        

        $(document).on("click",".input-group-created-at-akhir",function() {
            $('#created_at_akhir').focus();
        });

        $('#created_at_awal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date('<?php echo date('Y-m-d', strtotime('-1 days'));?>'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#created_at_akhir').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date('<?php echo date('Y-m-d', strtotime('-1 days'));?>'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY WAKTU ACCEPTED
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#filter_accepted_at",function() {
            var accepted_at = $("input[name='filter_accepted_at']:checked").val();
            if(accepted_at){
                $("#accepted_at_awal").attr('disabled', false);
                $("#accepted_at_akhir").attr('disabled', false);
            } else {
                $("#accepted_at_awal").attr('disabled', true);
                $("#accepted_at_akhir").attr('disabled', true);
            }
            dataTable.ajax.reload();
        });

        $(document).on("change","#accepted_at_awal",function() {
            dataTable.ajax.reload();
        });

        $(document).on("change","#accepted_at_akhir",function() {
            dataTable.ajax.reload();
        });

        $(document).on("click",".input-group-accepted-at-awal",function() {
            $('#accepted_at_awal').focus();
        });        

        $(document).on("click",".input-group-accepted-at-akhir",function() {
            $('#accepted_at_akhir').focus();
        });

        $('#accepted_at_awal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date('<?php echo date('Y-m-d', strtotime('-1 days'));?>'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#accepted_at_akhir').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY WAKTU REJECTED
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#filter_rejected_at",function() {
            var rejected_at = $("input[name='filter_rejected_at']:checked").val();
            if(rejected_at){
                $("#rejected_at_awal").attr('disabled', false);
                $("#rejected_at_akhir").attr('disabled', false);
            } else {
                $("#rejected_at_awal").attr('disabled', true);
                $("#rejected_at_akhir").attr('disabled', true);
            }
            dataTable.ajax.reload();
        });

        $(document).on("change","#rejected_at_awal",function() {
            dataTable.ajax.reload();
        });

        $(document).on("change","#rejected_at_akhir",function() {
            dataTable.ajax.reload();
        });

        $(document).on("click",".input-group-rejected-at-awal",function() {
            $('#rejected_at_awal').focus();
        });        

        $(document).on("click",".input-group-rejected-at-akhir",function() {
            $('#rejected_at_akhir').focus();
        });

        $('#rejected_at_awal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date('<?php echo date('Y-m-d', strtotime('-1 days'));?>'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#rejected_at_akhir').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            maxDate: new Date('<?php echo date('Y-m-d', strtotime('-1 days'));?>'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        /*
        |--------------------------------------------------------------------------
        | CHECKBOX ITEM HAPUS
        |--------------------------------------------------------------------------
        */
        var select_all = document.getElementById("posting_all");
        var checkboxes = document.getElementsByClassName("posting");

        select_all.addEventListener("change", function(e){
            for (i = 0; i < checkboxes.length; i++) { 
                checkboxes[i].checked = select_all.checked;
            }

            if(document.querySelectorAll('.posting:checked').length){
                $('.btn-hapus-terpilih').attr('disabled', false);
            } else {
                $('.btn-hapus-terpilih').attr('disabled', true);
            }
        });

        $(document).on("click", ".paginate_button",function() {
            select_all.checked = false;

            if(document.querySelectorAll('.posting:checked').length){
                $('.btn-hapus-terpilih').attr('disabled', false);
            } else {
                $('.btn-hapus-terpilih').attr('disabled', true);
            }
        });
        
        $(document).on("change", ".posting",function() {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', function(e){
                    if(this.checked == false){
                        select_all.checked = false;
                    }
                    if(document.querySelectorAll('.posting:checked').length == checkboxes.length){
                        select_all.checked = true;
                    }
                });
            }

            if(document.querySelectorAll('.posting:checked').length){
                $('.btn-hapus-terpilih').attr('disabled', false);
            } else {
                $('.btn-hapus-terpilih').attr('disabled', true);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | AKSI UNTUK HAPUS DENGAN CHECKBOX
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-hapus-terpilih", function() {
            
            if(document.querySelectorAll('.posting:checked').length == 0){
                Swal.fire('Mohon Maaf!','Tidak ada item yang dipilih!', 'warning');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : "<?php echo base_url('backoffice/transaksi-withdraws/delete_all');?>",
                        type: 'POST',
                        data: $("#MyFormTable").serialize(),
                        dataType: "JSON",
                        success: function(response){
                            if(response.status){                            
                                Swal.fire('Terhapus!', 'Data berhasil dihapus!', 'success');
                                dataTable.ajax.reload();
                                select_all.checked = false;
                                $('.btn-hapus-terpilih').attr('disabled', true);
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
        | AKSI UNTUK HAPUS DENGAN TOMBOL
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-delete", function() {
            var get_url = $(this).data('url');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : get_url,
                        type: 'GET',
                        dataType: "JSON",
                        success: function(response){
                            if(response.status){                            
                                Swal.fire('Terhapus!', 'Data berhasil dihapus!', 'success');
                                dataTable.ajax.reload();
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
        | AKSI UNTUK RESTRORE DENGAN TOMBOL
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-restore", function() {
            var get_url = $(this).data('url');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang diproses akan di pulihkan kembali",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#73879C',
                confirmButtonText: 'Ya, Pulihkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : get_url,
                        type: 'GET',
                        dataType: "JSON",
                        success: function(response){
                            if(response.status){                            
                                Swal.fire('Sukses!', 'Data berhasil dipulihkan!', 'success');
                                dataTable.ajax.reload();
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
        | AKSI UNTUK MENYETUJUI
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-accept", function() {
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
                                dataTable.ajax.reload();
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
        $(document).on("click", ".btn-reject", function() {
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
                                dataTable.ajax.reload();
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
