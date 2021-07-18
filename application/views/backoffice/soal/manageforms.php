<div class="page-title">
    <div class="title_left">
        <h3><small><?php echo $title;?></small></h3>
    </div>
</div>
<!-- 
<script src="<?php echo base_url('js/jquery-3.6.0.min.js');?>"></script>
<script src="<?php echo base_url('js/jquery-3.6.0.min.js');?>"></script> -->

<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/jquery-ui.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./DataTables/datatables.min.js"></script>
<script src="./js/script.js"></script>
<script>
    /* 
This Simple Form Builder was Developed by 
Carlo Montero
Posted/Published in: www.sourcecodester.com
*/
$(function() {

    $('#add_q-item').click(function(e) {
        var el = $('#q-item-clone').clone()
        var f_arr = []
        $('#question-field .question-item').each(function() {
            f_arr.push(parseInt($(this).attr('data-item')))
        })
        var i = f_arr.length
            // console.log(i)
        el.find('.question-item').attr('data-item', i)
        el.find('textarea').attr('name', 'q[' + i + ']')
        $('#question-field').append(el.html())
        $('body,html').animate({ scrollTop: $(this).offset().top }, 'fast')
        _initilize()
    })
    $('#question-field').sortable({
            handle: '.item-move',
            classes: {
                "ui-sortable": "highlight"
            }
        })
        // $("#question-field").disableSelection();

    function _initilize() {
        $('[contenteditable="true"]').each(function() {
            $(this).on("blur focusout", function() {
                if ($(this).text() == "") {
                    $(this).text($(this).attr("title"))
                }
            })

        })
        $('.question-item .form-check').find('label').on('keypress keyup paste cut', function() {
            $(this).siblings('input').val($(this).text())
        })
        $('.question-item .req-chk').click(function() {
            if ($(this).siblings('input[type="checkbox"]').is(":checked") == true) {
                $(this).siblings('input[type="checkbox"]').prop("checked", false).trigger("change")
            } else {
                $(this).siblings('input[type="checkbox"]').prop("checked", true).trigger("change")
            }
        })
        $('.rem-q-item').click(function() {
            $(this).closest('.question-item').remove()
        })
        $('.req-item').change(function() {
            var _parent = $(this).closest('.question-item')
            if ($(this).is(":checked") == true) {
                _parent.find("input").first().attr('required', true)
                _parent.find("textarea").first().attr('required', true)
                $(this).attr('checked', true)
            } else {
                _parent.find("input").first().attr('required', false)
                _parent.find("textarea").first().attr('required', false)
                $(this).attr('checked', false)
            }
        })

        $('.choice-option').change(function() {
            var choice = $(this).val()
            var field = $(this).closest('.question-item').attr('data-item')
            if (choice == "p") {
                paragraph($(this), field)
            } else if (choice == "checkbox") {
                $(this).closest('.question-item').find('.choice-field').html('<button type="button" class="add_chk btn btn-sm btn-default border"><i class="fa fa-plus"></i> Add option</button>')
                add_checkbox()
                for (var i = 0; i < 3; i++) {
                    checkboxfield($(this), field, "Enter Option")
                }
            } else if (choice == "radio") {
                $(this).closest('.question-item').find('.choice-field').html('<button type="button" class="add_radio btn btn-sm btn-default border"><i class="fa fa-plus"></i> Add option</button>')
                add_radio()
                for (var i = 0; i < 3; i++) {
                    radiofield($(this), field, "Enter Option")
                }
            } else if (choice == "file") {
                filefield($(this), field)
            }
            $(this).closest('.question-item').find('.req-item').trigger('change')
        })
    }

    function add_checkbox() {
        $('.add_chk').click(function() {
            var _this = $(this)
            var field = _this.closest('.question-item').attr('data-item')
            checkboxfield(_this, field, "Enter Option")
        })
    }

    function add_radio() {
        $('.add_radio').click(function() {
            var _this = $(this)
            var field = _this.closest('.question-item').attr('data-item')
            radiofield(_this, field, "Enter Option")
        })
    }

    function paragraph(_this, field) {
        var el = $('<textarea>')
        el.attr({
            "cols": 30,
            "rows": 5,
            "placeholder": "Write your answer here",
            "name": "q[" + field + "]",
            "class": "form-control col-sm-12"
        })
        _this.closest('.question-item').find('.choice-field').html(el)
    }

    function filefield(_this, field) {
        var el = $('<input>')
        el.attr({
            "type": "file",
            "name": "q[" + field + "]",
            "class": "form-control-file"
        })
        _this.closest('.question-item').find('.choice-field').html(el)
    }

    function checkboxfield(_this, field, text = "option") {
        var chk = $("<div>")
        var rem = $("<div>")
        chk.attr({
            "class": "col-sm-11 d-flex align-items-center",
        })
        rem.attr({
            "class": "col-sm-1 rem-on-display",
        })
        rem.append("<button class='btn btn-sm btn-default' type='button'><span class='fa fa-times'></span></button>")
        rem.attr('onclick', "$(this).closest('.row').remove()")
        var item = create_checkboxfield(field, text)
        chk.append(item)
        el = $("<div class='row w-100'>")
        el.append(rem)
        el.append(chk)
        _this.closest('.question-item').find('.choice-field .add_chk').before(el)
    }

    function radiofield(_this, field, text = "option") {
        var chk = $("<div>")
        var rem = $("<div>")
        chk.attr({
            "class": "col-sm-11 d-flex align-items-center",
        })
        rem.attr({
            "class": "col-sm-1 rem-on-display",
        })
        rem.append("<button class='btn btn-sm btn-default' type='button'><span class='fa fa-times'></span></button>")
        rem.attr('onclick', "$(this).closest('.row').remove()")
        var item = create_radiofield(field, text)
        chk.append(item)
        el = $("<div class='row w-100'>")
        el.append(rem)
        el.append(chk)
        _this.closest('.question-item').find('.choice-field .add_radio').before(el)
    }



    function create_checkboxfield(field, text) {

        var el = $('<div>')
        el.attr({
            "class": "form-check q-fc"
        })
        var inp = $('<input>')
        inp.attr({
            "class": "form-check-input",
            "name": "q[" + field + "][]",
            "type": "checkbox",
            "value": text
        })
        var label = $('<label>')
        label.attr({
            "class": "form-check-label",
            "contenteditable": true,
            "title": "Enter option here"
        })
        label.text(text)
        el.append(inp)
        el.append(label)
        return el
    }

    function create_radiofield(field, text) {

        var el = $('<div>')
        el.attr({
            "class": "form-check q-fc"
        })
        var inp = $('<input>')
        inp.attr({
            "class": "form-check-input",
            "name": "q[" + field + "]",
            "type": "radio",
            "value": text
        })
        var label = $('<label>')
        label.attr({
            "class": "form-check-label",
            "contenteditable": true,
            "title": "Enter option here"
        })
        label.text(text)
        el.append(inp)
        el.append(label)
        return el
    }
    _initilize()

    function save_form() {
        var new_el = $('<div>')
        var form_el = $('#form-field').clone()
        var form_code = $("[name='form_code']").length > 0 ? $("[name='form_code']").val() : "";
        var title = $('#form-title').text()
        var description = $('#form-description').text()
        form_el.find("[name='form_code']").remove()
        new_el.append(form_el)
        start_loader()
        $.ajax({
            url: "classes/Forms.php?a=save_form",
            method: 'POST',
            data: { form_data: new_el.html(), description: description, title: title, form_code: form_code },
            dataType: 'json',
            error: err => {
                console.log(err)
                alert("an error occured")
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert("Form successfully saved")
                    location.href = "./"
                } else {
                    console.log(resp)
                    alert("an error occured")
                }
                end_loader()
            }
        })
    }
    $('#save_form').click(function() {
        save_form()
    })
})
</script>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo current_url();?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                        
                            <div class="container" id="form-field">
                                <form id="form-data">
                                    <div class="row">
                                        <div class="card col-md-12 border">
                                            <div class="card-body">
                                                <h4 contenteditable="true" title="Enter Title" id="form-title">Enter Title Here</h4>
                                                <hr>
                                                <p contenteditable="true"  id="form-description" title="Enter Description" class="form-description">Enter Description Here</p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div>
                                        <div id="question-field" class='row ml-2 mr-2'>
                                            <div class="card mt-3 mb-3 col-md-12 question-item ui-state-default" data-item="0">
                                                <span class="item-move"><i class="fa fa-braille"></i></span>
                                                <div class="card-body">
                                                    <div class="row align-items-center d-flex">
                                                        <div class="col-sm-8">
                                                            <p class="question-text m-0" contenteditable="true" title="Write you question here">Write you question here</p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <select title="question choice type" name="choice" class='form-control choice-option'>
                                                                <option value="p">paragraph</option>
                                                                <option value="checkbox">Mupliple choice (multiple answer)</option>
                                                                <option value="radio">Mupliple choice (single answer)</option>
                                                                <option value="file">File upload</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr class="border-dark">
                                                    <div class="row ">
                                                        <div class="form-group choice-field col-md-12">
                                                            <textarea name="q[0]" class="form-control col-sm-12" cols="30" rows="5" placeholder="Write your answer here"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input req-item" type="checkbox" value="" >
                                                            <label class="form-check-label req-chk" for="">
                                                                * Requiruired
                                                            </label>
                                                        </div>
                                                        <button class="btn btn-default border rem-q-item" type="button"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-center" id="form-buidler-action">
                                        <button class="btn btn-default border mr-1" type="button" id="add_q-item"><i class="fa fa-plus"></i> Add Item</button>
                                        <button class="btn btn-default border ml-1" type="button" id="save_form"><i class="fa fa-save"></i> Save Form</button>
                                    </div>
                                </form>
                            </div>
                            <div class=" d-none" id = "q-item-clone">
                                <div class="card mt-3 mb-3 col-md-12 question-item ui-state-default" data-item="0">
                                    <span class="item-move"><i class="fa fa-braille"></i></span>
                                    <div class="card-body">
                                        <div class="row align-items-center d-flex">
                                            <div class="col-sm-8">
                                                <p class="question-text m-0" contenteditable="true" title="Write you question here">Write you question here</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <select title="question choice type" name="choice" class='form-control choice-option'>
                                                    <option value="p">paragraph</option>
                                                    <option value="checkbox">Mupliple choice (multiple answer)</option>
                                                    <option value="radio">Mupliple choice (single answer)</option>
                                                    <option value="file">File upload</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="border-dark">
                                        <div class="row ">
                                            <div class="form-group choice-field col-md-12">
                                                <textarea name="q[]" class="form-control col-sm-12" cols="30" rows="5" placeholder="Write your answer here"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input req-item" type="checkbox" value="" >
                                                <label class="form-check-label req-chk" for="">
                                                    * Requiruired
                                                </label>
                                            </div>
                                            <button class="btn btn-default border rem-q-item" type="button"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>