<?php include 'db_connect.php' ?>

<div class="container-fluid" style="margin-bottom: 58px;">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>File Charge List</b>
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="new_file_charges"><i class="fa fa-plus" style="width: 20px;"></i> New File Charge</button>
				</large>

			</div>
			<div class="card-body" style="overflow-x:auto;">
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="5%">
						<col width="20%">
				
						<col width="10%">
						<col width="15%">
						<col width="20%">
						
					</colgroup>
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
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#loan-list').dataTable()
	$('#new_file_charges').click(function(){
		uni_modal("New File Charge","manage_loan.php",'mid-large')
	})
	$('.edit_file_charge').click(function(){
		uni_modal("Edit File Charge","manage_file_charges.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_file_charge').click(function(){
		_conf("Are you sure to delete this File Charge?","delete_file_charge",[$(this).attr('data-id')])
	})
function delete_file_charge($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_file_charge',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					$('.modal').modal('hide')
					alert_toast("File Charge successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else {
					$('.modal').modal('hide')
					alert_toast("Unable to delete this File Charge",'danger')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>