<div class="row">
	<!-- Start Form -->
	<div class="col-lg-12">
		<?php
		$attributes = array('class' => 'bs-example form-horizontal');
		echo form_open_multipart('settings/update', $attributes); ?>
			<section class="panel panel-default">
				<header class="panel-heading font-bold"><i class="fa fa-cogs"></i> <?=lang('estimate_settings')?></header>
				<div class="panel-body">
					<input type="hidden" name="settings" value="<?=$load_setting?>">
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('estimate_color')?> <span class="text-danger">*</span></label>
						<div class="col-lg-3">
							<input type="text" name="estimate_color" class="form-control" value="<?=config_item('estimate_color')?>" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('estimate_prefix')?> <span class="text-danger">*</span></label>
						<div class="col-lg-3">
							<input type="text" name="estimate_prefix" class="form-control" value="<?=config_item('estimate_prefix')?>" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('estimate_start_number')?></label>
						<div class="col-lg-3">
							<input type="text" name="estimate_start_no" class="form-control" value="<?=config_item('estimate_start_no')?>">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('display_estimate_badge')?></label>
						<div class="col-lg-3">
							<label class="switch">
								<input type="hidden" value="off" name="display_estimate_badge" />
								<input type="checkbox" <?php if(config_item('display_estimate_badge') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="display_estimate_badge">
								<span></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('show_item_tax')?></label>
						<div class="col-lg-3">
							<label class="switch">
								<input type="hidden" value="off" name="show_estimate_tax" />
								<input type="checkbox" <?php if(config_item('show_estimate_tax') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="show_estimate_tax">
								<span></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"><?=lang('estimate_to_project')?></label>
						<div class="col-lg-3">
							<label class="switch">
								<input type="hidden" value="off" name="estimate_to_project" />
								<input type="checkbox" <?php if(config_item('estimate_to_project') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="estimate_to_project">
								<span></span>
							</label>
						</div>
						<span class="help-block m-b-none small text-danger">Convert accepted estimate to project</span>
					</div>
					<div class="form-group terms">
						<label class="col-lg-3 control-label"><?=lang('estimate_footer')?></label>
						<div class="col-lg-9">
							<textarea class="form-control foeditor" name="estimate_footer"><?=config_item('estimate_footer')?></textarea>
						</div>
					</div>
					<div class="form-group terms">
						<label class="col-lg-3 control-label"><?=lang('estimate_terms')?></label>
						<div class="col-lg-9">
							<textarea class="form-control foeditor" name="estimate_terms"><?=config_item('estimate_terms')?></textarea>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-<?=config_item('theme_color');?>"><?=lang('save_changes')?></button>
					</div>
				</div>
			</section>
		</form>
	</div>
	<!-- End Form -->
</div>