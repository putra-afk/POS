@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data User</h3>
        </div>
        <div class="card-body">
            @empty($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
                <a href="{{ url('/user') }}" class="btn btn-sm btn-default mt-2">Return</a>
            @else
                <form method="POST" action="{{ url('/user/' . $user->user_id . '/update_ajax') }}" class="form-horizontal"
                    id="form-edit">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">User Level</label>
                        <div class="col-10">
                            <select name="level_id" id="level_id" class="form-control" required>
                                <option value="">- Select Level -</option>
                                @foreach ($level as $l)
                                    <option value="{{ $l->level_id }}" {{ $l->level_id == $user->level_id ? 'selected' : '' }}>
                                        {{ $l->level_name }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-level_id" class="form-text text-danger error-text"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Username</label>
                        <div class="col-10">
                            <input value="{{ $user->username }}" type="text" name="username" id="username"
                                class="form-control" required>
                            <small id="error-username" class="form-text text-danger error-text"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Name</label>
                        <div class="col-10">
                            <input value="{{ $user->nama }}" type="text" name="nama" id="nama" class="form-control"
                                required>
                            <small id="error-nama" class="form-text text-danger error-text"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Password</label>
                        <div class="col-10">
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="form-text text-muted">Ignore if you don't want to change the password</small>
                            <small id="error-password" class="form-text text-danger error-text"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-10 offset-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="{{ url('/user') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    level_id: {
                        required: true,
                        number: true
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    password: {
                        minlength: 6,
                        maxlength: 20
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succeed',
                                    text: response.message
                                });
                                window.location.href = "{{ url('/user') }}";
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Something Went Wrong',
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
@endpush
