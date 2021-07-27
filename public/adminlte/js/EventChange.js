function deleteConfirmation(id) {
    swal({
        title: "Crer?",
        text: "Seguro desea crear este usuario",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, Create it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: !0,
    }).then(
        function (e) {
            if (e.value === true) {
                //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

                $.ajax({
                    type: "POST",
                    url: "{{url('/register')}}",
                    data: null,
                    dataType: "JSON",
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    },
                });
            } else {
                e.dismiss;
            }
        },
        function (dismiss) {
            return false;
        }
    );
}
