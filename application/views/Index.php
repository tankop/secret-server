<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
?>
<script type="text/javascript">
	const BASE_URL = "<?=base_url()?>";
	const INVALID_INPUTS_MESSAGE = "<?=lang('default.00016')?>";
	const SUCCESS_SECRET_CREATED_TITLE = "<?=lang('default.00021')?>";
	const SUCCESS_SECRET_CREATED_MESSAGE = "<?=lang('default.00022')?>";
	const COPY_HASH_BTN_TEXT = "<?=lang('default.00023')?>";
	const GET_SECRET_SUCCESS_TITLE = "<?=lang('default.00024')?>";
	const OK_BTN_TEXT = "<?=lang('default.00025')?>";
</script>
<div class="custom-container container-fluid" data-id="1" style="display: flex;">
	<div class="wrap-content p-2 p-sm-5">
		<div class="row h-100">
			<div class="col-12">
				<h1 class="text-center p-1 p-sm-3"><?= lang('default.00001'); ?></h1>
				<p class="text-center"><?= lang('default.00017') ?></p>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center">
						<button class="btn custom-orange-btn p-1 p-sm-3 " onclick="secret.showContainer(2)">
							<?= lang('default.00002'); ?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.showContainer(3)">
							<?= lang('default.00003'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="custom-container container-fluid" data-id="2" style="display: none;">
	<div class="wrap-content p-2 p-sm-5">
		<div class="row h-100">
			<div class="col-12">
				<h1 class="text-center p-1 p-sm-3"><?= lang('default.00004'); ?></h1>
				<div class="row mb-3 mt-3">
					<div class="col-12">
						<?php
						$form_data = [
							'name' => SecretModel::SECRET_TEXT,
							'value' => '',
							'class' => 'form-control'
						];
						echo form_label(lang('default.00007'));
						echo form_textarea($form_data);
						?>
					</div>
				</div>
				<div class="row mb-3 mt-3">
					<div class="col-12 col-sm-6">
						<?php
						$form_data = [
							'name' => SecretModel::EXPIRES_AT,
							'value' => '',
							'type' => 'number',
							'class' => 'form-control',

							'placeholder' => lang('default.00018')
						];
						echo form_label(lang('default.00005')) . '<span class="infobox ml-2"><i class="fas fa-info-circle"></i><span class="infoboxtext ml-2">' . lang('default.00019') . '</span></span>';
						echo form_input($form_data);
						?>
					</div>
					<div class="col-12 col-sm-6">
						<?php
						$form_data = [
							'name' => SecretModel::REMAINING_VIEWS,
							'value' => '',
							'type' => 'number',
							'class' => 'form-control',
							'placeholder' => lang('default.00018')
						];
						echo form_label(lang('default.00006')) . '<span class="infobox ml-2"><i class="fas fa-info-circle"></i><span class="infoboxtext ml-2">' . lang('default.00020') . '</span></span>';
						echo form_input($form_data);
						?>
					</div>
				</div>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center order-2 order-sm-1">
						<button class="btn custom-grey-btn p-1 p-sm-3" onclick="secret.showContainer(1)">
							<?= lang('default.00009'); ?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center order-1 order-sm-2">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.createSecret()">
							<?= lang('default.00008'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="custom-container container-fluid" data-id="3" style="display: none;">
	<div class="wrap-content p-2 p-sm-5">
		<div class="row h-100">
			<div class="col-12">
				<h1 class="text-center p-1 p-sm-3"><?= lang('default.00010'); ?></h1>
				<div class="row mb-3 mt-3">
					<div class="col-12">
						<?php
						$form_data = [
							'name' => SecretModel::HASH,
							'value' => '',
							'class' => 'form-control'
						];
						echo form_label(lang('default.00011'));
						echo form_input($form_data);
						?>
					</div>
				</div>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center order-2 order-sm-1">
						<button class="btn custom-grey-btn p-1 p-sm-3" onclick="secret.showContainer(1)">
							<?= lang('default.00009'); ?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center order-1 order-sm-2">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.checkSecret()">
							<?= lang('default.00012'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
</script>
