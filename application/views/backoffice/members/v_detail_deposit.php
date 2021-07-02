<div class="accordion mb-3" id="accordion_modal">
    <div class="card">
        <div class="card-header bg-dark  px-3 py-2">                            
            <a role="tab" id="heading-filter" data-toggle="collapse" data-parent="#accordion_modal" href="#collapse-filter-modal" aria-expanded="true" aria-controls="collapse-filter-modal">
                <h6 class="text-white">
                    <i class="fa fa-filter"></i> Filter Data
                </h6>
            </a>
        </div>
        <div id="collapse-filter-modal" class="collapse" aria-labelledby="heading-filter">
            <div class="card-body border-bottom">
                <form class="form-horizontal" id="form_filter_modal" method="post" action="<?php echo base_url('backoffice/deposits/export-excel');?>">
                    
                    <input type="hidden" name="kode_member" value="<?php echo $kode_member;?>">

                    <div class="form-group row">
                        <label class="control-label col-md-3 font-weight-bold">Status</label>
                        <div class="col-md-5">
                            <select id="flag_status_modal" class="form-control">
                                <option value="">- Pilih Status -</option>
                                <option value="A">Accepted</option>
                                <option value="W">Waiting</option>
                                <option value="R">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-3 col-sm-3 font-weight-bold">
                            Filter By Waktu Deposit
                        </label>
                        <div class="col-lg-5 col-sm-9">
                            <div class="row">
                                <div class="col-2 col-sm-2 text-center pt-2">
                                    <label for="filter_created_at_modal">
                                        <input type="checkbox" id="filter_created_at_modal" name="filter_created_at_modal" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                    </label>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="created_at_awal_modal" value="<?php echo date('01/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-created-at-awal-modal">
                                            <span class="fa fa-calendar py-1"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="created_at_akhir_modal" value="<?php echo date('t/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-created-at-akhir-modal">
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
                                    <label for="filter_accepted_at_modal">
                                        <input type="checkbox" id="filter_accepted_at_modal" name="filter_accepted_at_modal" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                    </label>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="accepted_at_awal" value="<?php echo date('01/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-accepted-at-awal-modal">
                                            <span class="fa fa-calendar py-1"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="accepted_at_akhir_modal" value="<?php echo date('t/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-accepted-at-akhir-modal">
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
                                    <label for="filter_rejected_at_modal">
                                        <input type="checkbox" id="filter_rejected_at_modal" name="filter_rejected_at_modal" value="1" title="KLIK DISINI UNTUK MENGAKTIFKAN PERIODE TANGGAL">
                                    </label>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="rejected_at_awal_modal" value="<?php echo date('01/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-rejected-at-awal-modal">
                                            <span class="fa fa-calendar py-1"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-5 col-sm-5">
                                    <div class="input-group date">
                                        <input onkeydown="event.preventDefault()" type="text" class="form-control" id="rejected_at_akhir_modal" value="<?php echo date('t/m/Y');?>" disabled>
                                        <span class="input-group-addon input-group-rejected-at-akhir-modal">
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
                                    <label for="flag_delete_modal">
                                        <input type="checkbox" id="flag_delete_modal" name="flag_delete_modal" value="1" title="KLIK DISINI UNTUK MENAMPILKAN DATA YANG SUDAH DIHAPUS">
                                    </label>
                                </div>
                                <div class="col-10 col-sm-10 pt-2">
                                    <label for="flag_delete_modal">
                                        <small>CENTANG UNTUK MENAMPILKAN DATA YANG TELAH DIHAPUS</small>
                                    </label>
                                </div>
                            </div>                      
                        </div>
                    </div>
                    <div class="row pt-1">
                         <div class="col-md-3"></div>
                         <div class="col-md-5 text-center">
                             <button type="button" class="btn btn-secondary btn-filter-modal">
                                 <i class="fa fa-filter"></i> Filter Data
                             </button>
                             <button type="button" class="btn btn-outline btn-warning btn-reset-modal text-white">
                                 <i class="fa fa-reply"></i> Reset Filter
                             </button>                                 
                            <button type="button" class="btn btn-success btn-export-modal">
                                 <i class="fa fa-file-excel-o"></i> Export Data
                            </button>
                         </div>
                     </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="MyFormTable">
    <div class="table-responsive">
       <table id="MyTableModal" class="table table-hover table-bordered table-striped dt-responsive nowrap jambo_table bulk_action" cellspacing="0" width="100%">
           <thead>
               <tr>
                   <th class="no-sort">No</th>
                   <th class="no-sort">
                        <input type="checkbox" name="posting_all" id="posting_all" title="CLICK HERE TO CHECK ALL IN CURRENT PAGE">
                   </th>
                   <th>Kode Member /<br>Nama Member /<br>Nama Client</th>
                   <th>Waktu Deposit</th>
                   <th>Jumlah Deposit</th>
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
<script>
    $(document).ready(function() {
        /*
        |--------------------------------------------------------------------------
        | DATATABLES
        |--------------------------------------------------------------------------
        */
        var dataTableModal = $('#MyTableModal').DataTable({
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
                {"aTargets":[1], "width" : 20, "sClass": "text-center", "visible": false},
                {"aTargets":[2], "width" : 160},
                {"aTargets":[3], "width" : 70, "sClass": "text-center"},
                {"aTargets":[4], "sClass": "text-right"},
                {"aTargets":[5], "width" : 150},
                {"aTargets":[6], "width" : 150},
                {"aTargets":[7], "width" : 70, "sClass": "text-center"},
                {"aTargets":[8], "width" : 70, "sClass": "text-center", "visible": false},
                {"targets": 'no-sort', "orderable": false,}
            ],
            "sPaginationType": "simple_numbers", 
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            "ajax":{
                url :"<?php echo base_url('backoffice/deposits/deposits_json'); ?>",
                type: "POST",
                "data": function (data) {
                    data.kode_member = "<?php echo $kode_member;?>";
                    data.flag_status = $("#flag_status_modal").val();
                    data.flag_delete = $("input[name='flag_delete_modal']:checked").val();

                    data.filter_created_at = $("input[name='filter_created_at_modal']:checked").val();
                    data.created_at_awal = $('#created_at_awal_modal').val();
                    data.created_at_akhir = $('#created_at_akhir_modal').val();

                    data.filter_accepted_at = $("input[name='filter_accepted_at_modal']:checked").val();
                    data.accepted_at_awal = $('#accepted_at_awal_modal').val();
                    data.accepted_at_akhir = $('#accepted_at_akhir_modal').val();

                    data.filter_rejected_at = $("input[name='filter_rejected_at_modal']:checked").val();
                    data.rejected_at_awal = $('#rejected_at_awal_modal').val();
                    data.rejected_at_akhir = $('#rejected_at_akhir_modal').val();
                },
                error: function(){ 
                    console.log("ERROR DATA");
                }
            }, "rowCallback": function(row,data,index,iDisplayIndexFull){
                    if(data[9] == 'Y'){
                        $('td', row).css({'background-color': '#e87c87', 'color': '#FFFFFF'});
                    }
            }
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK FILTER
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-filter-modal",function() {
            dataTableModal.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK CLEAR/RESET FORM FILTER
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-reset-modal",function() {
            $('#form_filter_modal')[0].reset();

            $('#filter_created_at_modal').prop('checked', false);
            $('#filter_accepted_at_modal').prop('checked', false);
            $('#filter_rejected_at_modal').prop('checked', false);

            $('#created_at_awal_modal').attr('disabled', true);
            $('#created_at_akhir_modal').attr('disabled', true);

            $('#accepted_at_awal_modal').attr('disabled', true);
            $('#accepted_at_akhir_modal').attr('disabled', true);

            $('#rejected_at_awal_modal').attr('disabled', true);
            $('#rejected_at_akhir_modal').attr('disabled', true);

            dataTableModal.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | TOMBOL UNTUK EXPORT DATA
        |--------------------------------------------------------------------------
        */
        $(document).on("click", ".btn-export-modal",function() {
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
                    $('#form_filter_modal').submit();
                    dataTableModal.ajax.reload();
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY STATUS PENDAFTARAN
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#flag_status_modal", function() {
            dataTableModal.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY HAPUS DATA
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#flag_delete_modal", function() {
            dataTableModal.ajax.reload();
        });

        /*
        |--------------------------------------------------------------------------
        | FILTER BY WAKTU DAFTAR
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#filter_created_at_modal",function() {
            var created_at = $("input[name='filter_created_at_modal']:checked").val();
            if(created_at){
                $("#created_at_awal_modal").attr('disabled', false);
                $("#created_at_akhir_modal").attr('disabled', false);
            } else {
                $("#created_at_awal_modal").attr('disabled', true);
                $("#created_at_akhir_modal").attr('disabled', true);
            }
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#created_at_awal_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#created_at_akhir_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("click",".input-group-created-at-awal-modal",function() {
            $('#created_at_awal_modal').focus();
        });        

        $(document).on("click",".input-group-created-at-akhir-modal",function() {
            $('#created_at_akhir_modal').focus();
        });

        $('#created_at_awal_modal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#created_at_akhir_modal').daterangepicker({
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
        | FILTER BY WAKTU ACCEPTED
        |--------------------------------------------------------------------------
        */
        $(document).on("change", "#filter_accepted_at_modal",function() {
            var accepted_at = $("input[name='filter_accepted_at_modal']:checked").val();
            if(accepted_at){
                $("#accepted_at_awal_modal").attr('disabled', false);
                $("#accepted_at_akhir_modal").attr('disabled', false);
            } else {
                $("#accepted_at_awal_modal").attr('disabled', true);
                $("#accepted_at_akhir_modal").attr('disabled', true);
            }
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#accepted_at_awal_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#accepted_at_akhir_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("click",".input-group-accepted-at-awal-modal",function() {
            $('#accepted_at_awal_modal').focus();
        });        

        $(document).on("click",".input-group-accepted-at-akhir-modal",function() {
            $('#accepted_at_akhir_modal').focus();
        });

        $('#accepted_at_awal_modal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#accepted_at_akhir_modal').daterangepicker({
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
        $(document).on("change", "#filter_rejected_at_modal",function() {
            var rejected_at = $("input[name='filter_rejected_at_modal']:checked").val();
            if(rejected_at){
                $("#rejected_at_awal_modal").attr('disabled', false);
                $("#rejected_at_akhir_modal").attr('disabled', false);
            } else {
                $("#rejected_at_awal_modal").attr('disabled', true);
                $("#rejected_at_akhir_modal").attr('disabled', true);
            }
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#rejected_at_awal_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("change","#rejected_at_akhir_modal",function() {
            dataTableModal.ajax.reload();
        });

        $(document).on("click",".input-group-rejected-at-awal-modal",function() {
            $('#rejected_at_awal_modal').focus();
        });        

        $(document).on("click",".input-group-rejected-at-akhir-modal",function() {
            $('#rejected_at_akhir_modal').focus();
        });

        $('#rejected_at_awal_modal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('#rejected_at_akhir_modal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            todayHighlight: true,
            autoclose: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });
</script>