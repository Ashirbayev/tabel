<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>KADROBOT - система управления кадрами</title>

    <link href="styles/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="font-awesome/styles/css/font-awesome.css" rel="stylesheet"/>

    <link href="styles/css/plugins/iCheck/custom.css" rel="stylesheet"/>

    <link href="styles/css/plugins/chosen/chosen.css" rel="stylesheet"/>

    <link href="styles/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>

    <link href="styles/css/plugins/cropper/cropper.min.css" rel="stylesheet"/>

    <link href="styles/css/plugins/switchery/switchery.css" rel="stylesheet"/>

    <link href="styles/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet"/>

    <link href="styles/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet"/>

    <link href="styles/css/plugins/datapicker/datepicker3.css" rel="stylesheet"/>

    <link href="styles/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet"/>
    <link href="styles/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet"/>

    <link href="styles/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet"/>

    <link href="styles/css/plugins/clockpicker/clockpicker.css" rel="stylesheet"/>

    <link href="styles/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet"/>

    <link href="styles/css/plugins/select2/select2.min.css" rel="stylesheet"/>

    <link href="styles/css/animate.css" rel="stylesheet"/>
    <link href="styles/css/style.css" rel="stylesheet"/>

</head>

<body class="gray-bg back-change">
    <div class="middle-box text-center loginscreen animated fadeInDown">
            <a href="/">
                <img src="../styles/img/logo.png"/>
            </a>
            <p>Создайте Вашу компанию, заполнив поля ниже</p>
            <form method="post">
                <div class="form-group">
                    <input type="text" <?php //echo $s; ?> autocomplete="on" class="form-control" placeholder="Название компании" name="comp_name" required=""/>
                </div>
                <div class="form-group">
                    <input type="text" <?php //echo $s; ?> autocomplete="on" class="form-control" placeholder="Страна" name="country" required=""/>
                </div>
                <div class="form-group">
                    <input type="text" <?php //echo $s; ?> autocomplete="on" class="form-control" placeholder="Город" name="city" required=""/>
                </div>
                <div class="form-group">
                    <select data-placeholder="Сфера деятельности" class="chosen-select" style="width:100%;" name="oked" required>
                        <option></option>
                        <?php
                            foreach
                            ($emp_oked as $k => $v)
                            {
                        ?>
                                <option value="<?php echo $v['OKED']; ?>"><?php echo $v['NAME_OKED']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="url_request" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <input type="submit" class="btn btn-primary block full-width m-b" value="Зарегистрировать"/>
            </form>
            <p class="text-muted text-center"><small>Не создали аккаунт?<a href="register"> сделайте это сейчас</a></small></p>
            <a class="btn btn-sm btn-white btn-block" href="login">Войти</a>
            <p class="m-t"> <small>Разработано LetSoft.art &copy; 2018</small> </p>
    </div>
            
    <!-- Mainly scripts -->
    <script src="styles/js/jquery-2.1.1.js"></script>
    <script src="styles/js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="styles/js/inspinia.js"></script>
    <script src="styles/js/plugins/pace/pace.min.js"></script>
    <script src="styles/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Chosen -->
    <script src="styles/js/plugins/chosen/chosen.jquery.js"></script>

   <!-- JSKnob -->
   <script src="styles/js/plugins/jsKnob/jquery.knob.js"></script>

   <!-- Input Mask-->
    <script src="styles/js/plugins/jasny/jasny-bootstrap.min.js"></script>

   <!-- Data picker -->
   <script src="styles/js/plugins/datapicker/bootstrap-datepicker.js"></script>

   <!-- NouSlider -->
   <script src="styles/js/plugins/nouslider/jquery.nouislider.min.js"></script>

   <!-- Switchery -->
   <script src="styles/js/plugins/switchery/switchery.js"></script>

    <!-- IonRangeSlider -->
    <script src="styles/js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

    <!-- iCheck -->
    <script src="styles/js/plugins/iCheck/icheck.min.js"></script>

    <!-- MENU -->
    <script src="styles/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Color picker -->
    <script src="styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <!-- Clock picker -->
    <script src="styles/js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Image cropper -->
    <script src="styles/js/plugins/cropper/cropper.min.js"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="styles/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="styles/js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 -->
    <script src="styles/js/plugins/select2/select2.full.min.js"></script>

    <script>
        $(document).ready(function(){

            var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1.618,
                preview: ".img-preview",
                done: function(data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function() {
                window.open($image.cropper("getDataURL"));
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function() {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function() {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function() {
                $image.cropper("setDragMode", "crop");
            });

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            var elem_2 = document.querySelector('.js-switch_2');
            var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.demo1').colorpicker();

            var divStyle = $('.back-change')[0].style;
            $('#demo_apidemo').colorpicker({
                color: divStyle.backgroundColor
            }).on('changeColor', function(ev) {
                        divStyle.backgroundColor = ev.color.toHex();
                    });

            $('.clockpicker').clockpicker();

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2020',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            $(".select2_demo_3").select2({
                placeholder: "Select a state",
                allowClear: true
            });


        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        $("#ionrange_1").ionRangeSlider({
            min: 0,
            max: 5000,
            type: 'double',
            prefix: "$",
            maxPostfix: "+",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_2").ionRangeSlider({
            min: 0,
            max: 10,
            type: 'single',
            step: 0.1,
            postfix: " carats",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_3").ionRangeSlider({
            min: -50,
            max: 50,
            from: 0,
            postfix: "°",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_4").ionRangeSlider({
            values: [
                "January", "February", "March",
                "April", "May", "June",
                "July", "August", "September",
                "October", "November", "December"
            ],
            type: 'single',
            hasGrid: true
        });

        $("#ionrange_5").ionRangeSlider({
            min: 10000,
            max: 100000,
            step: 100,
            postfix: " km",
            from: 55000,
            hideMinMax: true,
            hideFromTo: false
        });

        $(".dial").knob();

        $("#basic_slider").noUiSlider({
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min':  20,
                'max':  80
            }
        });

        $("#range_slider").noUiSlider({
            start: [ 40, 60 ],
            behaviour: 'drag',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });

        $("#drag-fixed").noUiSlider({
            start: [ 40, 60 ],
            behaviour: 'drag-fixed',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });


    </script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.3/form_advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 13:13:50 GMT -->
</html>
