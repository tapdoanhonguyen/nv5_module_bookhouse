<!-- BEGIN: main -->
<div class="content_tin">
	<div class="tieude_tin tieude_tin_moigioi_lancan">
		Các nhà môi giới khu vực {thongtin_quan.title}
	</div>
	<div class="body_tin">
	<div class="content_block_tin padding_top10">
		
		<ul class="block_danhba">
			<!-- BEGIN: newloop -->
						<li>
							<div class="row">
								<div class="col-sm-10 col-md-10">
									<div class="image_danhba_block"><a href="{item.link}" title="{item.company}"><img src="{item.logo}"/></a></div>
								</div>
								<div class="col-sm-14 col-md-14">
									<div class="title_danhba_block"><a href="{item.link}" title="{item.company}">{item.company}</a></div>
									<div class="thongtinkhac_danhba"><span>Điện thoại:</span>{item.phone}</div>
									<div class="thongtinkhac_danhba thongtinkhac_danhba_email"><span>Email:</span>{item.email}</div>
									<div class="thongtinkhac_danhba"><span>Điạ chỉ:</span>{quanhuyen},{tinhthanh}</div>
								</div>
							</div>
						</li>
			<!-- END: newloop -->			
		</ul>
		<div class="xemtatca_moigioi"><a href="{xemtatca}" title="Xem tất cả">Xem tất cả</a></div>
				

	</div>
	</div>
</div>
<!-- END: main -->