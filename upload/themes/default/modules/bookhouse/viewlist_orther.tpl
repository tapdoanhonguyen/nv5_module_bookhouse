<!-- BEGIN: main -->
<div class="content_block_tin tinlienqua_detail">
<div class="title_qltine">{TITLE}</div>
			<!-- BEGIN: loop -->		
						<div class="item_blocktin {none_boder}">
						<div class="tieude_blocktin_mobile"><a style="color:{DATA.color}" title="{DATA.title}" href="{DATA.link}">{DATA.title}</a>
								<!-- BEGIN: image_mobile -->	
								<img src="{image_block}"/>
								<!-- END: image_mobile -->	
								<span class="date_order_mobile">
								({DATA.ordertime})
								</span>
							</div>
						<div class="{none}">
							<div class="image_blocktin col-xs-8 col-sm-6 col-md-5">
								<a title="{DATA.title}" href="{DATA.link}">
									<img src="{DATA.imghome}" alt="{DATA.title}"/>
								</a>
							</div>
							<div class="nd_blocktin col-xs-16 col-sm-18 col-md-19">
								<div class="tieude_blocktin"><a style="color:{DATA.color}" title="{DATA.title}" href="{DATA.link}">{DATA.title}</a>
								<!-- BEGIN: image -->	
								<img src="{image_block}"/>
								<!-- END: image -->	
								</div>
								<div class="gia_blocktin"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/nha-dat/icon-gia.png"/>
						<!-- BEGIN: price -->
							{LANG.price}:<span class="gia_tinrao"> {DATA.price}</span><span>
								 </span></span>
						<!-- END: price -->
						<!-- BEGIN: contact -->
							{LANG.contact}
						<!-- END: contact --> 
 </div>
								<div class="dt_blocktin"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/nha-dat/icon-dien-tich.png"/>
 {LANG.area}: 			
						{DATA.area} m<sup>2</sup>
						</div>
								<div class="row content_vt_tg">
									<div class="vitri_blocktin col-sm-14 col-md-14"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/nha-dat/icon-dia-chi.png"/>
 {LANG.items_location}: {DATA.location}</div>
									<div class="col-sm-10 col-md-10 ngay_cap_nhat">Ngày cập nhật: {DATA.ordertime}</div>
								</div>
							</div>
						</div>
						</div>
	<!-- END: loop -->
		
</div>
<!-- END: main -->
