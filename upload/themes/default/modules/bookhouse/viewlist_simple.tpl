<!-- BEGIN: main -->

<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>{LANG.code}</th>
			<th>{LANG.addtime}</th>
			<th>{LANG.district}</th>
			<th>{LANG.address}</th>
			<!-- BEGIN: area -->
			<th>{LANG.area} (m<sup>2</sup>)</th>
			<!-- END: area -->
			<!-- BEGIN: size -->
			<th>{LANG.size} (m)</th>
			<!-- END: size -->
			<th>{LANG.structure}</th>
			<th>{LANG.way}</th>
			<th>{LANG.price}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<!-- BEGIN: loop -->
		<tr>
			<td>{DATA.code}</td>
			<td>{DATA.addtime}</td>
			<td>{DATA.district}</td>
			<td>{DATA.address}</td>
			<!-- BEGIN: area -->
			<td>{DATA.area}</td>
			<!-- END: area -->
			<!-- BEGIN: size -->
			<td>
				<!-- BEGIN: content -->
				{DATA.size_h} x {DATA.size_v}
				<!-- END: content -->
			</td>
			<!-- END: size -->
			<td>{DATA.structure}</td>
			<td>{DATA.way}</td>
			<td>
				<!-- BEGIN: price -->
				{DATA.price}
				<!-- END: price -->
				<!-- BEGIN: contact -->
				{LANG.contact}
				<!-- END: contact -->
			</td>
			<td class="text-center">
				<!-- BEGIN: view_on_main_link -->
				<a href="#" title="" onclick="nv_view_on_main({DATA.id}); return !1;">{LANG.detail}</a>
				<!-- END: view_on_main_link -->
				
				<!-- BEGIN: link -->
				<a href="{DATA.link}" title="">{LANG.detail}</a>
				<!-- END: link -->
			</td>
		</tr>
		<!-- BEGIN: view_on_main_content -->
		<tr style="display: none" class="main_content" id="main_content_{DATA.id}">
			<td colspan="9">
				<div style="height: 250px; overflow: scroll;">{DATA.bodytext}</div>
			</td>
		</tr>
		<!-- END: view_on_main_content -->
		<!-- END: loop -->
	</tbody>
</table>

<!-- BEGIN: page -->
<div class="text-center">{PAGE}</div>
<!-- END: page -->

<!-- END: main -->