<!-- BEGIN: main -->
<div class="block_raovatmoi block_detail_bds">
		<!-- BEGIN: newloop -->
					<div class="item_blocktin {none_boder} {none}">
						<div>
						<div class="col-sm-8 col-md-9 image_raovatmoi">
							<a href="{blocknew_items.link}" title="{blocknew_items.title}"><img src="{blocknew_items.imghome}"/></a>
						</div>
						<div class="col-sm-16 col-md-15 right_raovatmoi">
							<div class="tieude_rvm">
							<a style="color:{blocknew_items.color}" href="{blocknew_items.link}" title="{blocknew_items.title}">{blocknew_items.title}</a><!-- BEGIN: image -->	
							<img src="{image_block}"/>
							<!-- END: image -->	</div>
						<div class="gia_rvm">
						<span class="bold">{LANG.price}: </span>
						<!-- BEGIN: price -->
							{blocknew_items.price}
						<!-- END: price -->
						<!-- BEGIN: contact -->
							{LANG.contact}
						<!-- END: contact --> 
						</div>
						<div class="sdt_rvm"><span class="bold">Điện thoại:</span><a href="tel:{blocknew_items.contact_phone}"> {blocknew_items.contact_phone}</a></div>
						</div>
						</div>
					</div>
		<!-- END: newloop -->			
				</div>
	
	<script>
		$(document).ready(function(){
			$('.xemtatca').click(function(){
				$('.block_detail_bds .none').css("display","inline-block");
			});
		});
	</script>
<!-- END: main -->