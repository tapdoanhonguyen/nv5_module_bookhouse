<!-- BEGIN: main -->	
<link href="{NV_BASE_SITEURL}themes/default/css/lightslider.css" rel="stylesheet" />
<script src="{NV_BASE_SITEURL}themes/default/js/lightslider.js"></script>

<div class="detail_nhadat">
	<div class="info_nhadat">
		<div class="thongtin_nhadat">
			<span class="diadiem_nhadat"><i class="fa fa-map-marker" aria-hidden="true"></i>
			{DATA.location}</span>
			<span class="ngaydang_nhadat"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
			{DATA.ordertime}</span>
			<span class="matin_nhadat"><i class="fa fa-tag" aria-hidden="true"></i>
			{LANG.code}: {DATA.code}</span>
		<!--	<span class="matin_nhadat"><i class="fa fa-clock-o" aria-hidden="true"></i>
			Thời điểm: 230 phút trước</span> -->
			<span class="matin_nhadat"><i class="fa fa-eye" aria-hidden="true"></i>
			{LANG.viewcount}: {DATA.hitstotal}</span>
			
		</div>
		<div class="tieude_nhadat" style="color:{color}">{DATA.title}
		<!-- BEGIN: icon -->	
			<img src="{image_block}"/>
		<!-- END: icon -->	
		</div>
		<div class="image_nhadatdetail">
		
	<!-- BEGIN: image -->	
					 <ul id="image-gallery">
										<!-- BEGIN: loop -->
										 <li data-thumb="{IMAGE}"> 
										 <a href="" data-src="{IMAGE}" class="open_modal" title="{TITLE}">
										<img src="{IMAGE}" />
										</a>
										 </li>
										<!-- END: loop -->
															
					</ul>
					

	<!-- END: image -->		
		</div> 
		
		<div class="thongtin_lienquan">
			
			<div class="lienhe2">
				<span class="thongtinlh">{LANG.contact_info}:</span>
			
			<div class="gia_dang_dt">
				<span class="bold">{LANG.contact}:</span> {DATA.contact_fullname}
			</div>
			<div class="dt_dang_dt">
				<div class="left_sdt">
				<span class="xem_dt"><i class="fa fa-mobile" aria-hidden="true"></i> Nhấn để hiện số</span>
				<span class="bold dis_none" ><a href="tel:0933 085 077">{DATA.contact_phone}</a></span> 
				</div>
			</div>
			<div class="gia_dang_dt row">
				<div class="col-xs-24 col-sm-12 col-md-12">
				<span class="bold">{LANG.contact_email}:</span> {DATA.contact_email}
				</div>
				
			</div>
			
			</div>
			<div class="ngay_dang_dt">
				<span>{LANG.addtime}:</span> {DATA.addtime}
			</div>
			<div class="ghichu_dang_dt">
				{DATA.bodytext}
			</div>
			
			<div class="gia_dang_dt">
				<span class="bold">{LANG.price}:</span> <span class="maugia_ct">{DATA.price} {DATA.price_time}</span>
			</div>
			<div class="gia_dang_dt">
				<strong>{LANG.category}:</strong><a href="{DATA.cat_link}"
					title="{DATA.cat_title}"> {DATA.cat_title}</a>
			</div>
			<!-- BEGIN: duan -->
			<div class="gia_dang_dt">
				<strong>Dự án:</strong><a href="{DATA.cat_link}"
					title="{DATA.cat_title}"> <a href="{DATA.link_duan}" title="{DATA.ten_duan}">{DATA.ten_duan}</a>
			</div>
			<!-- END: duan -->
			<!-- BEGIN: way -->
			<div class="gia_dang_dt">
				<strong>{LANG.way}:</strong> {DATA.way}
			</div>
			<!-- END: way -->
			
			<!-- BEGIN: legal -->
			<div class="gia_dang_dt">
				<strong>{LANG.legal}:</strong> {DATA.legal}
			</div>
			<!-- END: legal -->
			<!-- BEGIN: front -->
			<div class="gia_dang_dt">
				<strong>{LANG.front}:</strong> {DATA.front} {LANG.met}
			</div>
			<!-- END: front -->			
			<!-- BEGIN: road -->
			<div class="gia_dang_dt">
				<strong>{LANG.road}:</strong> {DATA.road} {LANG.met}
			</div>
			<!-- END: road -->
			<!-- BEGIN: so_tang -->
			<div class="gia_dang_dt">
				<strong>{LANG.so_tang}:</strong> {DATA.so_tang}
			</div>
			<!-- END: so_tang -->
			<!-- BEGIN: so_phong -->
			<div class="gia_dang_dt">
				<strong>{LANG.so_phong}:</strong> {DATA.so_phong}
			</div>
			<!-- END: so_phong -->
			<!-- BEGIN: hometext -->
			<div class="gia_dang_dt">
				<strong>{LANG.items_hometext}:</strong> {DATA.hometext}
			</div>
			<!-- END: hometext -->
			<!-- BEGIN: address -->
			<div class="gia_dang_dt">
				<span class="bold">{LANG.address}:</span> {ADDRESS}
			</div>
			<!-- END: address -->
			
		
		</div>
		<div class="info-basic">
			<div class="title">
				{LANG.info_d}
			</div>
				<div class="content">
					<div class="row">	
						<!-- BEGIN: area -->
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.area}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{DATA.area} {LANG.m2}
									</div>
								</div>
							</div>
						</div>
						<!-- END: area -->
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.phongngu}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{DATA.phong_ngu}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
							
								<div class="col-md-16 col-xs-14 mrgl-15">
									{LANG.cd}
								</div>
								<div class="col-md-8 col-xs-10 mrgl-15">
									{LANG.capnhat}
								</div>
							
							</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.phongtam_a}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{DATA.phong_tam}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.cr}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{LANG.capnhat}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.thue_ban}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{DATA.price} <span style="text-transform: uppercase;">{DATA.money_unit} </span>/{DATA.price_time}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.noi_that}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{noi_that_daydu}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{LANG.tien_ich}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{tien_ich_daydu}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
		<div class="info-basic">
			<div class="title">
				{LANG.noi_that}
			</div>
			<div class="content">
				<div class="row">
					<!-- BEGIN: noi_that -->
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{noi_that.title}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{checked}
									</div>
								</div>
							</div>
						</div>
					<!-- END: noi_that -->
				</div>
			</div>
		</div>
		<div class="info-basic">
			<div class="title">
				{LANG.tien_ich}
			</div>
			<div class="content">
				<div class="row">
					<!-- BEGIN: tien_ich -->
						<div class="col-md-12">
							<div class="clearfix">
								<div class="border-bottom">
									<div class="col-md-16 col-xs-14 mrgl-15">
										{tien_ich.title}
									</div>
									<div class="col-md-8 col-xs-10 mrgl-15">
										{checked}
									</div>
								</div>
							</div>
						</div>
					<!-- END: tien_ich -->
				</div>
			</div>
		</div> 
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
		<!-- BEGIN: keywords -->
		<div class="well">
			<em class="fa fa-tags">&nbsp;</em><strong>{LANG.keywords}: </strong>
			<!-- BEGIN: loop -->
			<a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em
				class="label label-primary">{KEYWORD}</em></a>
			<!-- END: loop -->
		</div>
		<!-- END: keywords -->
		<div class="quang_cao_detail">
			[QUANG_CAO_DETAIL]
		</div>
		<!-- TIN RAO LIÊN QUAN -->
		<!-- BEGIN: other -->
		<div class="tin_cho_ban">
			<div class="content_tin">
				<div class="body_tin">
					{OTHER}
				</div>
				
			</div>
		</div>
		<!-- BEGIN: page -->
			<div class="text-center xemtatca_lq nut_dt_header2 ">
				<a href="{base_url}" title="Xem tất cả"> Xem tất cả</a>
			</div>
		<!-- END: page -->
		<!-- END: other -->
		<!-- TIN RAO LIÊN QUAN -->
		<div class="quang_cao_detail">
			[QUANG_CAO_DETAIL1]
		</div>
	</div>
</div>

	 <script>
	 
	 $('.xem_dt').click(function(){
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=detail&hits_phone={DATA.id}', function(res) {
					if(res == 1)
					{
						$('.xem_dt').hide();
						$('.left_sdt .dis_none').show();
					}
					
			});
		
	 
	 });
	 
	 $(window).on('load', function(){
	 
		$('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:5,
                slideMargin: 20,
                speed:500,
                auto:false,
                loop:true
                 
				});
	 
	 });
            
    </script>
	
<!-- END: main -->
