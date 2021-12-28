<!-- BEGIN: main -->
<div class="content_block_tin">
<!--
<div class="title_qltine">
	<div class="col-md-12">
	<i class="fa fa-file-text-o" aria-hidden="true"></i> Tin vip
	</div>
	<div class="col-md-12 text-right muon_qc">
		<a href="{NV_BASE_SITEURL}quang-cao/Nang-cap-tin.html">Bạn muốn quảng cáo tại đây</a>
	</div>
</div> -->
<div class="bds_vip_search">
 <link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/style11.css">
 <script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.flexisel.js"></script>

<div class="slider_chuan">
<ul id="flexiselDemo31">
 <!-- BEGIN: loop_vip1 -->
    <li>
	<div class="item_vip">
		<div class="item_vip_con">
		 <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.imghome}" alt="" /></a> 
		 <div class="content_pt">
			 <div class="title_vip">
				 <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a> 
			</div>
			<div class="price_vip">
				<!-- BEGIN: price -->{DATA.price} {DATA.price_time}<!-- END: price -->
				<!-- BEGIN: contact -->{LANG.contact}<!-- END: contact --> 
			</div>
		</div>
		</div>
	</div>
	</li>   
<!-- END: loop_vip1 -->	
</ul>  
</div>
<script>
   $("#flexiselDemo31").flexisel({
        visibleItems: 5,
        animationSpeed: 1000,
        autoPlay: false,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 2
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 3
            },
            tablet: { 
                changePoint:768,
                visibleItems: 4
            }
        }
    });
</script>

</div>
</div>


<div class="quang_cao_hot">[QC_SEARCH_HOT]</div>


<!-- BEGIN: qc211 -->	
<div class="quang_cao_hot">[QC_SEARCH_VIP]</div>
<!-- END: qc211 -->	

<div class="content_block_tin_search">

			<!-- BEGIN: loop -->		
						<div class="item_blocktin row">
							<div class="tieude_blocktin_mobile"><a style="color:{DATA.color}" title="{DATA.title}" href="{DATA.link}">{DATA.title}</a>
								<!-- BEGIN: image_mobile -->	
								<img src="{image_block}"/>
								<!-- END: image_mobile -->	
								<span class="date_order_mobile">
								({DATA.ordertime})
								</span>
							</div>
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
								 <!-- BEGIN: price -->{LANG.price}: <span class="gia_tinrao">{DATA.price} {DATA.price_time}<span><!-- END: price -->
								 <!-- BEGIN: contact -->{LANG.price}: <span class="gia_tinrao">{LANG.contact}</span><!-- END: contact --> 
								 </div>
								<div class="dt_blocktin"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/nha-dat/icon-dien-tich.png"/>
 {LANG.area}: 			
						{DATA.area} m<sup>2</sup>
						</div>
								<div class="row content_vt_tg">
									<div class="vitri_blocktin col-sm-14 col-md-18"><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/nha-dat/icon-dia-chi.png"/>
 {LANG.items_location}: {DATA.location}</div>
									<div class="col-sm-10 col-md-6 ngay_cap_nhat">{DATA.ordertime}</div>
								</div>
							</div>
						</div>
	<!-- END: loop -->
		
</div>
<!-- END: main -->
