<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .register-box {
            width: 550px;
            margin: auto;
            margin-top: 40px;
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

        <div class="register-box">

            <div class="card">

                <div class="card-body p-4">

                    <h3 class="text-center mb-4">
                        Employee Registration
                    </h3>

                    <!-- AJAX Response -->
                    <div id="responseMessage"></div>

                    <form id="registerForm">

                        <?= csrf_field() ?>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="firstname"
                                    name="firstname"
                                    class="form-control"
                                    autocomplete="given-name">

                                <div
                                    class="invalid-feedback"
                                    id="firstnameError">
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="lastname"
                                    name="lastname"
                                    class="form-control"
                                    autocomplete="family-name">

                                <div
                                    class="invalid-feedback"
                                    id="lastnameError">
                                </div>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Employee Code
                            </label>

                            <input
                                type="text"
                                id="employee_code"
                                name="employee_code"
                                class="form-control">

                            <div
                                class="invalid-feedback"
                                id="employeeCodeError">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                autocomplete="email">

                            <div
                                class="invalid-feedback"
                                id="emailError">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Mobile Number
                            </label>

                            <input
                                type="text"
                                id="mobile"
                                name="mobile"
                                class="form-control"
                                autocomplete="tel">

                            <div
                                class="invalid-feedback"
                                id="mobileError">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                autocomplete="new-password">

                            <div
                                class="invalid-feedback"
                                id="passwordError">
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                id="confirm_password"
                                name="confirm_password"
                                class="form-control"
                                autocomplete="new-password">

                            <div
                                class="invalid-feedback"
                                id="confirmPasswordError">
                            </div>

                        </div>

                        <div class="form-check mb-3">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="showPassword">

                            <label
                                class="form-check-label"
                                for="showPassword">

                                Show Password

                            </label>

                        </div>

                        <button
                            type="submit"
                            id="registerBtn"
                            class="btn btn-primary w-100">

                            Register

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="<?= site_url('/') ?>">

                            Already have an account? Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Show / Hide Password
        $('#showPassword').change(function() {

            let type = $(this).is(':checked') ? 'text' : 'password';

            $('#password').attr('type', type);

            $('#confirm_password').attr('type', type);

        });


        // Register Form Submit
        $('#registerForm').submit(function(e) {

            e.preventDefault();

            // Reset Validation
            $('.form-control').removeClass('is-invalid');

            $('#firstnameError').html('');
            $('#lastnameError').html('');
            $('#employeeCodeError').html('');
            $('#emailError').html('');
            $('#mobileError').html('');
            $('#passwordError').html('');
            $('#confirmPasswordError').html('');
            $('#responseMessage').html('');

            $('#registerBtn').prop('disabled', true);
            $('#registerBtn').text('Please wait...');

            $.ajax({

                url: "<?= site_url('register') ?>",

                type: "POST",

                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },

                data: $(this).serialize(),

                dataType: "json",

                success: function(response) {

                    $('#registerBtn').prop('disabled', false);
                    $('#registerBtn').text('Register');

                    // Success
                    if (response.status) {

                        $('#responseMessage').html(
                            '<div class="alert alert-success">' +
                            response.message +
                            '</div>'
                        );

                        setTimeout(function() {

                            window.location.href = response.redirect;

                        }, 1000);

                        return;
                    }

                    // Validation Errors
                    if (response.errors) {

                        if (response.errors.firstname) {
                            $('#firstname').addClass('is-invalid');
                            $('#firstnameError').html(response.errors.firstname);
                        }

                        if (response.errors.lastname) {
                            $('#lastname').addClass('is-invalid');
                            $('#lastnameError').html(response.errors.lastname);
                        }

                        if (response.errors.employee_code) {
                            $('#employee_code').addClass('is-invalid');
                            $('#employeeCodeError').html(response.errors.employee_code);
                        }

                        if (response.errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#emailError').html(response.errors.email);
                        }

                        if (response.errors.mobile) {
                            $('#mobile').addClass('is-invalid');
                            $('#mobileError').html(response.errors.mobile);
                        }

                        if (response.errors.password) {
                            $('#password').addClass('is-invalid');
                            $('#passwordError').html(response.errors.password);
                        }

                        if (response.errors.confirm_password) {
                            $('#confirm_password').addClass('is-invalid');
                            $('#confirmPasswordError').html(response.errors.confirm_password);
                        }

                    }

                    // Other Error
                    if (response.message) {

                        $('#responseMessage').html(
                            '<div class="alert alert-danger">' +
                            response.message +
                            '</div>'
                        );

                    }

                },

                error: function(xhr) {

                    $('#registerBtn').prop('disabled', false);

                    $('#registerBtn').text('Register');

                    $('#responseMessage').html(
                        '<div class="alert alert-danger">Something went wrong.</div>'
                    );

                    console.log(xhr.responseText);

                }

            });

        });
    </script>