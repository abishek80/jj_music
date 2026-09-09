
                </div>
            </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="<?php echo base_url(); ?>themes/js/toastr.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/jquery.sweet-alert.custom.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/lightbox-plus-jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/dropzone.js"></script>
    
    <script src="<?php echo base_url(); ?>themes/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/config.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/jquery.ajax.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/js/menu.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/main.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/ui-popover.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>themes/datatable/js/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/datatable/js/jspdf.umd.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/datatable/js/jspdf.plugin.autotable.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/select2.full.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/lightbox.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/flatpickr.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/date-picker.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/html2pdf.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/magnifypopup.js"></script>

    <script>
        function oneClickSubmitBtn() {
            $('form').on('submit', function(event) {
                const submitButton = $(this).find('button[type="submit"]'); // Select the submit button within the form
                submitButton.prop('disabled', true); // Disable the button
                submitButton.text('Submitting...'); // Optional: Change button text
            });
        }
        
        const inputFields = document.querySelectorAll('input[type="text"], textarea');

        inputFields.forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
            });
        });

        // Function to format number as Indian numbering system
        function formatIndianNumber(number) {
            const parts = number.split(".");
            const intPart = parts[0];
            const decPart = parts.length > 1 ? "." + parts[1] : "";
            const lastThree = intPart.substring(intPart.length - 3);
            const otherNumbers = intPart.substring(0, intPart.length - 3);
            const formattedNumber = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + lastThree + decPart;
            return formattedNumber.startsWith(",") ? formattedNumber.substring(1) : formattedNumber;
        }

        $(document).ready(function() {
            // Get the div and format its content
            $('.amount-format').each(function() {
                var number = $(this).text();
                var formattedNumber = formatIndianNumber(number);
                $(this).text(formattedNumber);
            });
        });

        
        $(document).ready(function() {
            var table = $('.zero_config').DataTable();
        });

        $(window).on('load', function() {
            $('.loader').hide();
        });

        $('.zero_config').DataTable();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(".select2").select2({
            allowClear: true
        });
        $(".multiple.select2").select2({
            allowClear: true
        });

        $(document).on("input", ".decimal", function(evt){
            var self = $(this);
            var currentValue = self.val();
            var sanitizedValue = currentValue.replace(/[^0-9.]/g, '');
            var decimalIndex = sanitizedValue.indexOf('.');

            if (decimalIndex !== -1) {
                var beforeDecimal = sanitizedValue.substr(0, decimalIndex);
                var afterDecimal = sanitizedValue.substr(decimalIndex + 1);
                afterDecimal = afterDecimal.replace('.', '');
                sanitizedValue = beforeDecimal + '.' + afterDecimal;
            }
            if (decimalIndex !== -1 && sanitizedValue.length - decimalIndex > 4) {
                sanitizedValue = sanitizedValue.substr(0, decimalIndex + 4);
            }
        
            self.val(sanitizedValue);
            if ((evt.which !== 46 || sanitizedValue.indexOf('.') !== -1) && (evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
        });
        
        $(document).on("input", ".text-only", function(evt) {
            var self = $(this);
            var currentValue = self.val();
            var sanitizedValue = currentValue.replace(/[0-9]/g, '');
            self.val(sanitizedValue);
        });

        $(document).on("input", ".number-only", function(evt) {
            var self = $(this);
            self.val(self.val().replace(/\D/g, ""));
            if ((evt.which < 48 || evt.which > 57)) {
                evt.preventDefault();
            }
        });
        
        $(document).on('click', '.trashItem', function(e) {
            var fieldId = $(this).data("rowid");
            var tableName = $(this).data("tablename");
            var link = $(this).data("link");
            swal({
                title: "Are You Sure Delete?",
                text: "You Will Not Be Able To Recover This Data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete It!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRFToken": csrftoken
                    },
                    url: '<?php echo base_url(); ?>deleteRecord/',
                    dataType: "json",
                    data: {
                        fieldId, 
                        tableName
                    },
                    success: function(data) {
                        toastr.options = {
                            'closeButton': true,
                            'debug': false,
                            'newestOnTop': false,
                            'progressBar': false,
                            'positionClass': 'toast-top-right',
                            'preventDuplicates': false,
                            'showDuration': '1000',
                            'hideDuration': '1000',
                            'timeOut': '5000',
                            'extendedTimeOut': '1000',
                            'showEasing': 'swing',
                            'hideEasing': 'linear',
                            'showMethod': 'fadeIn',
                            'hideMethod': 'fadeOut',
                        }
                        if (data['isError']) {
                            toastr.error(data['message']);
                        } else {
                            swal("Deleted!", (data['message']), "success");
                            setTimeout(function () {
                                window.location.href = link;
                            }, 1500);
                        }
                    }
                });
            });
        });
        
        $(document).on('click', '.changeStatus', function(e) {
            var fieldId = $(this).data("rowid");
            var tableName = $(this).data("tablename");
            var statusValue = $(this).data("value");
            var link = $(this).data("link");
            swal({
                title: "Are You Change The Status?",
                text: "You Will Change The Bill Status!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Changed!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRFToken": csrftoken
                    },
                    url: '<?php echo base_url(); ?>changeStatus',
                    dataType: "json",
                    data: {
                        fieldId, 
                        tableName,
                        statusValue
                    },
                    success: function(data) {
                        toastr.options = {
                            'closeButton': true,
                            'debug': false,
                            'newestOnTop': false,
                            'progressBar': false,
                            'positionClass': 'toast-top-right',
                            'preventDuplicates': false,
                            'showDuration': '1000',
                            'hideDuration': '1000',
                            'timeOut': '5000',
                            'extendedTimeOut': '1000',
                            'showEasing': 'swing',
                            'hideEasing': 'linear',
                            'showMethod': 'fadeIn',
                            'hideMethod': 'fadeOut',
                        }
                        if (data['isError']) {
                            toastr.error(data['message']);
                        } else {
                            swal("Changed!", (data['message']), "success");
                            setTimeout(function () {
                                window.location.href = link;
                            }, 1500);
                        }
                    }
                });
            });
        });
        
        $(document).on('click', '.trashBillItem', function(e) {
            var fieldId = $(this).data("rowid");
            var tableName = $(this).data("tablename");
            var secondaryTable = $(this).data("secondarytable");
            var link = $(this).data("link");
            swal({
                title: "Are You Sure Delete?",
                text: "You Will Not Be Able To Recover This Data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRFToken": csrftoken
                    },
                    url: '<?php echo base_url(); ?>deletesellingBill/',
                    dataType: "json",
                    data: {
                        fieldId, 
                        tableName,
                        secondaryTable
                    },
                    success: function(data) {
                        toastr.options = {
                            'closeButton': true,
                            'debug': false,
                            'newestOnTop': false,
                            'progressBar': false,
                            'positionClass': 'toast-top-right',
                            'preventDuplicates': false,
                            'showDuration': '1000',
                            'hideDuration': '1000',
                            'timeOut': '5000',
                            'extendedTimeOut': '1000',
                            'showEasing': 'swing',
                            'hideEasing': 'linear',
                            'showMethod': 'fadeIn',
                            'hideMethod': 'fadeOut',
                        }
                        if (data['isError']) {
                            toastr.error(data['message']);
                        } else {
                            swal("Deleted!", (data['message']), "success");
                            setTimeout(function () {
                                window.location.href = link;
                            }, 1500);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>