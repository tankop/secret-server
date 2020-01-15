<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
?>
<div class="custom-container container-fluid" data-id="1" style="display: flex;">
	<div class="wrap-content p-2 p-sm-5">
		<div class="row h-100">
			<div class="col-12">
				<h1 class="text-center p-1 p-sm-3"><?= lang('default.00001'); ?></h1>
				<p class="text-center"><?=lang('default.00017')?></p>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center">
						<button class="btn custom-orange-btn p-1 p-sm-3 " onclick="secret.showContainer(2)">
							<?=lang('default.00002');?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.showContainer(3)">
							<?=lang('default.00003');?>
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
						echo form_label(lang('default.00005'));
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
						echo form_label(lang('default.00006'));
						echo form_input($form_data);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div id="new-secret-response-message"></div>
					</div>
				</div>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center order-2 order-sm-1">
						<button class="btn custom-grey-btn p-1 p-sm-3" onclick="secret.showContainer(1)">
							<?=lang('default.00009');?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center order-1 order-sm-2">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.createSecret()">
							<?=lang('default.00008');?>
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
				<div class="row">
					<div class="col-12">
						<div id="check-secret-response-message"></div>
					</div>
				</div>
				<div class="row buttons text-center p-1 p-sm-3">
					<div class="col-12 col-sm-6 mb-3 text-center order-2 order-sm-1">
						<button class="btn custom-grey-btn p-1 p-sm-3" onclick="secret.showContainer(1)">
							<?=lang('default.00009');?>
						</button>
					</div>
					<div class="col-12 col-sm-6 mb-3 text-center order-1 order-sm-2">
						<button class="btn custom-orange-btn p-1 p-sm-3" onclick="secret.checkSecret()">
							<?=lang('default.00012');?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
