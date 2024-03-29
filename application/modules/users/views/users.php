<section id="content">
	<section class="hbox stretch">
		<!-- .aside -->
		<aside>
			<section class="vbox">
				<header class="header bg-white b-b b-light">
					<a href="#aside" data-toggle="class:show" class="btn btn-sm btn-<?=config_item('theme_color')?> pull-right"><i class="fa fa-plus"></i> <?=lang('new_user')?></a>
					<p class="h3"><?=lang('system_users')?></p>
				</header>
				<section class="scrollable wrapper">
					<div class="row">
						<div class="col-lg-12">
							<section class="panel panel-default">
								<div class="table-responsive">
									<table id="table-users" class="table table-striped m-b-none AppendDataTables">
										<thead>
											<tr>
												<th><?=lang('username')?> </th>
												<th><?=lang('full_name')?></th>
												<th><?=lang('company')?> </th>
												<th><?=lang('role')?> </th>
												<th class="hidden-sm"><?=lang('date')?> </th>
												<th class="col-options no-sort"><?=lang('options')?></th>
											</tr>
										</thead>
										<tbody>
			<?php foreach (User::all_users() as $key => $user) { ?>
				<tr>
				<?php $info = User::profile_info($user->id); ?>
				<td>
				<a class="pull-left thumb-sm avatar" data-toggle="tooltip" data-title="<?=User::login_info($user->id)->email?>" data-placement="right">


	<img src="<?php echo User::avatar_url($user->id); ?>" class="img-rounded" style="border-radius: 6px;">

	<span class="label label-<?=($user->banned == '1') ? 'danger': 'success'?>"><?=$user->username?></span>

	<?php if($user->role_id == '3') { ?>
	 <strong class=""><?=config_item('default_currency_symbol')?><?=User::profile_info($user->id)->hourly_rate;?>/<?=lang('hour')?></strong>
	 <?php }?>
				</a>
				</td>

				<td class=""><?=$info->fullname?></td>
				<td class="">
					<a href="<?=base_url()?>companies/view/<?=$info->company?>" class="text-info">
					<?=($info->company > 0) ? Client::view_by_id($info->company)->company_name : 'N/A'; ?></a>
				</td>

				<td>

	<?php if (User::get_role($user->id) == 'admin') {
			  $span_badge = 'label label-danger';
		  }elseif (User::get_role($user->id) == 'staff') {
			  $span_badge = 'label label-info';
		  }elseif (User::get_role($user->id) == 'client') {
			  $span_badge = 'label label-default';
		  }else{
			  $span_badge = '';
		}
	?>
				<span class="<?=$span_badge?>">
				<?=lang(User::get_role($user->id))?></span>
												 </td>

													<td class="hidden-sm">
				<?=strftime(config_item('date_format'), strtotime($user->created));?>
													</td>

													<td >
	<a href="<?=base_url()?>users/account/auth/<?=$user->id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('user_edit_login')?>"><i class="fa fa-lock"></i>
	</a>
														<?php if($user->role_id == '3') { ?>
	<a href="<?=base_url()?>users/account/permissions/<?=$user->id?>" class="btn btn-success btn-xs" data-toggle="ajaxModal" title="<?=lang('staff_permissions')?>"><i class="fa fa-shield"></i>
	</a>
														<?php } ?>

	<a href="<?=base_url()?>users/account/update/<?=$user->id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('edit')?>"><i class="fa fa-edit"></i>
	</a>
				<?php if ($user->id != User::get_id()) { ?>

	<a href="<?=base_url()?>users/account/ban/<?=$user->id?>" class="btn btn-<?=($user->banned == '1') ? 'danger': 'default'?> btn-xs" data-toggle="ajaxModal" title="<?=lang('ban_user')?>"><i class="fa fa-times-circle-o"></i>
	</a>

	<a href="<?=base_url()?>users/account/delete/<?=$user->id?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i>
	</a>
														<?php } ?>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</section>
							</div>
						</div>
					</section>
				</section>
			</aside>
			<!-- /.aside -->
			<!-- .aside -->
			<aside class="aside-lg bg-white b-l hide" id="aside">
				<section class="vbox">
					<section class="scrollable wrapper">
						<?php
						echo form_open(base_url().'auth/register_user'); ?>
						<p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>
						<input type="hidden" name="r_url" value="<?=base_url()?>users/account">
						<div class="form-group">
							<label><?=lang('full_name')?> <span class="text-danger">*</span></label>
							<input type="text" class="input-sm form-control" value="<?=set_value('fullname')?>" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_name')?>" name="fullname" required>
						</div>
						<div class="form-group">
							<label><?=lang('username')?> <span class="text-danger">*</span></label>
							<input type="text" name="username" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_username')?>" value="<?=set_value('username')?>" class="input-sm form-control" required>
						</div>
						<div class="form-group">
							<label><?=lang('email')?> <span class="text-danger">*</span></label>
							<input type="email" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_email')?>" name="email" value="<?=set_value('email')?>" class="input-sm form-control" required>
						</div>
						<div class="form-group">
							<label><?=lang('password')?></label>
							<input type="password" placeholder="<?=lang('password')?>" value="<?=set_value('password')?>" name="password"  class="input-sm form-control">
						</div>
						<div class="form-group">
							<label><?=lang('confirm_password')?></label>
							<input type="password" placeholder="<?=lang('confirm_password')?>" value="<?=set_value('confirm_password')?>" name="confirm_password"  class="input-sm form-control">
						</div>
						<div class="form-group">
							<label><?=lang('company')?></label>
							<select class="select2-option" style="width:200px" name="company" >
								<optgroup label="<?=lang('default_company')?>">
									<option value="-"><?=config_item('company_name')?></option>
								</optgroup>
								<optgroup label="<?=lang('other_companies')?>">
									<?php foreach (Client::get_all_clients() as $company){ ?>
									<option value="<?=$company->co_id?>"><?=$company->company_name?></option>
									<?php } ?>
								</optgroup>
							</select>
						</div>
						<div class="form-group">
							<label><?=lang('phone')?> </label>
							<input type="text" class="input-sm form-control" value="<?=set_value('phone')?>" name="phone" placeholder="<?=lang('eg')?> <?=lang('user_placeholder_phone')?>">
						</div>
						<div class="form-group">
							<label><?=lang('role')?></label>
							<select name="role" class="form-control">
								<?php foreach (User::get_roles() as $r) { ?>
								<option value="<?=$r->r_id?>"><?=ucfirst($r->role)?></option>
								<?php } ?>
							</select>
						</div>
						<div class="m-t-lg"><button class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('register_user')?></button></div>
					</form>
				</section>
			</section>
		</aside>
		<!-- /.aside -->
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>
