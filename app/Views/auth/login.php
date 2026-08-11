<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .login-box {
            width: 420px;
            margin: 80px auto;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="login-box">

            <div class="card">

                <div class="card-body p-4">

                    <h3 class="text-center mb-4">

                        Employee Login

                    </h3>

                    <!-- AJAX Success / Error -->
                    <div id="responseMessage"></div>

                    <form id="loginForm" action="javascript:void(0)">

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label for="email" class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control">

                            <div class="invalid-feedback" id="emailError"></div>

                        </div>

                        <div class="mb-3">

                            <label for="password" class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control">

                            <div class="invalid-feedback" id="passwordError"></div>

                        </div>

                        <div class="form-check mb-3">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="showPassword">

                            <label class="form-check-label" for="showPassword">

                                Show Password

                            </label>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <a href="<?= site_url('forgot-password') ?>">

                                Forgot Password?

                            </a>

                            <a href="<?= site_url('register') ?>">

                                Create Account

                            </a>

                        </div>

                        <button type="submit" id="loginBtn" class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $('#showPassword').change(function() {

            let type = $(this).is(':checked') ? 'text' : 'password';

            $('#password').attr('type', type);

        });

        $('#loginForm').submit(function(e) {

            e.preventDefault();

            $('.form-control').removeClass('is-invalid');

            $('#emailError').html('');
            $('#passwordError').html('');
            $('#responseMessage').html('');

            $('#loginBtn').prop('disabled', true);
            $('#loginBtn').text('Please wait...');

            $.ajax({

                url: "<?= site_url('login') ?>",

                type: "POST",

                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },

                data: $(this).serialize(),

                dataType: "json",

                success: function(response) {

                    $('#loginBtn').prop('disabled', false);
                    $('#loginBtn').text('Login');

                    if (response.status) {

                        window.location.href = response.redirect;
                        return;

                    }

                    if (response.errors) {

                        if (response.errors.email) {

                            $('#email').addClass('is-invalid');
                            $('#emailError').html(response.errors.email);

                        }

                        if (response.errors.password) {

                            $('#password').addClass('is-invalid');
                            $('#passwordError').html(response.errors.password);

                        }

                    }

                    if (response.message) {

                        $('#responseMessage').html(
                            '<div class="alert alert-danger">' + response.message + '</div>'
                        );

                    }

                    if (response.redirect) {

                        setTimeout(function() {

                            window.location.href = response.redirect;

                        }, 1200);

                    }

                },

                error: function(xhr) {

                    console.log("Status:", xhr.status);
                    console.log("Response:", xhr.responseText);

                    $('#loginBtn').prop('disabled', false);
                    $('#loginBtn').text('Login');

                    $('#responseMessage').html(
                        '<div class="alert alert-danger">' + xhr.responseText + '</div>'
                    );
                }

            });

        });
    </script>

</body>

</html>