<!-- BEGIN: main -->
<form action="{ACTION}" method="post" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_display}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_display_type}</strong></label>
				<div class="col-sm-18">
					<div class="row">
						<div class="col-xs-24 col-sm-12">
							<select name="display_data" class="form-control">
								<!-- BEGIN: display_data -->
								<option value="{DISPLAY_DATA.index}"{DISPLAY_DATA.selected}>{DISPLAY_DATA.value}</option>
								<!-- END: display_data -->
							</select>
						</div>
						<div class="col-xs-24 col-sm-12">
							<select name="display_type" class="form-control">
								<!-- BEGIN: display_type -->
								<option value="{DISPLAY_TYPE.index}"{DISPLAY_TYPE.selected}>{DISPLAY_TYPE.value}</option>
								<!-- END: display_type -->
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group" id="view_on_main"{CONFIG.style_view_on_main}>
				<label class="col-sm-6 text-right"><strong>{LANG.config_view_on_main}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" value="1" name="view_on_main" {CONFIG.ck_view_on_main}/>{LANG.config_view_on_main_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_num_page}</strong></label>
				<div class="col-sm-18">
					<input type="text" name="num_item_page" class="form-control" value="{CONFIG.num_item_page}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_priceformat}</strong></label>
				<div class="col-sm-18">
					<select name="priceformat" class="form-control">
						<!-- BEGIN: priceformat -->
						<option value="{PFORMAT.index}"{PFORMAT.selected}>{PFORMAT.value}</option>
						<!-- END: priceformat -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_thumb_size}</strong></label>
				<div class="col-sm-18">
					<input type="text" name="thumb_width" class="form-control w100 pull-left" value="{CONFIG.thumb_width}" /> <span class="text-middle pull-left">&nbsp;x&nbsp;</span> <input type="text" name="thumb_height" class="form-control w100" value="{CONFIG.thumb_height}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_social_display}</strong></label>
				<div class="col-sm-18">
					<input type="checkbox" value="1" name="socialbutton" {CONFIG.socialbutton}/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_allow_maps}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" value="1" name="allow_maps" {CONFIG.allow_maps}/>{LANG.config_allow_maps_note}</label>
				</div>
			</div>
			<div class="form-group" id="maps_appid"{CONFIG.style_maps_appid}>
				<label class="col-sm-6"></label>
				<div class="col-sm-18">
					<input type="text" name="maps_appid" class="form-control" value="{CONFIG.maps_appid}" placeholder="{LANG.config_maps_appid}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_allow_contact_info}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" value="1" name="allow_contact_info" {CONFIG.ck_allow_contact_info}/>{LANG.config_allow_contact_info_note}</label>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_system}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>Facebook APPID</strong></label>
				<div class="col-sm-18">
					<input type="text" value="{CONFIG.facebookappid}" class="form-control" name="facebookappid" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.tags_alias}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" value="1" name="tags_alias" {CONFIG.tags_alias}/>{LANG.tags_alias_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_auto_tags}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" value="1" name="auto_tags" {CONFIG.auto_tags}/>{LANG.config_auto_tags_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_tags_remind}</strong></label>
				<div class="col-sm-18">
					<input type="checkbox" value="1" name="tags_remind" {CONFIG.tags_remind}/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_structupload_admin}</strong></label>
				<div class="col-sm-18">
					<select class="form-control" name="structure_upload">
						<!-- BEGIN: structure_upload_admin -->
						<option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
						<!-- END: structure_upload_admin -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_typesize}</strong></label>
				<div class="col-sm-18">
					<!-- BEGIN: sizetype -->
					<label><input type="radio" name="sizetype" value="{SIZETYPE.index}"{SIZETYPE.checked} >{SIZETYPE.value}</label>&nbsp;&nbsp;&nbsp;
					<!-- END: sizetype -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_itemsave}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" name="itemsave" value="1"{CONFIG.ck_itemsave} >{LANG.config_itemsave_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_payport}</strong></label>
				<div class="col-sm-18">
					<select name="payport" class="form-control">
						<option value="0">---{LANG.config_payport_select}---</option>
						<!-- BEGIN: payport -->
						<option value="{PAYPORT.index}"{PAYPORT.selected}>{PAYPORT.value}</option>
						<!-- END: payport -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_code_auto}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" name="code_auto" value="1" {CONFIG.ck_code_auto} />{LANG.config_code_auto_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_code_format}</strong></label>
				<div class="col-sm-18">
					<input type="text" class="form-control" name="code_format" value="{CONFIG.code_format}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_similar_content}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_similar_content_note}">&nbsp;</em></label>
				<div class="col-sm-18">
					<input type="number" name="similar_content" class="form-control" value="{CONFIG.similar_content}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_similar_time}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_similar_time_note}">&nbsp;</em></label>
				<div class="col-sm-18">
					<input type="number" name="similar_time" class="form-control" value="{CONFIG.similar_time}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_money_unit}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_similar_time_note}">&nbsp;</em></label>
				<div class="col-sm-18">
					<input type="text" name="money_unit" class="form-control" value="{CONFIG.money_unit}" />
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_time_reloadpage}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.time_reloadpage_note}">&nbsp;</em></label>
				<div class="col-sm-18">
					<input type="text" name="time_reloadpage" class="form-control" value="{CONFIG.time_reloadpage}" />
				</div>
			</div>

		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_post}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_post_allow}</strong></label>
				<div class="col-sm-18" style="height: 200px; overflow: scroll; border: solid 1px #ddd; padding: 10px">
					<!-- BEGIN: post_groups -->
					<label class="show"><input type="checkbox" name="post_groups[]" value="{OPTION.value}" {OPTION.checked} />{OPTION.title}</label>
					<!-- END: post_groups -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_post_queue}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" name="post_queue" value="1" {CONFIG.post_queue} />{LANG.config_post_queue_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_post_user_limit}</strong></label>
				<div class="col-sm-18">
					<input type="number" name="post_user_limit" value="{CONFIG.post_user_limit}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_post_maxfilesize}</strong></label>
				<div class="col-sm-18">
					<select class="form-control" name="maxfilesize">
						<!-- BEGIN: maxfilesize -->
						<option value="{SIZE.key}"{SIZE.selected}>{SIZE.title}</option>
						<!-- END: maxfilesize -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_post_image_upload_size} (px)</strong></label>
				<div class="col-sm-18">
					<div class="row">
						<div class="col-sm-3">
							<input type="number" name="image_upload_size_w" value="{CONFIG.image_upload_size_w}" class="form-control" />
						</div>
						<div class="col-sm-1 text-center">x</div>
						<div class="col-sm-3">
							<input type="number" name="image_upload_size_h" value="{CONFIG.image_upload_size_h}" class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 text-right"><strong>{LANG.config_auto_resize}</strong></label>
				<div class="col-sm-18">
					<label><input type="checkbox" name="auto_resize" value="1" {CONFIG.ck_auto_resize} />{LANG.config_auto_resize_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_post_image_limit}</strong></label>
				<div class="col-sm-18">
					<input type="number" name="post_image_limit" value="{CONFIG.post_image_limit}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 control-label"><strong>{LANG.config_structupload_user}</strong></label>
				<div class="col-sm-18">
					<select class="form-control" name="structure_upload_user">
						<!-- BEGIN: structure_upload_user -->
						<option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
						<!-- END: structure_upload_user -->
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_refresh}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_refresh_allow}</strong></label>
				<div class="col-sm-21">
					<label><input type="checkbox" value="1" name="refresh_allow" {CONFIG.ck_refresh_allow} />{LANG.config_refresh_allow_note}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_refresh_free}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_refresh_free_note}">&nbsp;</em></label>
				<div class="col-sm-21">
					<input type="text" class="form-control" value="{CONFIG.refresh_free}" name="refresh_free" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_refresh_default}</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_refresh_default_note}">&nbsp;</em></label>
				<div class="col-sm-21">
					<input type="text" class="form-control" value="{CONFIG.refresh_default}" name="refresh_default" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_price}</strong></label>
				<div class="col-sm-21">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" style="margin-bottom: 7px">
							<thead>
								<tr>
									<th>{LANG.config_refresh_config_number}</th>
									<th>{LANG.price}</th>
<th>{LANG.price_discount}</th>
									<th class="w50"></th>
								</tr>
							</thead>
							<tbody id="refresh_config">
								<!-- BEGIN: refresh_config -->
								<tr>
									<td><input type="number" value="{REFRESH_CONFIG.number}" name="refresh_config[{REFRESH_CONFIG.index}][number]" class="form-control" /></td>
									<td><input type="text" value="{REFRESH_CONFIG.price}" name="refresh_config[{REFRESH_CONFIG.index}][price]" class="form-control" /></td>
<td><input type="text" value="{REFRESH_CONFIG.price_discount}" name="refresh_config[{REFRESH_CONFIG.index}][price_discount]" class="form-control" /></td>
<td class="text-center"><em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest('tr').remove(); return !1;">&nbsp;</em></td>
								</tr>
								<!-- END: refresh_config -->
							</tbody>
						</table>
					</div>
					<button class="btn btn-primary btn-xs" onclick="nv_config_refresh_add(); return !1;">{LANG.config_add}</button>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_refresh_auto}</strong></label>
				<div class="col-sm-21">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" style="margin-bottom: 7px">
							<tbody>
								<!-- BEGIN: refresh_auto_config -->
								<tr>
									<td class="w200">{REFRESH_AUTO_COUNT.title}</td>
									<td><input type="number" value="{REFRESH_AUTO_COUNT.value}" name="refresh_auto_config[{REFRESH_AUTO_COUNT.index}]" class="form-control" /></td>
									<td class="text-center"><em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest('tr').remove(); return !1;">&nbsp;</em></td>
								</tr>
								<!-- END: refresh_auto_config -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_group_useradd}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_group_payment_style}</strong></label>
				<div class="col-sm-21">
					<select class="form-control" name="payment_style">
						<!-- BEGIN: payment_style -->
						<option value="{PAYMENT_STYLE.index}"{PAYMENT_STYLE.selected}>{PAYMENT_STYLE.value}</option>
						<!-- END: payment_style -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_upgrade_fees}</strong></label>
				<div class="col-sm-21">
					<script>var specialgroup_count = {};</script>
					<!-- BEGIN: specialgroup -->
					<div class="specialgroup m-bottom">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" style="margin-bottom: 7px">
								<caption>{SPECIALGROUP.value}</caption>
								<thead>
									<tr>
										<th>{LANG.time}</th>
<th>{LANG.unit}</th>
										<th>{LANG.price}</th>
<th>{LANG.price_discount}</th>
										<th class="w50"></th>
									</tr>
								</thead>
								<tbody id="specialgroup_{SPECIALGROUP.index}">
									<!-- BEGIN: specialgroup_config -->
									<tr>
										<td><input type="text" value="{SPECIALGROUP_CONFIG.time}" name="specialgroup_config[{SPECIALGROUP.index}][{SPECIALGROUP_CONFIG.number}][time]" class="form-control" /></td>
											<td><select name="specialgroup_config[{SPECIALGROUP.index}][{SPECIALGROUP_CONFIG.number}][unit]" class="form-control">
													<!-- BEGIN: unit -->
													<option value="{UNIT.index}"{UNIT.selected}>{UNIT.value}</option>
													<!-- END: unit -->
											</select></td>
										<td><input type="text" value="{SPECIALGROUP_CONFIG.price}" name="specialgroup_config[{SPECIALGROUP.index}][{SPECIALGROUP_CONFIG.number}][price]" class="form-control" /></td>
<td><input type="text" value="{SPECIALGROUP_CONFIG.price_discount}" name="specialgroup_config[{SPECIALGROUP.index}][{SPECIALGROUP_CONFIG.number}][price_discount]" class="form-control" /></td>
										
										<td class="text-center"><em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest('tr').remove(); return !1;">&nbsp;</em></td>
									</tr>
									<!-- END: specialgroup_config -->
								</tbody>
							</table>
						</div>
						<button class="btn btn-primary btn-xs" onclick="nv_config_specialgroup_add({SPECIALGROUP.index}); return !1;">{LANG.config_add}</button>
					</div>
					<script>specialgroup_count[{SPECIALGROUP.index}] = {SPECIALGROUP.count};</script>
					<!-- END: specialgroup -->
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_upgrade_group}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.config_upgrade_percent} (%)</strong> <em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.config_upgrade_percent_note}">&nbsp;</em></label>
				<div class="col-sm-21">
					<input type="number" name="upgrade_group_percent" class="form-control" value="{CONFIG.upgrade_group_percent}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right"><strong>{LANG.config_upgrade_fees}</strong></label>
				<div class="col-sm-21">
					<script>var upgrade_group_count = {};</script>
					<!-- BEGIN: upgrade_group -->
					<div class="upgrade_group m-bottom">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" style="margin-bottom: 7px">
								<caption>{UPGRADE_GROUP.value}</caption>
								<thead>
									<tr>
										<th>{LANG.time}</th>
<th>{LANG.unit}</th>
										<th>{LANG.price}</th>
<th>{LANG.price_discount}</th>
										<th class="w50"></th>
									</tr>
								</thead>
								<tbody id="upgrade_group_{UPGRADE_GROUP.index}">
									<!-- BEGIN: upgrade_group_config -->
									<tr>
										<td><input type="text" value="{UPGRADE_GROUP_CONFIG.time}" name="upgrade_group_config[{UPGRADE_GROUP.index}][{UPGRADE_GROUP_CONFIG.number}][time]" class="form-control" /></td>
											<td><select name="upgrade_group_config[{UPGRADE_GROUP.index}][{UPGRADE_GROUP_CONFIG.number}][unit]" class="form-control">
													<!-- BEGIN: unit -->
													<option value="{UNIT.index}"{UNIT.selected}>{UNIT.value}</option>
													<!-- END: unit -->
											</select></td>
										<td><input type="text" value="{UPGRADE_GROUP_CONFIG.price}" name="upgrade_group_config[{UPGRADE_GROUP.index}][{UPGRADE_GROUP_CONFIG.number}][price]" class="form-control" /></td>
<td><input type="text" value="{UPGRADE_GROUP_CONFIG.price_discount}" name="upgrade_group_config[{UPGRADE_GROUP.index}][{UPGRADE_GROUP_CONFIG.number}][price_discount]" class="form-control" /></td>
										<td class="text-center"><em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest('tr').remove(); return !1;">&nbsp;</em></td>
									</tr>
									<!-- END: upgrade_group_config -->
								</tbody>
							</table>
						</div>
						<button class="btn btn-primary btn-xs" onclick="nv_config_upgrade_group_add({UPGRADE_GROUP.index}); return !1;">{LANG.config_add}</button>
					</div>
					<script>upgrade_group_count[{UPGRADE_GROUP.index}] = {UPGRADE_GROUP.count};</script>
					<!-- END: upgrade_group -->
				</div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<input type="submit" class="btn btn-primary" value="{LANG.items_submit}" name="saveconfig" />
	</div>
</form>
<script>
	$('select[name="display_type"]').change(function(){
		if($(this).val() == 2){
			$('#view_on_main').show();
		}else{
			$('#view_on_main').hide();
		}
	});
	
	$('input[name="allow_maps"]').change(function(){
		if($(this).is(':checked')){
			$('#maps_appid').show();
		}else{
			$('#maps_appid').hide();
		}
	});
	
	var refresh_count = {REFRESH_COUNT};
	function nv_config_refresh_add()
	{
		var html = '';
		html += '<tr>';
		html += '	<td><input type="number" name="refresh_config[' + refresh_count + '][number]" class="form-control" /></td>';
		html += '	<td><input type="text" name="refresh_config[' + refresh_count + '][price]" class="form-control" /></td>';
html += '	<td><input type="text" name="refresh_config[' + refresh_count + '][price_discount]" class="form-control" /></td>';
		html += '	<td class="text-center">';
		html += '		<em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest(\'tr\').remove(); return !1;">&nbsp;</em>';
		html += '	</td>';
		html += '</tr>';
		refresh_count++;
		$('#refresh_config').append(html);
	}
	
	function nv_config_specialgroup_add(bid)
	{
		var html = '';
		html += '<tr>';
		html += '	<td><input type="text" name="specialgroup_config[' + bid + '][' + specialgroup_count[bid] + '][time]" class="form-control" /></td>';
		html += '<td><select name="specialgroup_config[' + bid + '][' + specialgroup_count[bid] + '][unit]" class="form-control">';
			<!-- BEGIN: unit_js -->
		html += '	<option value="{UNIT.index}">{UNIT.value}</option>';
			<!-- END: unit_js -->
		html += '</select></td>';
		html += '	<td><input type="text" name="specialgroup_config[' + bid + '][' + specialgroup_count[bid] + '][price]" class="form-control" /></td>';
		html += '	<td><input type="text" name="specialgroup_config[' + bid + '][' + specialgroup_count[bid] + '][price_discount]" class="form-control" /></td>';
		html += '	<td class="text-center">';
		html += '		<em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest(\'tr\').remove(); return !1;">&nbsp;</em>';
		html += '	</td>';
		html += '</tr>';
		specialgroup_count[bid]++;
		$('#specialgroup_' + bid).append(html);
	}
	
	function nv_config_upgrade_group_add(bid)
	{
		var html = '';
		html += '<tr>';
		html += '	<td><input type="text" name="upgrade_group_config[' + bid + '][' + upgrade_group_count[bid] + '][time]" class="form-control" /></td>';
		html += '<td><select name="upgrade_group_config[' + bid + '][' + upgrade_group_count[bid] + '][unit]" class="form-control">';
			<!-- BEGIN: unit_js1 -->
		html += '	<option value="{UNIT.index}">{UNIT.value}</option>';
			<!-- END: unit_js1 -->
		html += '</select></td>';
		html += '	<td><input type="text" name="upgrade_group_config[' + bid + '][' + upgrade_group_count[bid] + '][price]" class="form-control" /></td>';
		html += '	<td><input type="text" name="upgrade_group_config[' + bid + '][' + upgrade_group_count[bid] + '][price_discount]" class="form-control" /></td>';
		html += '	<td class="text-center">';
		html += '		<em class="fa fa-trash-o fa-lg fa-pointer" onclick="$(this).closest(\'tr\').remove(); return !1;">&nbsp;</em>';
		html += '	</td>';
		html += '</tr>';
		upgrade_group_count[bid]++;
		$('#upgrade_group_' + bid).append(html);
	}
</script>
<!-- END: main -->
