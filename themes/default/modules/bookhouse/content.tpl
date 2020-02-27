<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css" />

<!-- BEGIN: ok -->
<div class="red" style="margin-bottom: 10px">Tin của bạn đã lưu và đăng thành công!</div>
<!-- END: ok -->

<div class="items m-bottom">
	<!-- BEGIN: error -->
	<div class="alert alert-danger">{ERROR}</div>
	<!-- END: error -->
	<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

	<form action="{ACTION}" method="POST" id="items" class="form-horizontal" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-24">
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.main_info}</div>
					<div class="panel-body">


						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.title} <span class="required">(*)</span></strong> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
								<input type="text" class="form-control required" name="title" id="idtitle" value="{DATA.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
							</div>
						</div>
<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.type} <span class="required">(*)</span></strong> </label>
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
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.category_cat_parent}</strong> <span class="required">(*)</span> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
								<select name="catid" id="catid" class="form-control required sselect2" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
									<option value="0">---{LANG.cat_chose}---</option>
									<!-- BEGIN: cat -->
									<option value="{CAT.id}"{CAT.selected}>{CAT.name}</option>
									<!-- END: cat -->
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>Tỉnh/TP</strong> <span class="required">(*)</span> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">{LOCATION}</div>
						</div>
						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_address}</strong> <span class="required">(*)</span> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
								<input type="text" class="form-control required" name="address" required="required" value="{DATA.address}" placeholder="{LANG.items_address}" />
							</div>
						</div>
						
						<div class="form-group">
									<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.projects}</strong></label>
									<div class="col-xs-24 col-sm-20 col-md-20">
										<div>
											<select class="form-control sselect2" name="projectid" id="projectid">
												<option value="0">---{LANG.projetc_select}---</option>
												<!-- BEGIN: projects -->
												<option value="{PROJECTS.id}"{PROJECTS.selected}>{PROJECTS.title}</option>
												<!-- END: projects -->
											</select>
										</div>
									</div>
								</div>

						<!-- BEGIN: room -->
						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_room}</strong></label>
							<div class="col-xs-24 col-sm-20 col-md-20">
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
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_area} (m<sup>2</sup>)
							</strong> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
								<input type="text" class="form-control" name="area" value="{DATA.area}" />
							</div>
						</div>
						<!-- END: area -->

						<!-- BEGIN: size -->
						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.size} (m) </strong> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<input type="text" class="form-control" name="size_h" value="{DATA.size_h}" placeholder="{LANG.size_h}" />
									</div>
									<div class="col-sm-12 col-md-12">
										<input type="text" class="form-control" name="size_v" value="{DATA.size_v}" placeholder="{LANG.size_v}" />
									</div>
								</div>
							</div>
						</div>
						<!-- END: size -->

						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_price}</strong></label>
							<div class="col-xs-24 col-sm-7 col-md-7">
								<input type="text" class="form-control price" name="price" value="{DATA.price}" />
							</div>
							<div class="col-xs-24 col-sm-3 col-md-3">
								<select name="price_time" id="price_time" class="form-control">
									<option value="-1">---Chọn đơn vị---</option>
									<!-- BEGIN: price_time -->
									<option value="{PRICETIME.index}" {PRICETIME.selected}>{PRICETIME.value}</option>
									<!-- END: price_time -->
								</select>
							</div>

							<div class="col-xs-24 col-sm-3 col-md-3">
								<label class="show hienthigia"><input type="checkbox" name="showprice" value="1" {DATA.showprice} />&nbsp;{LANG.items_showprice}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.items_image}</strong></label>
							<div class="col-sm-19 col-md-20">
								<div class="m-bottom">
									<div class="input-group">
										<input type="text" class="form-control" name="homeimgfile" value="{DATA.homeimgfile}" id="file_name" readonly="readonly"> <span class="input-group-btn">
											<button class="btn btn-default" onclick="$('#upload_fileupload').click();" type="button">
												<em class="fa fa-folder-open-o fa-fix">&nbsp;</em> {LANG.file_selectfile}
											</button>
										</span>
									</div>
									<input type="file" name="upload_fileupload" id="upload_fileupload" style="display: none" />
								</div>
								<em class="help-block"><small>{LANG.maxfilesize}: <strong>{MAXFILESIZE}</strong>.
								</small></em>
								<!-- BEGIN: image -->
								<a href="#" title=""><img src="{DATA.homeimgfile}" class="img-thumbnail" width="150" onclick='modalShow("", "<img src=" + $(this).attr("src") + " class=\"img-responsive\" />" );' /></a>
								<!-- END: image -->
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.image_other}</strong></label>
							<div class="col-sm-19 col-md-20">
								<div class="form-group11">
									<style>
.plupload_header {
	display: none
}

.plupload_container {
	padding: 0
}
</style>


									<div id="uploader" class="m-bottom">
										<p>{LANG.images_none_support}</p>
									</div>
									<em class="help-block"><small>{LANG.image_other_add_note}</strong>.
									</small></em>
									<div class="other-image row" id="image-other">
										<!-- BEGIN: data -->

										<div class="col-xs-4 col-sm-3 col-md-3 other-image-item" id="other-image-div-{DATA.number}">
											<input type="hidden" name="otherimage[{DATA.number}][id]" value="{DATA.id}"> <input type="hidden" name="otherimage[{DATA.number}][basename]" value="{DATA.title}"> <input type="hidden" name="otherimage[{DATA.number}][homeimgfile]" value="{DATA.homeimgfile}"> <input type="hidden" name="otherimage[{DATA.number}][thumb]" value="{DATA.thumb}"> <input type="hidden" name="otherimage[{DATA.number}][name]" value="{DATA.title}"> <input type="hidden" name="otherimage[{DATA.number}][description]" value="{DATA.description}"> <a href="#" onclick="modalShow('{DATA.basename}', '<img src=\'{DATA.filepath}\' class=\'img-responsive\' />'); return false;"> <img class="img-thumbnail m-bottom" src="{DATA.filepath}"></a> <em class="fa fa-times-circle fa-lg fa-pointer" onclick="nv_delete_other_images( {DATA.number} ); return false;">&nbsp;</em>
										</div>
										<!-- END: data -->
									</div>
								</div>

							</div>
						</div>


						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_bodytext}</strong><span class="required">(*)</span></label>
							<div class="col-xs-24 col-sm-20 col-md-20">{BODYTEXT}</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.items_keywords}</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-xs-24 col-sm-4 col-md-4 control-label"><strong>{LANG.items_keywords} </strong> </label>
							<div class="col-xs-24 col-sm-20 col-md-20">
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

					</div>
				</div>


				<div class="panel panel-default">
					<div class="panel-heading">{LANG.other_info}</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-8 control-label"><strong>{LANG.legal}</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-16">
										<select class="form-control" name="legal">
											<option value="0">---{LANG.legal_c}---</option>
											<!-- BEGIN: legal -->
											<option value="{LEGAL.id}"{LEGAL.selected}>{LEGAL.title}</option>
											<!-- END: legal -->
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-8 control-label"><strong>{LANG.front} (m)</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-16">
										<div class="input-group11">
											<input type="text" name="front" value="{DATA.front}" class="form-control" />
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-8 control-label"><strong>{LANG.so_tang}</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-16">
										<div>
											<input type="text" name="so_tang" value="{DATA.so_tang}" class="form-control" />
										</div>
									</div>
								</div>
								
							</div>
							<div class="col-sm-12 col-md-12">

								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-6 control-label"><strong>{LANG.way}</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-18">
										<select class="form-control" name="way">
											<option value="0">---{LANG.way_c}---</option>
											<!-- BEGIN: way -->
											<option value="{WAY.id}"{WAY.selected}>{WAY.title}</option>
											<!-- END: way -->
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-6 control-label"><strong>{LANG.road} (m)</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-18">
										<div class="input-group11">
											<input type="text" name="road" value="{DATA.road}" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-6 col-sm-6 col-md-6 control-label"><strong>{LANG.so_phong}</strong></label>
									<div class="col-xs-18 col-sm-18 col-md-18">
										<div>
											<input type="text" name="so_phong" value="{DATA.so_phong}" class="form-control" />
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col-xs-24 col-sm-24 col-md-24">
								<div class="form-group">
									<label class="col-md-4 control-label"><strong>{LANG.items_hometext}</strong></label>
									<div class="col-md-20">
										<textarea class="form-control" rows="5" name="hometext">{DATA.hometext}</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- BEGIN: contact_info -->
					<div class="panel panel-default">
						<div class="panel-heading">{LANG.contact_info}</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_fullname}</strong><span class="required"> (*)</span></label>
								<div class="col-sm-19 col-md-20">
									<input class="form-control required" type="text" name="contact_fullname" value="{DATA.contact_fullname}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_phone}</strong><span class="required"> (*)</span></label>
								<div class="col-sm-19 col-md-20">
									<input class="form-control required" type="text" name="contact_phone" value="{DATA.contact_phone}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.contact_email}</strong></label>
								<div class="col-sm-19 col-md-20">
									<input class="form-control" type="email" name="contact_email" value="{DATA.contact_email}" oninvalid="setCustomValidity( nv_email )" oninput="setCustomValidity('')" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
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
			
			<div class="text-center">

				<!-- BEGIN: requeue -->
				<div class="alert alert-warning text-center">
					<p class="m-bottom">{LANG.requeue_note}</p>
					<label class="show"><input type="checkbox" name="requeue" value="1" />{LANG.requeue}</label>
				</div>
				<!-- END: requeue -->
				<input type="submit" name="submit" class="btn btn-primary" value="{LANG.items_submit}" />
			</div>
	</form>

	<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/js/bookhouse_autoNumeric-1.9.41.js"></script>
	<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
	<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
	<script type="text/javascript">
		//<![CDATA[
		var file_items = '{FILE_ITEMS}';
		var file_selectfile = '{LANG.items_chose_image}';
		var nv_base_adminurl = '{NV_BASE_ADMINURL}';
		var file_dir = '{UPLOAD_DIR}';
		var items_del_otherimage = '{LANG.items_other_image_del}';
		var items_image_del = '{LANG.items_image_del}';
		
		var Options = {
			aSep : '{DES_POINT}',
			aDec : '{THOUSANDS_SEP}',
			vMin : '0',
			vMax : '99999999999999999'
		};
		
		$(document).ready(function() {
			
			
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
			
			$('.sselect2').select2({
				language: '{NV_LANG_INTERFACE}',
				theme: 'bootstrap'
			});
		});

		function nv_location_change(type, value){
			var provinceid = $('#provinceid-0 option:selected').val();
			var districtid = $('#districtid-0 option:selected').val();
			var wardid = $('#wardid-0 option:selected').val();

			$.ajax({
				type : 'POST',
				dataType: 'html',
				url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),
				data : 'getprojects=1&provinceid=' + provinceid + '&districtid=' + districtid + '&wardid = ' + wardid ,
				success : function(data) {
					$('#projectid').html(data); 
				}
			});
		}

		function nv_add_element(idElment, key, value) {
			var html = "<span title=\"" + value + "\" class=\"uiToken removable\">" + value + "<input type=\"hidden\" value=\"" + key + "\" name=\"" + idElment + "[]\" autocomplete=\"off\"><a onclick=\"$(this).parent().remove();\" href=\"javascript:void(0);\" class=\"remove uiCloseButton uiCloseButtonSmall\"></a></span>";
			$("#" + idElment).append(html);
			return false;
		}

		$(".selectimg").click(function() {
			var area = "homeimg";
			var alt = "homeimgalt";
			var path = "{UPLOAD_DIR}";
			var type = "image";
			nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
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

	<link type="text/css" href="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" />
	<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/plupload.full.min.js"></script>
	<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/i18n/{NV_LANG_INTERFACE}.js"></script>
	<script type="text/javascript">
    var initUploader = function() {
        $("#uploader").pluploadQueue({
            runtimes: 'html5,flash,silverlight,html4',
            url: '{UPLOAD_URL}',
            resize: {
                width: '{MAXIMAGESIZEULOAD.0}',
                height: '{MAXIMAGESIZEULOAD.1}'
            },
            chunk_size: '{MAXFILESIZEULOAD}',
            max_retries: 3,
            rename: false,
            dragdrop: true,
            filters: {
                max_file_size: '{MAXFILESIZEULOAD}',
                mime_types: [{
                    title: "Image files",
                    extensions: "jpg,gif,png,jpeg"
                }, ]
            },
            flash_swf_url: '{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/Moxie.swf',
            silverlight_xap_url: '{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/Moxie.xap',
            multi_selection: true,
            prevent_duplicates: true,
            multiple_queues: false,
            init: {
                FilesAdded: function(up, files) {
                    this.start();
                    return false;
                },
                UploadComplete: function(up, files) {
                    $(".plupload_buttons").css("display", "inline");
                    $(".plupload_upload_status").css("display", "inline");
                }
            }
        });
        var uploader = $("#uploader").pluploadQueue();
        uploader.bind('BeforeUpload', function(up) {
            up.settings.multipart_params = {
                'folder': ''
            };
        });
        var j = '{COUNT_UPLOAD}';
        var i = '{COUNT}';
        uploader.bind('FileUploaded', function(up, file, response) {
            if ($.parseJSON(response.response).error.length == 0) {
                var content = $.parseJSON(response.response).data;
                var item = '';
                item += '<div class="col-xs-4 col-sm-3 col-md-3 other-image-item new-images-append" id="other-image-div-' + i + '">';
                item += '                 <input type="hidden" name="otherimage[' + i + '][id]" value="0">';
                item += '                 <input type="hidden" name="otherimage[' + i + '][basename]" value="' + content['basename'] + '">';
                item += '                 <input type="hidden" name="otherimage[' + i + '][homeimgfile]" value="' + content['homeimgfile'] + '">';
                item += '                 <input type="hidden" name="otherimage[' + i + '][thumb]" value="' + content['thumb'] + '">';
                item += '                 <input type="hidden" name="otherimage[' + i + '][name]" value="' + content['basename'] + '" >';
                item += '                 <input type="hidden" name="otherimage[' + i + '][description]" value="' + content['description'] + '" >';
                item += '                 <a href="#" onclick="modalShow(\'' + content['basename'] + '\', \'<img src=' + content['image_url'] + ' class=img-responsive />\' ); return false;" >';
                item += '                     <img class="img-thumbnail m-bottom" src="' + content['thumb'] + '">';
                item += '                 </a>';
                item += '                 <em class="fa fa-times-circle fa-lg fa-pointer" onclick="nv_delete_other_images_tmp(\'' + content['image_url'] + '\', \'' + content['thumb'] + '\', ' + i + '); return false;">&nbsp;</em>';
                item += '</div>';
                item += '</div>';
                $('#image-other').append(item);
                ++i;
            } else {
                alert($.parseJSON(response.response).error.message);
            }
        });
        uploader.bind("UploadComplete", function(up, files) {
            initUploader();
        });
        uploader.bind('QueueChanged', function() {});
        uploader.bind('FilesAdded', function(up, files) {
            if (files.length > j) {
                alert(strip_tags('{LANG.error_required_otherimage}'));
                $.each(files, function(i, file) {
                    up.removeFile(file);
                });
            }
        });
    };
    $(document).ready(function() {
        initUploader();
    });

    $('.images-add').click(function() {
        $('#uploader').show();
        $('.images-add').hide();
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
</script>

	<!-- BEGIN: change_alias -->
	<script type="text/javascript">
		$("#idtitle").change(function() {
			get_alias();
		});
	</script>
	<!-- END: change_alias -->
</div>
<!-- END: main -->
