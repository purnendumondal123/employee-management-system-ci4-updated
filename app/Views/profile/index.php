<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<div class="d-flex">

    <?= $this->include('layouts/sidebar') ?>

    <div class="content flex-grow-1 p-4 bg-light">

        <h3>My Profile</h3>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- PROFILE IMAGE SHOW -->
        <div class="card p-4 mb-3 text-center">

            <?php if (!empty($user['profile_photo'])): ?>

                <img src="<?= base_url('uploads/profile/' . $user['profile_photo']) ?>"
                    width="120"
                    height="120"
                    class="rounded-circle border">

            <?php else: ?>

                <img src="<?= base_url('uploads/profile/default.png') ?>"
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

            <form action="<?= site_url('profile/update') ?>" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text"
                        name="first_name"
                        value="<?= esc($user['first_name']) ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text"
                        name="last_name"
                        value="<?= esc($user['last_name']) ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text"
                        name="mobile"
                        value="<?= esc($user['mobile']) ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date"
                        name="dob"
                        value="<?= esc($user['dob']) ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea
                        name="address"
                        rows="4"
                        class="form-control"><?= esc($user['address']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Profile
                </button>

            </form>

        </div>

        <br>

        <!-- UPLOAD PHOTO -->
        <div class="card p-4">

            <h5>Upload Profile Photo</h5>

            <form action="<?= site_url('profile/upload-photo') ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <input type="file"
                    name="profile_photo"
                    class="form-control mb-3">

                <button type="submit" class="btn btn-success">
                    Upload Photo
                </button>

            </form>

        </div>

    </div>

</div>

<?= $this->include('layouts/footer') ?>