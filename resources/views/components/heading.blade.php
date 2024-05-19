<div class="row">
	<div class="col-md-6">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{Request()->request->get('pageTitle')}}
		</h2>
	</div>
	<div class="col-md-6 text-end">
		<a href="{{Request()->request->get('redirectURL')}}" class="btn btn-{{Request()->request->get('pageBtnClass')}}">{{Request()->request->get('pageBtnText')}}</a>
	</div>
</div>