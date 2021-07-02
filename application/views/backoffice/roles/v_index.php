<div class="page-title">
    <div class="title_left">
        <h3>
            <small><?php echo $title;?></small>
        </h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <a href="<?php echo base_url('backoffice/roles/add')?>" class="btn btn-dark">
                    <i class="fa fa-plus"></i> Tambah
                </a>
                <div class="table-responsive">
                   <table id="MyTable" class="table table-hover table-bordered table-striped dt-responsive nowrap jambo_table bulk_action" cellspacing="0" width="100%">
                       <thead>
                           <tr>
                               <th class="no-sort">No</th>
                               <th>Kode</th>
                               <th>Nama Role</th>
                               <th class="no-sort">Opsi</th>
                           </tr>
                       </thead>
                       <tbody></tbody>
                   </table>
               </div>                   
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
            "aaSorting": [[ 1, "asc" ]],
            "columnDefs": [ 
                {"aTargets":[0], "width" : 50, "sClass": "text-center"},
                {"aTargets":[1], "width" : 50, "sClass": "text-center"},
                {"aTargets":[3], "width" : 100, "sClass": "text-center"},
                {"targets": 'no-sort', "orderable": false,}
            ],
            "sPaginationType": "simple_numbers", 
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            "ajax":{
                url :"<?php echo base_url('backoffice/roles/roles_json'); ?>",
                type: "POST",
                error: function(){ 
                    console.log("ERROR DATA");
                }
            }
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
