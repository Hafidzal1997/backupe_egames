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
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo current_url();?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                        
                            <!--Form BuilderJS -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
                            <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

                            <script>
                                jQuery(function ($) {
                                    $(document.getElementById('fb-editor')).formBuilder();
                                });
                            </script>

                            <!-- <div class="container">
                                <div class="row"> -->
                                    <!-- <div class="col-md-12"> -->
                                        <div class="card">
                                            <div class="card-body">
                                            <p class="card-text">
                                                <div id="fb-editor"></div>
                                            </p>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                <!-- </div>
                            </div> -->

                            <!-- Optional JavaScript -->
                            <!-- Popper.js, then Bootstrap JS -->
                            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
                            </script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
                            </script>
                        </form>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>