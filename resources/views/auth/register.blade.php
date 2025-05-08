<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Register</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Register</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Create a new account</p>

                <form action="{{ route('auth.postregister') }}" method="POST" id="form-register">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" id="nama" name="nama" class="form-control"
                            placeholder="Full Name">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <small id="error-nama" class="error-text text-danger"></small>

                    <div class="input-group mb-3">
                        <select name="level_id" id="level_id" class="form-control">
                            <option value="">-- Select Level --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-layer-group"></span></div>
                        </div>
                    </div>
                    <small id="error-level_id" class="error-text text-danger"></small>

                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>

                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>

                    <div class="input-group mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <a href="{{ route('auth.login') }}">Already have an account? Login</a>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("#form-register").validate({
                rules: {
                    nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    level_id: {
                        required: true
                    },
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#password'
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
                                    title: 'Success',
                                    text: response.message
                                }).then(() => {
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(field, msg) {
                                        $('#error-' + field).text(msg[0]);
                                    });
                                }
                                if (response.message && response.message.includes(
                                        'username')) {
                                    $('#error-username').text('Username sudah digunakan');
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
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
                    element.closest('.input-group').append(error);
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
</body>

</html>
