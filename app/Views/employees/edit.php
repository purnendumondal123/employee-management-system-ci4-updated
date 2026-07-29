<?= $this->include('layouts/header') ?>

<?= $this->include('layouts/navbar') ?>

<div class="d-flex">

    <?= $this->include('layouts/sidebar') ?>

    <div class="content flex-grow-1 p-4 bg-light" style="min-height:100vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Edit Employee
                </h2>

                <p class="text-muted mb-0">
                    Update employee information.
                </p>

            </div>

            <a href="<?= site_url('employees') ?>" class="btn btn-secondary">
                Back
            </a>

        </div>

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <form action="<?= site_url('employees/update/' . $employee['id']) ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Employee Code</label>

                            <input
                                type="text"
                                name="employee_code"
                                class="form-control <?= session('errors.employee_code') ? 'is-invalid' : '' ?>"
                                value="<?= old('employee_code', $employee['employee_code']) ?>">

                            <div class="invalid-feedback">
                                <?= session('errors.employee_code') ?>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Role</label>

                            <select
                                name="role"
                                class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>">

                                <option value="admin"
                                    <?= old('role', $employee['role']) == 'admin' ? 'selected' : '' ?>>
                                    Admin
                                </option>

                                <option value="employee"
                                    <?= old('role', $employee['role']) == 'employee' ? 'selected' : '' ?>>
                                    Employee
                                </option>

                            </select>

                            <div class="invalid-feedback">
                                <?= session('errors.role') ?>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">First Name</label>

                            <input
                                type="text"
                                name="firstname"
                                class="form-control <?= session('errors.firstname') ? 'is-invalid' : '' ?>"
                                value="<?= old('firstname', $employee['first_name']) ?>">

                            <div class="invalid-feedback">
                                <?= session('errors.firstname') ?>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Last Name</label>

                            <input
                                type="text"
                                name="lastname"
                                class="form-control <?= session('errors.lastname') ? 'is-invalid' : '' ?>"
                                value="<?= old('lastname', $employee['last_name']) ?>">

                            <div class="invalid-feedback">
                                <?= session('errors.lastname') ?>
                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                            value="<?= old('email', $employee['email']) ?>">

                        <div class="invalid-feedback">
                            <?= session('errors.email') ?>
                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Mobile Number</label>

                        <input
                            type="text"
                            name="mobile"
                            class="form-control <?= session('errors.mobile') ? 'is-invalid' : '' ?>"
                            value="<?= old('mobile', $employee['mobile']) ?>">

                        <div class="invalid-feedback">
                            <?= session('errors.mobile') ?>
                        </div>

                    </div>

                    <!-- Department & Designation -->

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Department</label>

                            <input
                                type="text"
                                name="department"
                                class="form-control <?= session('errors.department') ? 'is-invalid' : '' ?>"
                                value="<?= old('department', $employee['department']) ?>"
                                placeholder="Enter Department">

                            <div class="invalid-feedback">
                                <?= session('errors.department') ?>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Designation</label>

                            <input
                                type="text"
                                name="designation"
                                class="form-control <?= session('errors.designation') ? 'is-invalid' : '' ?>"
                                value="<?= old('designation', $employee['designation']) ?>"
                                placeholder="Enter Designation">

                            <div class="invalid-feedback">
                                <?= session('errors.designation') ?>
                            </div>

                        </div>

                    </div>

                    <!-- Salary & Joining Date -->

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Salary</label>

                            <input
                                type="number"
                                step="0.01"
                                name="salary"
                                class="form-control <?= session('errors.salary') ? 'is-invalid' : '' ?>"
                                value="<?= old('salary', $employee['salary']) ?>"
                                placeholder="Enter Salary">

                            <div class="invalid-feedback">
                                <?= session('errors.salary') ?>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Joining Date</label>

                            <input
                                type="date"
                                name="joining_date"
                                class="form-control <?= session('errors.joining_date') ? 'is-invalid' : '' ?>"
                                value="<?= old('joining_date', $employee['joining_date']) ?>">

                            <div class="invalid-feedback">
                                <?= session('errors.joining_date') ?>
                            </div>

                        </div>

                    </div>

                    <!-- Status -->

                    <div class="mb-3">

                        <label class="form-label">Status</label>

                        <select
                            name="status"
                            class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>">

                            <option value="active"
                                <?= old('status', $employee['status']) == 'active' ? 'selected' : '' ?>>
                                Active
                            </option>

                            <option value="inactive"
                                <?= old('status', $employee['status']) == 'inactive' ? 'selected' : '' ?>>
                                Inactive
                            </option>

                        </select>

                        <div class="invalid-feedback">
                            <?= session('errors.status') ?>
                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">
                            Update Employee
                        </button>

                        <a href="<?= site_url('employees') ?>" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->include('layouts/footer') ?>