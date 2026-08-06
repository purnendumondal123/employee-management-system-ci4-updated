<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<div class="d-flex">

    <?= $this->include('layouts/sidebar') ?>

    <div class="content flex-grow-1 p-4 bg-light">

        <h3>My Profile</h3>

        <!-- PROFILE IMAGE SHOW -->
        <div class="card p-4 mb-3 text-center">

            <?php if (!empty($user['profile_photo'])): ?>

                <img id="profileImage"
                    src="<?= base_url('uploads/profile/' . $user['profile_photo']) ?>"
                    width="120"
                    height="120"
                    class="rounded-circle border">

            <?php else: ?>

                <img id="profileImage"
                    src="<?= base_url('uploads/profile/default.png') ?>"
                    width="120"
                    height="120"
                    class="rounded-circle border">

            <?php endif; ?>

            <h5 class="mt-2">
                <?= esc($user['first_name'] . ' ' . $user['last_name']) ?>
            </h5>

        </div>

        <!-- UPDATE PROFILE -->
        <div class="card p-4">

            <h5 class="mb-3">Update Profile</h5>

            <div id="profileMsg"></div>

            <form id="profileForm" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">First Name</label>

                    <input type="text"
                        name="first_name"
                        id="first_name"
                        value="<?= esc($user['first_name']) ?>"
                        class="form-control">

                    <small class="text-danger error_first_name"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>

                    <input type="text"
                        name="last_name"
                        id="last_name"
                        value="<?= esc($user['last_name']) ?>"
                        class="form-control">

                    <small class="text-danger error_last_name"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>

                    <input type="text"
                        name="mobile"
                        id="mobile"
                        value="<?= esc($user['mobile']) ?>"
                        class="form-control">

                    <small class="text-danger error_mobile"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>

                    <input
                        type="date"
                        name="dob"
                        id="dob"
                        value="<?= esc($user['dob']) ?>"
                        max="<?= date('Y-m-d', strtotime('-18 years')) ?>"
                        class="form-control"
                        onkeydown="return false">

                    <small class="text-danger error_dob"></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>

                    <textarea
                        name="address"
                        id="address"
                        rows="4"
                        class="form-control"><?= esc($user['address']) ?></textarea>

                    <small class="text-danger error_address"></small>
                </div>

                <button class="btn btn-primary" id="updateProfile">
                    Update Profile
                </button>

            </form>

        </div>

        <br>

        <!-- UPLOAD PHOTO -->
        <div class="card p-4">

            <h5>Upload Profile Photo</h5>

            <form id="photoForm" enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div id="photoMsg"></div>

                <input type="file"
                    name="profile_photo"
                    id="profile_photo"
                    class="form-control mb-2">


                <button type="submit" class="btn btn-success">
                    Upload Photo
                </button>
                <small class="text-danger error_photo"></small>

            </form>

        </div>

    </div>

</div>


<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {

        $("#profileForm").submit(function(e) {

            e.preventDefault();

            $(".text-danger").html("");
            $("#profileMsg").html("");

            $.ajax({

                url: "<?= site_url('profile/update') ?>",

                type: "POST",

                data: $(this).serialize(),

                dataType: "json",

                success: function(response) {
                    console.log(response);

                    if (response.status === false) {

                        if (response.errors.first_name) {
                            $(".error_first_name").html(response.errors.first_name);
                        }

                        if (response.errors.last_name) {
                            $(".error_last_name").html(response.errors.last_name);
                        }

                        if (response.errors.mobile) {
                            $(".error_mobile").html(response.errors.mobile);
                        }

                        if (response.errors.dob) {
                            $(".error_dob").html(response.errors.dob);
                        }

                        if (response.errors.address) {
                            $(".error_address").html(response.errors.address);
                        }

                    } else {

                        $("#profileMsg").html(
                            '<div class="alert alert-success">' +
                            response.message +
                            '</div>'
                        );

                    }

                }

            });

        });

        $("#photoForm").submit(function(e) {

            e.preventDefault();

            $(".error_photo").html("");
            $("#photoMsg").html("");

            let formData = new FormData(this);

            $.ajax({

                url: "<?= site_url('profile/upload-photo') ?>",

                type: "POST",

                data: formData,

                processData: false,

                contentType: false,

                dataType: "json",

                success: function(response) {

                    console.log(response);

                    if (response.status === false) {

                        $(".error_photo").html(response.errors.profile_photo);

                    } else {

                        $("#photoMsg").html(
                            '<div class="alert alert-success">' +
                            response.message +
                            '</div>'
                        );

                        // File input clear
                        $("#profile_photo").val("");

                        // Profile image instantly change
                        $("#profileImage").attr(
                            "src",
                            response.image + "?t=" + new Date().getTime()
                        );

                    }

                }

            });

        });

    });
</script>

<?= $this->endSection() ?>

<?= $this->include('layouts/footer') ?>