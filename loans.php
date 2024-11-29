<?php include 'db_connect.php'; ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <large class="card-title">
                    <b>Loan Applications</b>
                </large>
				<button 
    class="btn btn-primary btn-sm btn-block col-md-2 float-right" 
    type="button" 
    id="application" 
    onclick="openApplicationModal()">
    <i class="fa fa-plus"></i> New Loan Application
</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="loan-application-list">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Borrower</th>
                            <th class="text-center">Loan Details</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM loan_applications ORDER BY id ASC");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td>
                                    <p>Name: <b><?php echo ucwords($row['borrower_name']); ?></b></p>
                                    <p><small>Contact: <b><?php echo $row['contact_no']; ?></b></small></p>
                                </td>
                                <td>
                                    <p>Amount: <b><?php echo number_format($row['amount'], 2); ?></b></p>
                                    <p><small>Term: <b><?php echo $row['loan_term']; ?> months</b></small></p>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?php echo $row['status'] == 'approved' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm edit_application" type="button" data-id="<?php echo $row['id']; ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm delete_application" type="button" data-id="<?php echo $row['id']; ?>">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	td p {
    margin: unset;
}

td {
    vertical-align: middle !important;
}

.badge {
    font-size: 0.9rem;
}
</style>
<script>
$(document).ready(function () {
    // Initialize DataTable
    $('#loan-application-list').dataTable();

    // Open New Loan Application Modal
	$(document).ready(function () {
    $(document).on('click', '#application', function () {
        console.log('Button clicked');
    });
});

    // Open Edit Loan Application Modal
    $('.edit_application').click(function () {
        uni_modal("Edit Loan Application", "edit_loan_application.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    // Confirm Delete Loan Application
    $('.delete_application').click(function () {
        _conf("Are you sure to delete this loan application?", "delete_application", [$(this).attr('data-id')]);
    });
});

// Delete Loan Application
function delete_application(id) {
    start_load();
    $.ajax({
        url: 'ajax.php?action=delete_application',
        method: 'POST',
        data: { id: id },
        success: function (resp) {
            if (resp == 1) {
                $('.modal').modal('hide');
                alert_toast("Loan application successfully deleted", 'success');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Unable to delete the loan application", 'danger');
            }
        }
    });
}
</script>