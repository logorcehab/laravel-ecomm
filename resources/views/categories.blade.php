<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <!-- Brand Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
                    </div>
                    

                    <div class="flex items-center justify-end mt-4">

                        <x-button class="ml-3">
                            {{ __('Add Category') }}
                        </x-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Categories
                </div>
                @if (count($categories)!=0)
                    @foreach ($categories as $category)
                    <li class="p-6 bg-white border-b border-gray-200">
                        {{$category->name}}
                    </li>
                    @endforeach
                @else
                    <div class="p-6 bg-white border-b border-gray-200">
                        no Categories
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
