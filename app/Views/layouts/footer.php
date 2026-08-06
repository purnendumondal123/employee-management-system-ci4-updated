<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<!-- CSV Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<?= $this->renderSection('scripts') ?>
<!-- <script>
    $(function() {

        if ($('#employeeTable').length) {

            $('#employeeTable').DataTable({

                processing: true,
                serverSide: true,
                responsive: true,

                ajax: {
                    url: "<?= site_url('employees/datatable') ?>",
                    type: "POST"
                },

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                dom: 'Bfrtip',

                buttons: [{
                    extend: 'csv',
                    text: 'Export CSV'
                }],

                columnDefs: [{
                    targets: [6],
                    orderable: false,
                    searchable: false
                }]

            });

        }

    });
</script> -->

</body>

</html>