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
                <div class="form-group row">
                    <label class="control-label col-md-3">
                        <strong>
                            Status
                        </strong>
                    </label>
                    <div class="col-md-4">
                        <select id="flag_active" class="form-control">
                            <option value="">- Pilih Status -</option>
                            <option value="Y">Aktif</option>
                            <option value="N">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3">
                        <strong>
                            Kategori Permainan
                        </strong>
                    </label>
                    <div class="col-md-4">
                        <select id="permainans_categories_id" class="form-control">
                            <option value="">- Pilih Kategori Permainan -</option>
                            <?php
                            if($kategori){
                                foreach($kategori as $row){
                                    echo '<option value="'.$row->id.'">'.$row->nama_kategori_permainan.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url('backoffice/permainans/add');?>" class="btn btn-dark" title="Tambah Data">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        <button type="button" class="btn btn-danger btn-hapus-terpilih" title="Hapus Data Terpilih" disabled>
                            <i class="fa fa-trash-o"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>
                <form id="MyFormTable">
                    <div class="table-responsive">
                       <table id="MyTable" class="table table-hover table-bordered table-striped dt-responsive nowrap jambo_table bulk_action" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th class="no-sort">No</th>
                                   <th class="no-sort">
                                        <input type="checkbox" name="posting_all" id="posting_all" title="CLICK HERE TO CHECK ALL IN CURRENT PAGE">
                                   </th>
                                   <th>Nama Permainan</th>
                                   <th>Kategori Permainan</th>
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
            "aaSorting": [[ 2, "asc" ]],
            "columnDefs": [ 
                {"aTargets":[0], "width" : 50, "sClass": "text-center"},
                {"aTargets":[1], "width" : 20, "sClass": "text-center"},
                {"aTargets":[3], "width" : 200, "sClass": "text-left"},
                {"aTargets":[4], "width" : 100, "sClass": "text-center"},
                {"aTargets":[5], "width" : 70, "sClass": "text-center"},
                {"targets": 'no-sort', "orderable": false,}
            ],
            "sPaginationType": "simple_numbers", 
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            "ajax":{
                url :"<?php echo base_url('backoffice/permainans/permainans_json'); ?>",
                type: "POST",
                "data": function (data) {
                    data.flag_active = $("#flag_active").val();
                    data.permainans_categories_id = $("#permainans_categories_id").val();
                },
                error: function(){ 
                    console.log("ERROR DATA");
                }
            }
        });

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

        $(document).on("change", "#flag_active", function() {
            dataTable.ajax.reload();
        });

        $(document).on("change", "#permainans_categories_id", function() {
            dataTable.ajax.reload();
        });

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
                        url : "<?php echo base_url('backoffice/permainans/delete_all');?>",
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
    });
</script>
