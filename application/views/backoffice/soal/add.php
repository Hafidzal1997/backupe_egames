<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/jquery-ui.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./DataTables/datatables.min.js"></script>
<script src="./js/script.js"></script>
<div class="page-title">
    <div class="title_left">
        <!-- <h3><small><?php echo $title;?></small></h3> -->
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="form-group row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url('backoffice/soal/manageforms');?>" class="btn btn-dark" title="Tambah Data">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="forms-tbl" class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DateTime</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>URL</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $no = 1;
                            foreach($clients as $row)
                            {
                                ?>
                                <tr>
                                    <td widtd="5%"><?php echo $no++; ?></td>
                                    <td><?php echo $row->date_created; ?></td>
                                    <td><?php echo $row->form_code; ?></td>
                                    <td><?php echo $row->title; ?></td>
                                    
                                    <td><a href="<?php echo base_url('backoffice/soal/form');?>">form.php?code=<?php echo $row->form_code ?></a></td>
                                    <!-- <td>
                                    <a href="<?php echo base_url(); ?>siswa/edit/<?php echo $row->kd_siswa; ?>" class="btn btn-warning">Edit</a>
                                    <a href="<?php echo base_url(); ?>siswa/delete/<?php echo $row->kd_siswa; ?>" class="btn btn-danger">Hapus</a>
                                    </td> -->
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>



                <script>
                    $(function(){
                        $('#forms-tbl').dataTable();
                        $('.rem_form').click(function(){
                            start_loader();
                            var _conf = confirm("Are you sure to delete this data?")
                            if(_conf == true){
                                $.ajax({
                                    url:'classes/Forms.php?a=delete_form',
                                    method:'POST',
                                    data:{form_code: $(this).attr('data-id')},
                                    dataType:'json',
                                    error:err=>{
                                        console.log(err)
                                        alert("an error occured")
                                    },
                                    success:function(resp){
                                        if(resp.status == 'success'){
                                            alert("Data successfully deleted");
                                            location.reload()
                                        }else{
                                            console.log(resp)
                                        alert("an error occured")
                                        }
                                    }
                                })
                            }
                            end_loader()
                        })
                    })
                </script>



                <script>
                    $(function(){
                        var page = "<?php echo $page ?>";

                        $('#nav-menu').find(".nav-item.nav-"+page).addClass("active")
                    })
                </script>
                            
            </div>
        </div>
    </div>
</div>