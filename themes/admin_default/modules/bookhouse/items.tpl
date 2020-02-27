<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css" />

<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<form action="{ACTION}" method="POST" id="items" class="form-horizontal">
	<input type="hidden" name="status" value="{DATA.status}" />
	<div class="row">
		<div class="col-md-19">
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.main_info}</div>
				<div class="panel-body">

					<div class="form-group">
						<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.type}</strong> </label>
						<div class="col-xs-24 col-sm-20 col-md-20">
							<select class="form-control required" name="typeid" id="typeid" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
								<option value="">---{LANG.type_select}---</option>
								<!-- BEGIN: type -->
								<option value="{TYPE.id}"{TYPE.selected}>{TYPE.title}</option>
								<!-- END: type -->
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.title}</strong> <span class="red">*</span></label>
						<div class="col-sm-20">
							<input type="text" class="form-control" name="title" id="idtitle" value="{DATA.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.alias}</strong></label>
						<div class="col-sm-20">
							<div class="input-group">
								<input type="text" class="form-control" name="alias" id="idalias" value="{DATA.alias}" /> <span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<i class="fa fa-refresh fa-lg" onclick="get_alias();">&nbsp;</i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_code}</strong> <!-- BEGIN: code_auto --><em class="fa fa-question-circle fa-pointer text-info" data-toggle="tooltip" data-original-title="{LANG.items_code_note}">&nbsp;</em><!-- END: code_auto --></label>
						<div class="col-sm-20">
							<input type="text" class="form-control" name="code" value="{DATA.code}" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.category_cat_parent}</strong> <span class="red">*</span></label>
						<div class="col-sm-20">
							<select name="catid" id="catid" class="form-control sselect2" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
								<option value="0">---{LANG.cat_chose}---</option>
								<!-- BEGIN: cat -->
								<option value="{CAT.id}"{CAT.selected}>{CAT.name}</option>
								<!-- END: cat -->
							</select>
						</div>
					</div>

					<!-- BEGIN: room -->
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_room}</strong></label>
						<div class="col-sm-20">
							<div style="max-height: 200px; overflow: auto">
								<table class="table table-striped table-bordered table-hover w400">
									<tbody>
										<!-- BEGIN: loop -->
										<tr>
											<td>{ROOM.name}</td>
											<td><input type="number" name="room[{ROOM.id}]" value="{ROOM.value}" class="form-control" /></td>
										</tr>
										<!-- END: loop -->
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END: room -->

					<!-- BEGIN: area -->
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_area} (m<sup>2</sup>)
						</strong></label>
						<div class="col-sm-20">
							<input type="text" class="form-control" name="area" value="{DATA.area}" />
						</div>
					</div>
					<!-- END: area -->

					<!-- BEGIN: size -->
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.size} (m) </strong></label>
						<div class="col-sm-20">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" class="form-control" name="size_h" value="{DATA.size_h}" placeholder="{LANG.size_h}" />
								</div>
								<div class="col-sm-12">
									<input type="text" class="form-control" name="size_v" value="{DATA.size_v}" placeholder="{LANG.size_v}" />
								</div>
							</div>
						</div>
					</div>
					<!-- END: size -->

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_price}</strong> <span class="red">*</span></label>
						<div class="col-sm-7">
							<input type="text" class="form-control price" name="price" value="{DATA.price}" />
						</div>
						<div style="display:none" class="col-sm-3">
							<select class="form-control" name="money_unit">
								<!-- BEGIN: money_unit -->
								<option value="{UNIT.key}"{UNIT.selected}>{UNIT.value}</option>
								<!-- END: money_unit -->
							</select>
						</div>
						<div class="col-sm-10">
							<select name="price_time" id="price_time" class="form-control">
								<option value="0">---{LANG.price_limit}---</option>
								<!-- BEGIN: price_time -->
								<option value="{PRICETIME.index}"{PRICETIME.selected}>{PRICETIME.value}</option>
								<!-- END: price_time -->
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_image}</strong></label>
						<div class="col-sm-20">
							<div class="input-group m-bottom">
								<input type="text" class="form-control" id="homeimg" name="image" value="{DATA.homeimgfile}" placeholder="{LANG.items_imagelink}" /> <span class="input-group-btn">
									<button class="btn btn-default selectimg" type="button">
										<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
									</button>
								</span>
							</div>
							<input type="text" class="form-control m-bottom" id="homeimgalt" name="homeimgalt" value="{DATA.homeimgalt}" placeholder="{LANG.items_imagealt}" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_hometext}</strong> </label>
						<div class="col-sm-20">
							<textarea class="form-control" rows="5" name="hometext">{DATA.hometext}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.items_bodytext}</strong></label>
						<div class="col-sm-20">{BODYTEXT}</div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.other_info}</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.front}</strong></label>
						<div class="col-sm-20">
							<div class="input-group">
								<input type="text" name="front" value="{DATA.front}" class="form-control" />
								<div class="input-group-addon">{LANG.met}</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>{LANG.road}</strong></label>
						<div class="col-sm-20">
							<div class="input-group">
								<input type="text" name="road" value="{DATA.road}" class="form-control" />
								<div class="input-group-addon">{LANG.met}</div>
							</div>
						</div>
					</div>
					<div class="form-group">
							<label class="col-sm-4 control-label"><strong>{LANG.so_tang}</strong></label>
							<div class="col-sm-20">
								<div>
									<input type="text" name="so_tang" value="{DATA.so_tang}" class="form-control" />
								</div>
							</div>
					</div>
					<div class="form-group">
								<label class="col-sm-4 control-label"><strong>{LANG.so_phong}</strong></label>
								<div class="col-sm-20">
									<div>
										<input type="text" name="so_phong" value="{DATA.so_phong}" class="form-control" />
									</div>
								</div>
							</div>
					
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.items_location}</div>
				<div class="panel-body">
					<div class="form-group">{LOCATION}</div>
					<div class="form-group">
						<input type="text" class="form-control" name="address" value="{DATA.address}" placeholder="{LANG.items_address}" />
					</div>
					<!-- BEGIN: maps -->
					<hr />
					<div class="form-group">
						<input type="text" class="form-control" name="maps_address" id="maps_address" value="" placeholder="{LANG.items_maps_location}">
					</div>
					<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/js/bookhouse-google_maps.js"></script>
					<input type="hidden" id="maps_appid" value="{MAPS_APPID}" />
					<div id="maps_maparea">
						<div id="maps_mapcanvas" style="margin-top: 10px;" class="form-group"></div>
						<div class="row form-group">
							<div class="col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">L</span> <input type="text" class="form-control" name="maps[maps_mapcenterlat]" id="maps_mapcenterlat" value="{DATA.maps.maps_mapcenterlat}" readonly="readonly">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">N</span> <input type="text" class="form-control" name="maps[maps_mapcenterlng]" id="maps_mapcenterlng" value="{DATA.maps.maps_mapcenterlng}" readonly="readonly">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">L</span> <input type="text" class="form-control" name="maps[maps_maplat]" id="maps_maplat" value="{DATA.maps.maps_maplat}" readonly="readonly">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">N</span> <input type="text" class="form-control" name="maps[maps_maplng]" id="maps_maplng" value="{DATA.maps.maps_maplng}" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="input-group">
									<span class="input-group-addon">Z</span> <input type="text" class="form-control" name="maps[maps_mapzoom]" id="maps_mapzoom" value="{DATA.maps.maps_mapzoom}" readonly="readonly">
								</div>
							</div>
						</div>
					</div>
					<!-- END: maps -->
					<!-- BEGIN: required_maps_appid -->
					<div class="alert alert-danger">{LANG.items_required_maps_appid}</div>
					<!-- END: required_maps_appid -->
				</div>
			</div>
			<!-- BEGIN: contact_info -->
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.contact_info}</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_fullname}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="contact_fullname" value="{DATA.contact_fullname}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_phone}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="contact_phone" value="{DATA.contact_phone}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_email}</strong> </label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="email" name="contact_email" value="{DATA.contact_email}" oninvalid="setCustomValidity( nv_email )" oninput="setCustomValidity('')"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_address}</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="contact_address" value="{DATA.contact_address}" />
						</div>
					</div>
				</div>
			</div>
			<!-- END: contact_info -->
		</div>
		<div class="col-md-5">
			<!-- BEGIN: block_cat -->
			<div class="panel panel-default nhom_tin">
				<div class="panel-heading">{LANG.groups}</div>
				<div class="panel-body">
					<!-- BEGIN: loop -->
					<label class="show"><input type="checkbox" value="{BLOCKS.bid}" name="bids[]"{BLOCKS.checked}>{BLOCKS.title}</label>
					<!-- END: loop -->
				</div>
			</div>
			<!-- END: block_cat -->
			
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.projects}</div>
				<div class="panel-body">
					<select class="form-control sselect2" id="projectid" name="projectid">
						<option value="0">---{LANG.projetc_select}---</option>
						<!-- BEGIN: projects -->
						<option value="{PROJECTS.id}"{PROJECTS.selected}>{PROJECTS.title}</option>
						<!-- END: projects -->
					</select>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.way}</div>
				<div class="panel-body">
					<select class="form-control" name="way">
						<option value="0">---{LANG.way_c}---</option>
						<!-- BEGIN: way -->
						<option value="{WAY.id}"{WAY.selected}>{WAY.title}</option>
						<!-- END: way -->
					</select>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.legal}</div>
				<div class="panel-body">
					<select class="form-control" name="legal">
						<option value="0">---{LANG.legal_c}---</option>
						<!-- BEGIN: legal -->
						<option value="{LEGAL.id}"{LEGAL.selected}>{LEGAL.title}</option>
						<!-- END: legal -->
					</select>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.exptime}</div>
				<div class="panel-body">
					<div class="row m-bottom">
						<div class="col-xs-12">
							<select class="form-control" name="exptime_hour">
								<option value="-1">---{LANG.hour_select}---</option>
								<!-- BEGIN: exptime_hour -->
								<option value="{HOUR.index}" {HOUR.selected}>{HOUR.index}</option>
								<!-- END: exptime_hour -->
							</select>
						</div>
						<div class="col-xs-12">
							<select class="form-control" name="exptime_min">
								<option value="-1">---{LANG.min_select}---</option>
								<!-- BEGIN: exptime_min -->
								<option value="{MIN.index}" {MIN.selected}>{MIN.index}</option>
								<!-- END: exptime_min -->
							</select>
						</div>
					</div>
					<div class="input-group">
						<input class="form-control datepicker" value="{DATA.exptime_f}" type="text" name="exptime" readonly="readonly" /> <span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<em class="fa fa-calendar fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.items_keywords}</div>
				<div class="panel-body">
					<div class="message_body" style="overflow: auto">
						<div class="clearfix uiTokenizer uiInlineTokenizer">
							<div id="keywords" class="tokenarea">
								<!-- BEGIN: keywords -->
								<span class="uiToken removable" title="{KEYWORDS}"> {KEYWORDS} <input type="hidden" autocomplete="off" name="keywords[]" value="{KEYWORDS}" /> <a onclick="$(this).parent().remove();" class="remove uiCloseButton uiCloseButtonSmall" href="javascript:void(0);"></a>
								</span>
								<!-- END: keywords -->
							</div>
							<div class="uiTypeahead">
								<div class="wrap">
									<input type="hidden" class="hiddenInput" autocomplete="off" value="" />
									<div class="innerWrap">
										<input id="keywords-search" type="text" placeholder="{LANG.items_keyword_tags}" class="form-control textInput" style="width: 100%;" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.items_other}</div>
				<div class="panel-body">
					<label class="show"><input type="checkbox" name="inhome" value="1" {DATA.inhome} />&nbsp;{LANG.items_inhome}</label> <label class="show"><input type="checkbox" name="showprice" value="1" {DATA.showprice} />&nbsp;{LANG.items_showprice}</label>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.items_allowed_comm}</div>
				<div class="panel-body">
					<!-- BEGIN: allowed_comm -->
					<label class="show"><input type="checkbox" name="allowed_comm[]" value="{ALLOWED_COMM.value}" {ALLOWED_COMM.checked} />{ALLOWED_COMM.title}</label>
					<!-- END: allowed_comm -->
				</div>
			</div>
			<!-- BEGIN: status -->
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.items_status}</div>
				<div class="panel-body">
					<!-- BEGIN: loop -->
					<p>
						<label><input type="radio" name="status" value="{STATUS.key}" {STATUS.checked} />{STATUS.title}</label>
					</p>
					<!-- END: loop -->
				</div>
			</div>
			<!-- END: status -->
		</div>
	</div>
	<!-- BEGIN: queue -->
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.queue_action}</div>
		<div class="panel-body">
			<!-- BEGIN: queue_logs -->
			<div class="form-group">
				<label class="col-sm-5 col-md-3 text-right"><strong>{LANG.queue_logs}</strong></label>
				<div class="col-sm-19 col-md-21">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<colgroup>
								<col />
							</colgroup>
							<thead>
								<tr>
									<th>{LANG.queue_type}</th>
									<th>{LANG.queue_reason}</th>
									<th>{LANG.reason_other}</th>
									<th>{LANG.queue_userid}</th>
									<th>{LANG.queue_time}</th>
								</tr>
							</thead>
							<tbody>
								<!-- BEGIN: loop -->
								<tr>
									<td>{QUEUE_LOGS.type}</td>
									<td>{QUEUE_LOGS.reasonid}</td>
									<td>{QUEUE_LOGS.reason}</td>
									<td>{QUEUE_LOGS.name}</td>
									<td>{QUEUE_LOGS.addtime}</td>
								</tr>
								<!-- END: loop -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- END: queue_logs -->
			<div class="form-group">
				<label class="col-sm-5 col-md-3 text-right"><strong>{LANG.queue_action_atc}</strong></label>
				<div class="col-sm-19 col-md-21">
					<!-- BEGIN: queue_action -->
					<label><input type="radio" name="queue" value="{QUEUE_ACTION.index}" {QUEUE_ACTION.checked} />{QUEUE_ACTION.value}</label>&nbsp;&nbsp;&nbsp;
					<!-- END: queue_action -->
				</div>
			</div>
			<div id="queue_reason" {DATA.queue_reason_style}>
				<div class="form-group">
					<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.reason_c}</strong></label>
					<div class="col-sm-19 col-md-21">
						<select name="queue_reasonid" class="form-control">
							<option value="0">---{LANG.reason_c}---</option>
							<!-- BEGIN: reason -->
							<option value="{REASON.id}">{REASON.title}</option>
							<!-- END: reason -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.reason_f}</strong></label>
					<div class="col-sm-19 col-md-21">
						<textarea class="form-control" name="queue_reason">{DATA.queue_reason}</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: queue -->
	<div class="text-center">
		<input type="submit" name="submit" class="btn btn-primary" value="{LANG.items_submit}" />
	</div>
</form>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/js/bookhouse_autoNumeric-1.9.41.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">

$('.nhom_tin input[type="checkbox"]').on('change', function() {
   $('.nhom_tin input[type="checkbox"]').not(this).prop('checked', false);
});

	//<![CDATA[
	var file_items = '{FILE_ITEMS}';
	var file_selectfile = '{LANG.items_chose_image}';
	var nv_base_adminurl = '{NV_BASE_ADMINURL}';
	var file_dir = '{UPLOAD_DIR}';
	var items_del_otherimage = '{LANG.items_other_image_del}';
	var items_image_del = '{LANG.items_image_del}';

	$(document).ready(function() {
		$('.sselect2').select2({
			language : '{NV_LANG_INTERFACE}',
			theme : 'bootstrap'
		});

		$(".datepicker").datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: !0,
			changeYear: !0,
			showOtherMonths: !0,
			showOn: "focus",
			yearRange: "-90:+5"
		});
		
		$('#typeid').change(function(){
			$.ajax({
				type : 'POST',
				dataType: 'html',
				url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),
				data : 'getcat=1&typeid=' + $(this).val(),
				success : function(data) {
					$('#catid').html(data);
				}
			});

$.ajax({
				type : 'POST',
				dataType: 'html',
				url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),
				data : 'getpricetype=1&typeid=' + $(this).val(),
				success : function(data) {
					$('#price_time').html(data);
				}
			});

		});
		
		var Options = {
			aSep : '{DES_POINT}',
			aDec : '{THOUSANDS_SEP}',
			vMin : '0',
			vMax : '999999999999999999'
		};
	
		
		$('input[name="queue"]').change(function(){
			if($(this).val() == 2){
				$('#queue_reason').show();
			}else{
				$('#queue_reason').hide();
			}
		});

		$("#keywords-search").bind("keydown",function(event) {
			if (event.keyCode === $.ui.keyCode.TAB
					&& $(this).data(
							"ui-autocomplete").menu.active) {
				event.preventDefault();
			}

			if (event.keyCode == 13) {
				var keywords_add = $(
						"#keywords-search")
						.val();
				keywords_add = trim(keywords_add);
				if (keywords_add != '') {
					nv_add_element('keywords',
							keywords_add,
							keywords_add);
					$(this).val('');
				}
				return false;
			}
		}).autocomplete({
			source : function(request, response) {
				$.getJSON(
					script_name
							+ "?"
							+ nv_name_variable
							+ "="
							+ nv_module_name
							+ "&"
							+ nv_fc_variable
							+ "=tagsajax",
					{
						term : extractLast(request.term)
					}, response);
			},
			search : function() {
				// custom minLength
				var term = extractLast(this.value);
				if (term.length < 2) {
					return false;
				}
			},
			focus : function() {
				//no action
			},
			select : function(event, ui) {
				// add placeholder to get the comma-and-space at the end
				if (event.keyCode != 13) {
					nv_add_element('keywords',
							ui.item.value,
							ui.item.value);
					$(this).val('');
				}
				return false;
			}
		});

		$("#keywords-search").blur(
				function() {
					// add placeholder to get the comma-and-space at the end
					var keywords_add = $("#keywords-search")
							.val();
					keywords_add = trim(keywords_add);
					if (keywords_add != '') {
						nv_add_element('keywords',
								keywords_add, keywords_add);
						$(this).val('');
					}
					return false;
				});
		$("#keywords-search").bind("keyup",function(event) {
			var keywords_add = $(
					"#keywords-search").val();
			if (keywords_add.search(',') > 0) {
				keywords_add = keywords_add
						.split(",");
				for (i = 0; i < keywords_add.length; i++) {
					var str_keyword = trim(keywords_add[i]);
					if (str_keyword != '') {
						nv_add_element(
								'keywords',
								str_keyword,
								str_keyword);
					}
				}
				$(this).val('');
			}
			return false;
		});
	});

	function nv_location_change(type, value){
		$.ajax({
			type : 'POST',
			dataType: 'html',
			url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),
			data : 'getprojects=1&type=' + type + '&value=' + value,
			success : function(data) {
				$('#projectid').html(data);
			}
		});
	}

	function split(val) {
		return val.split(/,\s*/);
	}

	function extractLast(term) {
		return split(term).pop();
	}

	function nv_add_element(idElment, key, value) {
		var html = "<span title=\"" + value + "\" class=\"uiToken removable\">"
				+ value
				+ "<input type=\"hidden\" value=\"" + key + "\" name=\"" + idElment + "[]\" autocomplete=\"off\"><a onclick=\"$(this).parent().remove();\" href=\"javascript:void(0);\" class=\"remove uiCloseButton uiCloseButtonSmall\"></a></span>";
		$("#" + idElment).append(html);
		return false;
	}

	$(".selectimg").click(function() {
		var area = "homeimg";
		var alt = "homeimgalt";
		var path = "{UPLOAD_DIR}";
		var currentpath = "{CURRENTPATH}";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable
				+ "=upload&popup=1&area=" + area + "&alt="
				+ alt + "&path=" + path + "&currentpath="
				+ currentpath + "&type=" + type, "NVImg", 850,
				420,
				"resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});

	$('[type="submit"]').hover(function() {
		if ($('[name="keywords[]"]').length == 0) {
			if ($('#message-tags').length == 0) {
				$('#message').html('<div id="message-tags" class="alert alert-danger">{LANG.content_tags_empty}.<!-- BEGIN: auto_tags --> {LANG.content_tags_empty_auto}.<!-- END: auto_tags --></div>');
			}
		} else {
			$('#message-tags').remove();
		}
	});
	//]]>
</script>

<!-- BEGIN: change_alias -->
<script type="text/javascript">
	$("#idtitle").change(function() {
		get_alias();
	});
</script>
<!-- END: change_alias -->
<!-- END: main -->
