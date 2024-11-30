<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <form action="" id="loan-application" autocomplete="off">
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Borrower</label>
                <?php
                $borrower = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM borrowers order by concat(firstname,' ',lastname) asc ");
                ?>
                <select name="borrower_id" id="borrower_id" class="custom-select">
                    <option value=""></option>
                    <?php while($row = $borrower->fetch_assoc()): ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="control-label">Loan Type</label>
                <?php
                $type = $conn->query("SELECT * FROM loan_types order by `type_name` desc ");
                ?>
                <select name="loan_type_id" id="loan_type_id" class="custom-select">
                    <option value=""></option>
                    <?php while($row = $type->fetch_assoc()): ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['type_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Loan Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Save</button>
    </form>
</div>

<script>
    $('#loan-application').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax.php?action=save_loan',
            method: "POST",
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert("Loan successfully saved.");
                    $('#modal').modal('hide');
                    location.reload();
                } else {
                    alert("Error saving loan.");
                }
            }
        });
    });
</script>
