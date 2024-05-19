@php
		$request_data = Request()->request->all();
		$columns = $request_data['datatables_columns'];
		// $db_filters = isset($request_data['db-filter']) ? $request_data['db-filter'] : [];
		$dataTableId = rand(1111, 9999);
		$actionUrl = $request_data['actionUrl'] ?? route(\Request::route()->getName());
@endphp
<table class="table table-bordered table-hover table-checkable" id="data-table-{{$dataTableId}}">
	<thead>
		<tr>
			@foreach($columns as $key => $value)
				<th>{{ __($key) }}</th>
			@endforeach
		</tr>
		@if($columns)
			<tr class="filter">
				@foreach($columns as $d_key => $d_value)
					@if(isset($d_value['searchable'])) <th></th> @continue @endif

					@php
						$type = isset($d_value['type']) && $d_value['type'] == 'datepicker' ? 'date' : 'text';
						$input = '<input type="'.$type.'" class="form-control form-control-sm m-input">';

						if(isset($d_value['type']) && $d_value['type'] == 'select') {
							$option = '<option value="">'._("Select option").'</option>';
							if(isset($d_value['option_data']) && $d_value['option_data']){
								foreach($d_value['option_data'] as $v_key => $v_value) {
									$option .= "<option value=".$v_key.">".$v_value."</option>";
								}
							}
							$input = '<select class="form-control form-control-sm m-input">'.$option.'</select>';
						}
					@endphp
					<th>@php echo $input; @endphp</th>
				@endforeach
			</tr>
		@endif
	</thead>
	<tbody>
	</tbody>
</table>
@push('custom-script')
	<script type="text/javascript">
		var table = $('#data-table-{{$dataTableId}}').DataTable({
			processing: true,
			serverSide: true,
			sDom :"ltipr", // 'f' - Filtering input
			orderCellsTop: true,
			autoWidth: false,
			order: [],
			responsive: true,
			ajax: {
				url:"{{ $actionUrl }}",
			},
			initComplete: function () {
				initDatatableFilter($('#data-table-{{$dataTableId}}'));
				$('#data-table-{{$dataTableId}} thead th:last').css('min-width','80px');
			},
			columns: {!! json_encode(array_values($columns)) !!},
			search: {
				"regex": false
			  }
		});

		function initDatatableFilter(_thisDatatable) {
			if (_thisDatatable.find('.filter th').length) {
				_thisDatatable.find('.filter th').each(function(i) {
					if (!$(this).find('input, select').length) { return; }
					if ($(this).find('input').length && !$(this).find('input').attr('placeholder')) {
						$(this).find('input').attr('placeholder', "Search " + (_thisDatatable.find('thead > tr th').eq($(this).index()).text()).toLowerCase());
					}
					if ($(this).find('select').length) {
						$('select', this).on('change click', function (event) {
							if (event.type == 'click') { event.stopPropagation(); return true; }
							_thisDatatable.DataTable().column(i).search((this.value ? this.value : ''), true, false).draw();
						});

					} else {
						$('input', this).not("[type='checkbox']").on('keyup change click', function (event) {
							if (event.type == 'click') { event.stopPropagation(); return true; }
							_thisDatatable.DataTable().column(i).search(this.value).draw();
						});
					}
				});
			}
		}
	</script>
@endpush