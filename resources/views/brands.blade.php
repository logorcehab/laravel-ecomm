<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Brands') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('brands.store') }}">
                    @csrf

                    <!-- Brand Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
                    </div>
                    

                    <div class="flex items-center justify-end mt-4">

                        <x-button class="ml-3">
                            {{ __('Add Brand') }}
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
                    Brands
                </div>
                @if (count($brands)!=0)
                    @foreach ($brands as $brand)
                    <li class="p-6 bg-white border-b border-gray-200">
                        {{$brand->name}}
                    </li>
                    @endforeach
                @else
                    <div class="p-6 bg-white border-b border-gray-200">
                        No Brands
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
