<div class="popularbanksdiv">
	<a href="<?php echo base_url("branches/170") ?>">SBI Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/75") ?>">ICICI Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/72") ?>">HDFC Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/140") ?>">PNB Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/19") ?>">AXIS Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/25") ?>">Bank OF BARODA IFSC Codes,</a>
	<a href="<?php echo base_url("branches/27") ?>">BANK OF INDIA IFSC Codes,</a>
	<a href="<?php echo base_url("branches/109") ?>">KOTAK Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/225") ?>">YES Bank IFSC Codes</a>
</div>

<div class="filterdiv">
	<div class="bnkdiv eachinfodiv form-group">
		<label for="bank">Bank</label>
		<input type="text" list="banks" class="form-control bank">
		<datalist id="banks">
			<?php foreach ($banks->result() as $bank) : ?>
				<option bnkid="<?php echo $bank->id ?>"><?php echo $bank->name ?></option>
			<?php endforeach; ?>
		</datalist>
	</div>

	<div class="brnchdiv eachinfodiv form-group">
		<label for="branch">Branch</label>
		<input type="text" list="branch" class="form-control branch" disabled style="cursor:not-allowed">
		<datalist id="branch">
		</datalist>
	</div>

	<div>
		<button type="button" class="btn filtersearch">Search</button>
	</div>
</div>

<div>
	<div class="d-flex searchbox mb-3">
		<span class="searchspan m-auto"><i class="fas fa-search"></i></span>
		<input type="text" name="banksearch" id="banksearch" class="banksearch form-control" autofocus="true" placeholder="Type to start searching...">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
		<span class="closespan text-danger m-auto"><i class="fas fa-times"></i></span>
	</div>
</div>

<div class="banksdiv">
	<?php foreach ($banks->result() as $bank) : ?>
		<li><a href='<?php echo base_url("branches/") . $bank->id ?>' class="eachbank" tasrget='_blank'><?php echo $bank->name ?></a></li>
	<?php endforeach; ?>
</div>



<script>
	$(document).ready(function() {
		$(document).on('keyup', '.banksearch', function() {
			var searchval = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();
			$('.closespan').show();

			$.ajax({
				url: "<?php echo base_url("bank/searchbank") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					searchval: searchval
				},
				success: function(data) {
					$('.csrf_token').val(data.token);
					var bnklength = data.banks.length;
					$('.banksdiv').children().remove();
					if (bnklength == 0) {
						$('.banksdiv').append('<p class="text-center font-weight-bold" style="color:#294a63">Bank <span class="text-danger">"' + searchval + '"</span> not found</p>');
					} else {
						for (let index = 0; index < bnklength; index++) {
							$('.banksdiv').append('<li><a href="branches/' + data.banks[index].id + '" class="eachbank font-weight-bolder" tasrget="_blank">' + data.banks[index].name + ' IFSC Code</a></li>');
						}
					}
				}
			})
		});

		$(document).on('click', '.closespan', function() {
			$(".banksearch").val("");

			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			$.ajax({
				url: "<?php echo base_url("bank/banksreload") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
				},
				success: function(data) {
					$('.csrf_token').val(data.token);

					$('.banksdiv').children().remove();

					var bnklength = data.banks.length;
					for (let index = 0; index < bnklength; index++) {
						$('.banksdiv').append('<li><a href="branches/' + data.banks[index].id + '" class="eachbank" tasrget="_blank">' + data.banks[index].name + '</a></li>');
					}

					$('.closespan').hide();
				}
			})
		});

		$('.bank').change(function() {
			var bank = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			//disable and clear branch datalist till it loads
			$(".branch").attr("disabled", "disabled").css('cursor', 'not-allowed');
			$(".branch").val("");
			$("#branch option").remove();

			$.ajax({
				url: '<?php echo base_url('bank/bankfilter'); ?>',
				method: 'post',
				dataType: 'json',
				data: {
					bank: bank,
					[csrfName]: csrfHash
				},
				success: function(data) {
					if (data.status === 'success') {
						for (let index = 0; index < data.branchs.length; index++) {
							$("#branch").append("<option bnkid=''>" + data.branchs[index].adr1 + "</option>");
						}

						$(".bank").css('border', '1px solid #ced4da');
						$(".branch").removeAttr("disabled").css('cursor', 'text');
						$(".branch").val("");
					} else {
						$(".branch").attr("disabled", "disabled").css('cursor', 'not-allowed');
						$(".branch").val("");
					}
				}
			});

		});

		$('.branch').click(function() {
			var bank = $(".bank").val();
			if (bank === "" || bank === null || bank === undefined) {
				$(".branch").attr("disabled", "disabled").css('cursor', 'not-allowed');
				$(".bank").css('border', '1px solid red');
				$(".branch").val("");
				return false;
			} else {
				$(".branch").removeAttr("disabled", "disabled").css('cursor', 'text');
				$(".bank").css('border', '1px solid #ced4da');
			}
		});

		$(document).on('click', '.filtersearch', function() {
			var bank = $(".bank").val();
			var branch = $(".branch").val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			if (bank === "" || bank === null || bank === undefined) {
				$(".bank").css('border', '1px solid red');
				return false;
			} else {
				$(".bank").css('border', '1px solid #ced4da');
			}
			if (branch === "" || branch === null) {
				$(".branch").css('border', '1px solid red');
				return false;
			} else {
				$(".branch").css('border', '1px solid #ced4da');
			}

			var url = "<?php echo base_url('bank/ifsc') ?>";
			var urltwo = "?bank=" + bank + "&branch=" + branch + "";
			window.location.assign(url + urltwo);

			console.log(bank);
			console.log(branch);
			console.log(url + urltwo);
		});
	})
</script>