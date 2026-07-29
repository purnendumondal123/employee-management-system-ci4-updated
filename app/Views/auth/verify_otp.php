<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify OTP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .otp-box {
            width: 420px;
            margin: auto;
            margin-top: 80px;
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

        <div class="otp-box">

            <div class="card">

                <div class="card-body p-4">

                    <h3 class="text-center mb-2">

                        Verify OTP

                    </h3>

                    <p class="text-center text-muted mb-4">

                        Enter the 6 digit OTP sent to your email.

                    </p>

                    <!-- AJAX Response -->
                    <div id="responseMessage"></div>

                    <form id="otpForm">

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label class="form-label">

                                OTP

                            </label>

                            <input
                                type="text"
                                name="otp"
                                id="otp"
                                maxlength="6"
                                class="form-control"
                                placeholder="Enter 6 digit OTP">

                            <div
                                class="invalid-feedback"
                                id="otpError">
                            </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            id="verifyBtn">

                            Verify OTP

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="<?= site_url('register') ?>">

                            Back to Registration

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $('#otpForm').submit(function(e) {

            e.preventDefault();

            $('#otp').removeClass('is-invalid');

            $('#otpError').html('');

            $('#responseMessage').html('');

            $('#verifyBtn').prop('disabled', true);

            $('#verifyBtn').text('Verifying...');

            $.ajax({

                url: "<?= site_url('verify-otp') ?>",

                type: "POST",

                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },

                data: $(this).serialize(),

                dataType: "json",

                success: function(response) {

                    $('#verifyBtn').prop('disabled', false);

                    $('#verifyBtn').text('Verify OTP');

                    if (response.status) {

                        $('#responseMessage').html(
                            '<div class="alert alert-success">' + response.message + '</div>'
                        );

                        setTimeout(function() {

                            window.location.href = response.redirect;

                        }, 1000);

                        return;

                    }

                    if (response.errors) {

                        if (response.errors.otp) {

                            $('#otp').addClass('is-invalid');

                            $('#otpError').html(response.errors.otp);

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

                error: function() {

                    $('#verifyBtn').prop('disabled', false);

                    $('#verifyBtn').text('Verify OTP');

                    $('#responseMessage').html(
                        '<div class="alert alert-danger">Something went wrong.</div>'
                    );

                }

            });

        });
    </script>

</body>

</html>