<form action="{{ route('level.store_ajax') }}" method="POST" id="form-add">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Level</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Level</label>
                    <input type="text" name="level" id="level" class="form-control" required>
                    <small id="error-level" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Name</label>
                    <input type="text" name="level_name" id="level_name" class="form-control" required>
                    <small id="error-level_name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Code</label>
                    <input type="text" name="level_code" id="level_code" class="form-control" required>
                    <small id="error-level_code" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-add").validate({
            rules: {
                level: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                level_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                level_code: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataLevel.ajax
                                .reload(); // pastikan kamu punya DataTable untuk level
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
