<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/jquery-ui.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/script.js"></script>


<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo current_url();?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="container pt-4">
                                <!-- <?php 
                                include './forms/'.$code.'.html';
                                ?> -->
                                <div class="w-100 d-flex justify-content-center">
                                    <button class="btn btn-primary" form="form-data" id="">Sumbit</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
<script>
                                var form_code = "<?php echo $code ?>";
                            </script>
                            <script>
                                
                                $(function() {
                                    $('#form-field form').prepend("<input type='hidden' name='form_code' value='" + form_code + "'/>")
                                    $('#form-buidler-action').remove()
                                    $('.question-item .card-footer, .item-move,[name="choice"],.add_chk, .add_radio,.rem-on-display').remove()
                                    $('[contenteditable]').each(function() {
                                        $(this).removeAttr('contenteditable')
                                    })
                                    $('.form-check label').click(function() {
                                        if ($(this).siblings('input').is(":checked") == true) {
                                            $(this).siblings('input').prop("checked", false).trigger('change')
                                        } else {
                                            $(this).siblings('input').prop("checked", true).trigger('change')
                                        }
                                    })
                                    $('.choice-field input[type="checkbox"][required="required"]').each(function() {
                                        $(this).closest('.choice-field').attr("data-required", true)
                                    })
                                    $('.choice-field input[type="checkbox"]').change(function() {
                                        var _req = $(this).closest('.choice-field').attr("data-required")
                                        if (_req == "true") {
                                            if ($(this).closest('.choice-field').find('input[type="checkbox"]:checked').length > 0) {
                                                $(this).closest('.choice-field').find('input[type="checkbox"]').attr('required', false)
                                            } else {
                                                $(this).closest('.choice-field').find('input[type="checkbox"]').attr('required', true)
                                            }
                                        }
                                    })
                                    $('#save_response').click(function() {
                                        $('#form-field form').submit()
                                    })
                                    $('#form-field form').submit(function(e) {
                                        e.preventDefault()
                                        start_loader();
                                        $.ajax({
                                            url: "classes/Forms.php?a=save_response",
                                            method: 'POST',
                                            data: new FormData($(this)[0]),
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            method: 'POST',
                                            type: 'POST',
                                            dataType: 'json',
                                            error: err => {
                                                console.log(err)
                                                alert("an error occured")
                                            },
                                            success: function(resp) {
                                                if (typeof resp == 'object' && resp.status == 'success') {
                                                    alert("Form successfully Submitted")
                                                    location.reload()
                                                } else {
                                                    console.log(resp)
                                                    alert("an error occured")
                                                }
                                                end_loader()
                                            }
                                        })
                                    })

                                })
                            </script>