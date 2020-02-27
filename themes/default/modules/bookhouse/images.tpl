<!-- BEGIN: main -->
<div class="images m-bottom">
	<!-- BEGIN: error -->
	<div class="alert alert-danger">{ERROR}</div>
	<!-- END: error -->

	<div class="m-bottom">
		<div class="pull-left">
			<h1>{PAGE_TITLE}</h1>
		</div>
		<div class="pull-right">
			<a href="{URL_LIST}" title="{LANG.images_back_list}"><button class="btn btn-danger btn-xs">
					<em class="fa fa-bars fa-lg">&nbsp;</em>{LANG.images_back_list}
				</button></a>
			<button class="btn btn-success btn-xs images-add <!-- BEGIN: disabled_add -->disabled<!-- END: disabled_add -->">
				<em class="fa fa-upload fa-lg">&nbsp;</em>{LANG.images_add}
			</button>
		</div>
		<div class="clearfix"></div>
	</div>

	<blockquote>
		<ul class="items_note">
			<li>{LANG.items_note6}</li>
			<li>{LANG.items_note2}</li>
		</ul>
	</blockquote>

	<div id="uploader" class="m-bottom"
		<!-- BEGIN: images_add -->
		style="display: block"
		<!-- END: images_add -->
		>
		<p>{LANG.images_none_support}</p>
	</div>

	<div class="clearfix"></div>

	<form action="" method="post">
		<input type="hidden" name="rows_id" value="{ID}" />

		<!-- BEGIN: data -->
		<!-- BEGIN: loop -->
		<div class="panel panel-default" id="other-image-div-{DATA.number}">
			<div class="panel-body">
				<div class="col-xs-24 col-sm-4 col-md-4 text-center">
					<input type="hidden" name="otherimage[{DATA.number}][id]" value="{DATA.id}"> <input type="hidden" name="otherimage[{DATA.number}][basename]" value="{DATA.title}"> <input type="hidden" name="otherimage[{DATA.number}][homeimgfile]" value="{DATA.homeimgfile}"> <input type="hidden" name="otherimage[{DATA.number}][thumb]" value="{DATA.thumb}"> <a href="#" onclick="modalShow('{DATA.basename}', '<img src=\'{DATA.filepath}\' class=\'img-responsive\' />'); return false;"> <img class="img-thumbnail m-bottom" src="{DATA.filepath}">
					</a>
					<p>
						<i class="fa fa-trash-o fa-lg">&nbsp;</i><a href="" onclick="nv_delete_other_images( {DATA.number} ); return false;">{LANG.images_delete}</a>
					</p>
				</div>
				<div class="col-xs-24 col-sm-20 col-md-20">
					<div class="form-group">
						<input type="text" name="otherimage[{DATA.number}][name]" value="{DATA.title}" class="form-control" placeholder="{LANG.images_name}">
					</div>
					<div class="form-group">
						<textarea name="otherimage[{DATA.number}][description]" class="form-control" placeholder="{LANG.images_description}">{DATA.description}</textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- END: loop -->
		<!-- END: data -->

		<div id="image-other"></div>

		<div class="text-center alert alert-info info-image-number"
			<!-- BEGIN: empty -->
			style="display: block"
			<!-- END: empty -->
			> {LANG.images_empty}<br />
			<!-- BEGIN: alert_image_add -->
			<a href="#" class="images-add">[{LANG.images_add}]</a>
			<!-- END: alert_image_add -->
		</div>

		<div class="text-center btn-submit"
			<!-- BEGIN: btn_submit -->
			style="display: block"
			<!-- END: btn_submit -->
			> <input type="submit" class="btn btn-primary" value="{LANG.save}" name="submit" />
		</div>
	</form>
</div>

<link type="text/css" href="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/plupload/i18n/vi.js"></script>
<script type="text/javascript">
	$(function() {
		$("#uploader").pluploadQueue({
			runtimes: 'html5,flash,silverlight,html4',
			url: '{UPLOAD_URL}',
			resize: {
				width: '{MAXIMAGESIZE.0}',
				height: '{MAXIMAGESIZE.1}'
			},
			chunk_size: '{MAXFILESIZE}',
			max_retries: 3,
			rename: false,
			dragdrop: true,
			filters: {
				max_file_size: '{MAXFILESIZE}',
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
				FilesAdded: function (up, files) {},
				UploadComplete: function (up, files) {
					$(".plupload_button").css("display", "inline");
					$(".plupload_upload_status").css("display", "inline");
					$("html, body").animate({ scrollTop: $('#image-other').offset().top }, 1000);
				}
			}
		});
		var uploader = $("#uploader").pluploadQueue();
		uploader.bind('BeforeUpload', function(up) {
			 up.settings.multipart_params = {
					'folder': ''
			 };
		});
		var i = '{COUNT}';
		uploader.bind('FileUploaded', function(up, file, response) {

		var content = $.parseJSON(response.response).data;

		var item='';
			item+='<div class="panel panel-default new-images-append" id="other-image-div-' + i + '">';
			item+='<div class="panel-body">';
			item+='				<div class="col-xs-24 col-sm-4 col-md-4">';
			item+='					<input type="hidden" name="otherimage['+ i +'][id]" value="0">';
			item+='					<input type="hidden" name="otherimage['+ i +'][basename]" value="'+ content['basename'] +'">';
			item+='					<input type="hidden" name="otherimage['+ i +'][homeimgfile]" value="'+ content['homeimgfile'] +'">';
			item+='					<input type="hidden" name="otherimage['+ i +'][thumb]" value="'+ content['thumb'] +'">';
			item+='					<a href="#" onclick="modalShow(\'' + content['basename'] + '\', \'<img src=' + content['image_url'] + ' />\' ); return false;" >';
			item+='						<img class="img-thumbnail m-bottom" src="'+ content['thumb'] +'">';
			item+='					</a>';
			item+='					<p class="text-center"><i class="fa fa-trash-o fa-lg">&nbsp;</i><a href="" onclick="nv_delete_other_images_tmp(\'' + content['image_url'] + '\', \'' + content['thumb'] + '\', ' + i + '); return false;">{LANG.images_delete}</a></p>';
			item+='				</div>';
			item+='				<div class="col-xs-24 col-sm-20 col-md-20">';
			item+='					<div class="form-group">';
			item+='						<input type="text" name="otherimage['+ i +'][name]" value="' + content['basename'] + '" class="form-control" placeholder="{LANG.images_name}">';
			item+='					</div>';
			item+='					<div class="form-group">';
			item+='						<textarea name="otherimage['+ i +'][description]" class="form-control" placeholder="{LANG.images_description}"></textarea>';
			item+='					</div>';
			item+='				</div>';
			item+='</div>';
			item+='</div>';
			item+='</div>';

			$('#image-other').append(item);
			++i;
		});

		uploader.bind("UploadComplete", function () {
		    $('.btn-submit').show();
		    $('.info-image-number').hide();
		});

		uploader.bind('QueueChanged', function() {

		});

		$('#uploader').append('<em class="fa fa-close fa-lg fa-pointer close-upload" onclick="$(\'#uploader\').hide(); $(\'.images-add\').show(); return false;">&nbsp;</em>');
	});

	$('.images-add').click(function(){
	    $('#uploader').show();
	    $('.images-add').hide();
	});
</script>

<!-- END: main -->