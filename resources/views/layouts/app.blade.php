<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
		
		
		<meta name="baseurl" content="{{ URL::to('/') }}" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="{!! asset('css/bootstrap5.min.css') !!}" rel="stylesheet" type="text/css" />
		<link href="{!! asset('css/style.css') !!}" rel="stylesheet" />
		<link rel="icon" type="image/x-icon" href="{!! asset('crm-icon.png') !!}" />
		
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
		<x-toast />
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
		<script src="{!! asset('js/jquery-3.5.1.js') !!}"></script>		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<script src="{!! asset('js/dataTables.min.js') !!}"></script>
		<script src="{!! asset('js/dataTables.bootstrap5.min.js') !!}"></script>
		<script src="{!! asset('js/custom.js') !!}"></script>
		@stack('custom-script')
		@php
			$temp = [];
		@endphp

		@if($errors->any())
			@php	
				foreach($errors->getMessages() as $k=>$v)
					$temp[$k] = implode("<br/>",$v);			
			@endphp
		@endif
		
		@if(Session::has('success'))
			<script>
				toastmsg("{{ Session::get('success') }}");
			</script>
		@endif

		@if(Session::has('error'))
			<script>
				toastmsg("{{ Session::get('error') }}",true);
			</script>
		@endif
		<script>
			$(document).ready(function() {
				var errors = $.parseJSON('{!! json_encode($temp) !!}');
				formValidation(errors);
				if($('.is_required').length) {
					$.each($('.is_required'), function(index, el) {
						$(this).closest('div').find('label').first().after('<span class="text-danger">*</span>')
					});
				}
			});
		</script>
    </body>
</html>
