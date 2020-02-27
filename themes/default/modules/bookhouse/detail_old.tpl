<!-- BEGIN: main -->
<div id="detail">
	<h1>{DATA.title}</h1>
	<ul class="list-info list-inline text-muted">
		<li><label>{LANG.addtime}:</label> {DATA.addtime}</li>
		<li><label>{LANG.viewcount}:</label> {DATA.hitstotal}</li>
	</ul>
	<hr />
	<!-- BEGIN: image -->
	<!-- You can move inline styles to css file or css block. -->
	<div id="slider2_container"
		style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden;">

		<!-- Loading Screen -->
		<div u="loading" style="position: absolute; top: 0px; left: 0px;">
			<div
				style="filter: alpha(opacity = 70); opacity: 0.7; position: absolute; display: block; background-color: #000000; top: 0px; left: 0px; width: 100%; height: 100%;">
			</div>
			<div class="loading">&nbsp;</div>
		</div>

		<!-- Slides Container -->
		<div u="slides"
			style="cursor: move; position: absolute; left: 0px; top: 0px; width: 600px; height: 300px; overflow: hidden;">
			<!-- BEGIN: loop -->
			<div>
				<img u="image" src="{IMAGE}" /> <img u="thumb" src="{IMAGE}" />
			</div>
			<!-- END: loop -->
		</div>

		<!-- Arrow Left -->
		<span u="arrowleft" class="jssora02l"
			style="width: 55px; height: 55px; top: 123px; left: 8px;"> </span>
		<!-- Arrow Right -->
		<span u="arrowright" class="jssora02r"
			style="width: 55px; height: 55px; top: 123px; right: 8px"> </span>
		<!-- Arrow Navigator Skin End -->

		<!-- ThumbnailNavigator Skin Begin -->
		<div u="thumbnavigator" class="jssort03"
			style="position: absolute; width: 600px; height: 60px; left: 0px; bottom: 0px;">
			<div
				style="background-color: #000; filter: alpha(opacity = 30); opacity: .3; width: 100%; height: 100%;"></div>
			<div u="slides" style="cursor: move;">
				<div u="prototype" class="p"
					style="POSITION: absolute; WIDTH: 62px; HEIGHT: 32px; TOP: 0; LEFT: 0;">
					<div class=w>
						<ThumbnailTemplate
							style=" WIDTH: 100%; HEIGHT: 100%; border: none;position:absolute; TOP: 0; LEFT: 0;"></ThumbnailTemplate>
					</div>
					<div class=c
						style="POSITION: absolute; BACKGROUND-COLOR: #000; TOP: 0; LEFT: 0">
					</div>
				</div>
			</div>
			<!-- Thumbnail Item Skin End -->
		</div>
		<!-- ThumbnailNavigator Skin End -->
	</div>
	<!-- END: image -->

	<!-- BEGIN: adminlink -->
	<div class="text-center" style="margin-top: 15px">
		<em class="fa fa-edit">&nbsp;</em><a href="{EDIT_URL}"
			title="{GLANG.edit}">{GLANG.edit}</a> - <em class="fa fa-trash-o">&nbsp;</em><a
			href="{EDIT_URL}" title="{GLANG.delete}">{GLANG.delete}</a>
	</div>
	<!-- END: adminlink -->

	<div class="detail_bar">
		<span><strong>{LANG.detail_info}</strong></span>
	</div>

	<!-- BEGIN: code -->
	<p>
		<strong>{LANG.code}:</strong> {DATA.code}
	</p>
	<!-- END: code -->

	<p>
		<strong>{LANG.category}:</strong><a href="{DATA.cat_link}"
			title="{DATA.cat_title}"> {DATA.cat_title}</a>
	</p>

	<!-- BEGIN: address -->
	<p>
		<strong>{LANG.address}:</strong> {ADDRESS}
	</p>
	<!-- END: address -->

	<!-- BEGIN: area -->
	<p>
		<strong>{LANG.area}:</strong> {DATA.area} m<sup>2</sup>
	</p>
	<!-- END: area -->
	
	<!-- BEGIN: size -->
	<p>
		<strong>{LANG.size}:</strong> {DATA.size_h} x {DATA.size_v} {LANG.met}
	</p>
	<!-- END: size -->

	<!-- BEGIN: room -->
	<p>
		<strong>{LANG.room_num}: </strong>
		<!-- BEGIN: loop -->
		{ROOM.title} <span class="label label-danger">{ROOM.num}</span>
		<!-- END: loop -->
	</p>
	<!-- END: room -->

	<!-- BEGIN: project -->
	<p>
		<strong>{LANG.project}:</strong> {DATA.project}
	</p>
	<!-- END: project -->
	<!-- BEGIN: way -->
	<p>
		<strong>{LANG.way}:</strong> {DATA.way}
	</p>
	<!-- END: way -->
	<!-- BEGIN: legal -->
	<p>
		<strong>{LANG.legal}:</strong> {DATA.legal}
	</p>
	<!-- END: legal -->
	
	<!-- BEGIN: front -->
	<p>
		<strong>{LANG.front}:</strong> {DATA.front} {LANG.met}
	</p>
	<!-- END: front -->
	
	<!-- BEGIN: road -->
	<p>
		<strong>{LANG.road}:</strong> {DATA.road} {LANG.met}
	</p>
	<!-- END: road -->
	
	<!-- BEGIN: structure -->
	<p>
		<strong>{LANG.structure}:</strong> {DATA.structure}
	</p>
	<!-- END: structure -->
	
	<!-- BEGIN: type -->
	<p>
		<strong>{LANG.type}:</strong> {DATA.type}
	</p>
	<!-- END: type -->

	<p>
		<strong>{LANG.price}:</strong> {DATA.price}
	</p>

	<div class="panel panel-default socialbutton">
		<div class="panel-body">
			<ul class="pull-left" style="padding: 0" class="list-inline">
				<li class="pull-left"><div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div></li>
				<li class="pull-left"><div class="g-plusone" data-size="medium"></div></li>
				<li class="pull-left"><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></li>
			</ul>
			<!-- BEGIN: save -->
			<div class="pull-right" id="btn-save">
				<label id="save"{DATA.style_save}><em class="fa fa-floppy-o fa-lg text-success">&nbsp;</em><a href="javascript:void(0)" onclick="nv_save_rows({DATA.id}, 'add', {DATA.is_user}); return !1;" title="{LANG.save}">{LANG.item_save}</a></label> <label id="saved"{DATA.style_saved}><em class="fa fa-minus-circle fa-lg text-danger">&nbsp;</em><a href="javascript:void(0)" onclick="nv_save_rows({DATA.id}, 'remove', {DATA.is_user}); return !1;" title="{LANG.save_remove}">{LANG.item_save_remove}</a></label>
			</div>
			<!-- END: save -->
		</div>
	</div>

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#bodytext" aria-controls="bodytext" role="tab" data-toggle="tab">{LANG.detail}</a></li>
		<!-- BEGIN: google_maps_title -->
		<li role="presentation"><a href="#maps" aria-controls="maps" role="tab" data-toggle="tab">{LANG.maps}</a></li>
		<!-- END: google_maps_title -->
	</ul>
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="bodytext">{DATA.bodytext}</div>
		<!-- BEGIN: google_maps_div -->
		<div role="tabpanel" class="tab-pane" id="maps">
			<script>
			if (!$('#googleMapAPI').length) {
				var script = document.createElement('script');
				script.type = 'text/javascript';
				script.id = 'googleMapAPI';
				script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=initializeMap&key={MAPS.maps_appid}';
				document.body.appendChild(script);
			} else {
				initializeMap();
			}
		
			function initializeMap() {
				var ele = 'company-map';
				var map, marker, ca, cf, a, f, z;
				ca = parseFloat($('#' + ele).data('clat'));
				cf = parseFloat($('#' + ele).data('clng'));
				a = parseFloat($('#' + ele).data('lat'));
				f = parseFloat($('#' + ele).data('lng'));
				z = parseInt($('#' + ele).data('zoom'));
				map = new google.maps.Map(document.getElementById(ele), {
					zoom: z,
					center: {
						lat: ca,
						lng: cf
					}
				});
				marker = new google.maps.Marker({
					map: map,
					position: new google.maps.LatLng(a, f),
					draggable: false,
					animation: google.maps.Animation.DROP
				});
			}
			</script>
		
			<div class="m-bottom" id="company-map" style="width: 100%; height: 300px"
				data-clat="{MAPS.maps_mapcenterlat}"
				data-clng="{MAPS.maps_mapcenterlng}" data-lat="{MAPS.maps_maplat}"
				data-lng="{MAPS.maps_maplng}" data-zoom="{MAPS.maps_mapzoom}"></div>
		</div>
		<!-- END: google_maps_div -->
	</div>
	<!-- BEGIN: contact_info -->
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.contact_info}</div>
		<div class="panel-body">
			<ul class="list-contact-info">
				<li><label><em class="fa fa-user">&nbsp;</em>{LANG.contact_fullname}:</label> {DATA.contact_fullname}</li>
				<li><label><em class="fa fa-envelope-o">&nbsp;</em>Email:</label> <a href="mailto:{DATA.contact_email}">{DATA.contact_email}</a></li>
				<li><label><em class="fa fa-phone">&nbsp;</em>{LANG.contact_phone}:</label> {DATA.contact_phone}</li>
				<li><label><em class="fa fa-map-pin">&nbsp;</em>{LANG.contact_address}:</label> {DATA.contact_address}</li>
			</ul>
		</div>
	</div>
	<!-- END: contact_info -->
	
	<!-- BEGIN: keywords -->
	<div class="well">
		<em class="fa fa-tags">&nbsp;</em><strong>{LANG.keywords}: </strong>
		<!-- BEGIN: loop -->
		<a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em
			class="label label-primary">{KEYWORD}</em></a>
		<!-- END: loop -->
	</div>
	<!-- END: keywords -->

	<!-- BEGIN: comment -->
	{COMMENT}
	<!-- END: comment -->

	<!-- BEGIN: other -->
	<div class="detail_bar">
		<span><strong>{LANG.other}</strong></span>
	</div>
	{OTHER}
	<!-- END: other -->
</div>

<script type="text/javascript">
var LANG = [];
LANG.error_save_login = '{LANG.error_save_login}';

$(document).ready(function(e) {
	$('#rent_info').hide();

    $("#form-rent").submit(function() {
    	var form_data = $("#form-rent").serialize();
    	$('#waiting').html( '<p class="text-center"><em class="fa fa-spinner fa-spin fa-4x">&nbsp;</em><br />{LANG.waiting}</p>' );
    	$('#rent_info').hide();
    	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=rent&nocache=' + new Date().getTime(), form_data, function(res) {
    		var r_split = res.split('_');
    		if( r_split[0] == 'OK' )
    		{
    			$('#waiting').html('');
    			$('#rent_info').show();
    			$('#rent_info').html( '<div class="alert alert-info text-center">{LANG.rent_success}</div>' );
    		}
    		else
    		{
    			alert( r_split[1] );
    			$('#rent_info').show();
    			$('#waiting').html('');
    			nv_change_captcha('vimg','fcode_iavim');
    		}
    	});
        return false;
    });

    $('#rent_button').click(function() {
        $('#rent_info').slideDown();
        $('#rent_button').hide();
        $('html, body').animate({
            scrollTop: $('#rent_info').offset().top + 'px'
        }, {
            duration: 500,
            easing: 'swing'
        });
        return false;
    });

    $('.btn-close').click(function() {
        $('#rent_button').show();
        $('#rent_info').slideUp();
    });
});
 </script>
<!-- END: main -->