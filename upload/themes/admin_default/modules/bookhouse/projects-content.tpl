<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">
<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
<div class="row">
	<div class="col-md-19">
		<div class="panel panel-default">
			<div class="panel-heading">{LANG.main_info}</div>
			<div class="panel-body">
					<input type="hidden" name="id" value="{ROW.id}" />
					<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.projects_name}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19 col-md-21">
							<input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.alias}</strong></label>
						<div class="col-sm-19 col-md-21">
							<div class="input-group">
								<input class="form-control" type="text" name="alias" value="{ROW.alias}" id="id_alias" /> <span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<i class="fa fa-refresh fa-lg" onclick="nv_get_alias('id_alias');">&nbsp;</i>
									</button>
								</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.description}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19 col-md-21">
							<textarea class="form-control" style="height: 100px;" cols="75" rows="5" name="description">{ROW.description}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.descriptionhtml}</strong></label>
						<div class="col-sm-19 col-md-21">{ROW.descriptionhtml}</div>
					</div>
			</div>	
		</div>	
		
		<div class="panel panel-default">
			<div class="panel-heading">Thông tin khác</div>
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Diện tích xây dựng</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="dientichxd" value="{ROW.dientichxd}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Thời gian xây dựng</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="thoigianxd" value="{ROW.thoigianxd}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Thời gian giao nhà</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="thoigiangn" value="{ROW.thoigiangn}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Vốn đầu tư</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="vondautu" value="{ROW.vondautu}"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Chủ đầu tư</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="chudautu" value="{ROW.chudautu}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Diện tích</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="dientich" value="{ROW.dientich}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Số phòng</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="sophong" value="{ROW.sophong}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Số Block</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="soblock" value="{ROW.soblock}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Số tầng</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="sotang" value="{ROW.sotang}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Số căn hộ</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="socanho" value="{ROW.socanho}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Không gian xanh</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="khonggianxanh" value="{ROW.khonggianxanh}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Mật độ xây dựng</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="matdo" value="{ROW.matdo}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Phí quản lý</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="phiquanly" value="{ROW.phiquanly}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Phí giữ ôtô</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="giuoto" value="{ROW.giuoto}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Phí giữ xe máy</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="giuxemay" value="{ROW.giuxemay}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Giá bán</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="giaban" value="{ROW.giaban}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 col-md-4 control-label"><strong>Giá thuê</strong></label>
						<div class="col-sm-19 col-md-20">
							<input class="form-control" type="text" name="giathue" value="{ROW.giathue}"/>
						</div>
					</div>
			</div>
		</div>
		
		<div class="panel panel-default">	
			<div class="panel-heading">Địa điểm</div>
			<div class="panel-body">
				<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.items_location}</strong><span class="red">(*)</span></label>
						<div class="col-sm-19 col-md-21">{LOCATION}
							<div class="form-group">
								<input type="text" class="form-control" name="address" value="{ROW.address}" placeholder="{LANG.items_address}" />
							</div> 
							<!-- BEGIN: maps -->
					<hr />
					<div class="form-group">
						<input type="text" class="form-control" name="maps_address" id="maps_address" value="" placeholder="{LANG.items_maps_location}">
					</div>
					<script type="text/javascript" src="{NV_BASE_SITEURL}themes/batdongsan05/js/bookhouse-google_maps.js"></script>
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
			</div>
		</div>
		<div class="panel panel-default">	
			<div class="panel-heading">Hình ảnh</div>
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.image}</strong></label>
						<div class="col-sm-19 col-md-21">
							<div id="uploader" class="m-bottom">
								<p>{LANG.images_none_support}</p>
							</div>
							<div class="other-image row" id="image-other">
								<!-- BEGIN: data -->
								<div class="col-xs-4 col-sm-4 col-md-4 other-image-item text-center thumb_booth new-images-append" id="other-image-div-{DATA.number}">
									<input type="hidden" name="otherimage[{DATA.number}][id]" value="{DATA.number}"> <input type="hidden" name="otherimage[{DATA.number}][basename]" value="{DATA.basename}"> <input type="hidden" name="otherimage[{DATA.number}][homeimgfile]" value="{DATA.homeimgfile}"> <input type="hidden" name="otherimage[{DATA.number}][thumb]" value="{DATA.thumb}"> <input type="hidden" name="otherimage[{DATA.number}][name]" value="{DATA.title}"> <input type="hidden" name="otherimage[{DATA.number}][description]" value="{DATA.description}"> <a href="#" onclick="modalShow('{DATA.basename}', '<img src=\'{DATA.filepath}\' class=\'img-responsive\' />'); return false;"> <img style="height: 110px" class="img-thumbnail m-bottom responstyle {DATA.box_img}" src="{DATA.filepath}">
									</a> <em title="{LANG.title_btn_closeimg}" class="fa fa-times-circle fa-lg fa-pointer btn-close_img" onclick="nv_delete_other_images( {DATA.number} ); return false;">&nbsp;</em> <input type="radio" class="input_img hidden" name="homeimg" value="{DATA.number}"{DATA.checked}> <input type="button" class="btn btn-success btn-xs avatar" value="{LANG.choose_img}" onclick="click_btn_avatar({DATA.number})">
								</div>
								<!-- END: data -->
							</div>
						</div>
					</div>
			</div>	
		</div>	
	</div>	
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">Nhóm Dự Án</div>
				<div class="panel-body">
					<label class="show"><input type="checkbox" name="inhome" value="1" {ROW.inhome} />&nbsp;Nổi bật</label>
				</div>
		</div>
		<div class="panel panel-default">
				<div class="panel-heading">Nội thất</div>
				<div class="panel-body">
					<!-- BEGIN: furniture -->
						<div class="furniture">
							<input type="checkbox" name="furniture[]" {checked} value="{furniture.id}"> {furniture.title}
						</div>
						<!-- END: furniture -->
				</div>
		</div>
		<div class="panel panel-default">
				<div class="panel-heading">Tiện ích</div>
				<div class="panel-body">
					<!-- BEGIN: convenient -->
						<div class="convenient">
							<input type="checkbox" name="convenient[]" {checked} value="{convenient.id}"> {convenient.title}
						</div>
						<!-- END: convenient -->
				</div>
		</div>
	</div>	
</div>	
	<div class="form-group text-center">
		<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
	</div>
</form>	
<link type="text/css" href="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">

var initUploader = function () {
    $("#uploader").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: '{UPLOAD_URL}',
//         resize: {
//             width: '{MAXIMAGESIZEULOAD.0}',
//             height: '{MAXIMAGESIZEULOAD.1}'
//         },
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
            FilesAdded: function (up, files) {
                this.start();
                return false;
            },
            UploadComplete: function (up, files) {
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
        if($.parseJSON(response.response).error.length == 0){
            var content = $.parseJSON(response.response).data;
            var item='';
            item+='<div class="col-xs-4 col-sm-3 col-md-3 other-image-item text-center thumb_booth new-images-append" id="other-image-div-' + i + '">';
            item+='                 <input type="hidden" name="otherimage['+ i +'][id]" value="'+i+'">';
            item+='                 <input type="hidden" name="otherimage['+ i +'][basename]" value="'+ content['basename'] +'">';
            item+='                 <input type="hidden" name="otherimage['+ i +'][homeimgfile]" value="'+ content['homeimgfile'] +'">';
            item+='                 <input type="hidden" name="otherimage['+ i +'][thumb]" value="'+ content['thumb'] +'">';
            item+='                 <input type="hidden" name="otherimage['+ i +'][name]" value="' + content['basename'] + '" >';
            item+='                 <input type="hidden" name="otherimage['+ i +'][description]" value="' + content['description'] + '" >';
            item+='                 <a href="#" onclick="modalShow(\'' + content['basename'] + '\', \'<img src=' + content['image_url'] + ' class=img-responsive />\' ); return false;" >';
            item+='                     <img class="img-thumbnail m-bottom responstyle" src="'+ content['thumb'] +'">';
            item+='                 </a>';
            item+='                 <em title="{LANG.title_btn_closeimg}" class="fa fa-times-circle fa-lg fa-pointer btn-close_img" onclick="nv_delete_other_images_tmp(\'' + content['image_url'] + '\', \'' + content['thumb'] + '\', ' + i + '); return false;">&nbsp;</em>';
            item+='                 <input type="radio" class="radio_btn input_img hidden" name="homeimg" value="'+ i +'">';
            item+='                 <input type="button" class="btn btn-success btn-xs avatar" value="{LANG.choose_img}" onclick="click_btn_avatar(' + i + ')">';
            item+='</div>';
            item+='</div>';

            $('#image-other').append(item);
            ++i;    
        }else{
            alert($.parseJSON(response.response).error.message);
        }
    });
    
    {RADIO_JS}

    uploader.bind("UploadComplete", function (up, files) {
        initUploader();
    });

    uploader.bind('QueueChanged', function() {

    });

    uploader.bind('FilesAdded', function(up, files) {
        if( files.length > j )
        {
            alert( strip_tags( '{LANG.error_required_otherimage}' ) );
            $.each(files, function(i, file) {
                up.removeFile(file);
            });
        }
    });
};

$(document).ready(function(){
    initUploader();
});

$('.images-add').click(function(){
    $('#uploader').show();
    $('.images-add').hide();
});
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    //<![CDATA[
    function click_btn_avatar(id){
        $("#other-image-div-"+id+" .input_img").prop("checked", true);
        $(".responstyle").removeClass('box_img');$
        $("#other-image-div-"+id+" .responstyle").addClass('box_img');$
    }    
    
    $('.select2').select2({
        theme : 'bootstrap',
        language : '{NV_LANG_INTERFACE}'
    });
    
    function nv_get_alias(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=projects-content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title), function(res) {
                $("#" + id).val(strip_tags(res));
            });
        }
        return false;
    }
    //]]>
</script>
<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
    //<![CDATA[
    $("[name='title']").change(function() {
        nv_get_alias('id_alias');
    });
    //]]>
</script>
<!-- END: auto_get_alias -->
<!-- END: main -->