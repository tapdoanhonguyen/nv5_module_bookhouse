<!-- BEGIN: main -->
<div class="row">
	<!-- BEGIN: loop -->
	<div class="col-sm-12 col-md-8">
		<div class="thumbnail text-center">
			<div class="image" style="height: {thumb_height">
				<a href="{DATA.link}" title="{DATA.title}"> <img
					src="{DATA.imghome}" alt="{DATA.title}"
					style="max-width: {thumb_width" class="img-thumbnail" />
				</a>
			</div>
			<div class="caption">
				<h3>
					<a href="{DATA.link}" title="{DATA.title}">{DATA.title1}</a>
				</h3>
				<p class="text-danger">
					<strong><!-- BEGIN: price -->{DATA.price}<!-- END: price --> <!-- BEGIN: contact -->{LANG.contact}<!-- END: contact --> </strong>
				</p>
			</div>
		</div>
	</div>
	<!-- END: loop -->
</div>

<div class="text-center">{PAGE}</div>

<script type="text/javascript">
	 $(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>
<!-- END: main -->