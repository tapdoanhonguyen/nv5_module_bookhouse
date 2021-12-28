<!-- BEGIN: main -->
<div class="viewhome">
	<!-- BEGIN: viewall -->
	<div class="viewall">
		{DATA}
		<!-- BEGIN: page -->
		<div class="text-center">{PAGE}</div>
		<!-- END: page -->
	</div>
	<!-- END: viewall -->

	<!-- BEGIN: viewcat -->
	<div class="viewcat">
		<!-- BEGIN: loop -->
		<div class="panel panel-default">
			<div class="panel-heading">{CAT.title}</div>
			<div class="panel-body">{DATA}</div>
		</div>
		<!-- END: loop -->
	</div>
	<!-- END: viewcat -->
</div>
<!-- END: main -->