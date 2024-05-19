<x-app-layout>
    <x-slot name="header">
        <x-heading />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form class="m-form" method="POST" action="{{ route('user_role.update', $user_role->id) }}">
						@csrf
						@method('PUT')
						@include('customer._form_fields')
					</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
