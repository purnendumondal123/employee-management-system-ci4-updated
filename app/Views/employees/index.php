<?= $this->include('layouts/header') ?>

<?= $this->include('layouts/navbar') ?>

<div class="d-flex">

    <?= $this->include('layouts/sidebar') ?>

    <div class="content flex-grow-1 p-4 bg-light" style="min-height:100vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">Employee List</h2>
                <p class="text-muted mb-0">
                    Manage all employees from here.
                </p>
            </div>

            <a href="<?= site_url('employees/create') ?>" class="btn btn-primary">
                + Add Employee
            </a>

        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table id="employeeTable" class="table table-bordered table-hover align-middle w-100">

                        <thead class="table-dark">

                            <tr>

                                <th>SL No</th>
                                <th>Employee Code</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {

        $('#employeeTable').DataTable({

            processing: true,
            serverSide: true,
            responsive: true,

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],

            ajax: {
                url: "<?= site_url('employees/datatable') ?>",
                type: "POST",
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            },

            dom: 'Bfrtip',

            buttons: [{
                extend: 'csv',
                text: 'Export CSV'
            }],

            columnDefs: [{
                targets: [6],
                orderable: false,
                searchable: false
            }],

            language: {
                processing: "Loading..."
            }

        });

    });
</script>

<?= $this->include('layouts/footer') ?>