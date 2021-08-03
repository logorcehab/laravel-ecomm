<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('products.store') }}">
                    @csrf

                    <!-- Product Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
                    </div>
                    <div>
                        <x-label for="description" :value="__('Description')" />

                        <textarea id="description" class="block mt-1 w-full" type="text" rows="4" name="description" :value="old('description')" autofocus></textarea>
                    </div>
                    <div>
                        <x-label for="price" :value="__('Price')" />

                        <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" autofocus />
                    </div>
                    <div>
                        <x-label for="quantity" :value="__('Quantity')" />

                        <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" autofocus />
                    </div>
                    <div id="brand_wrapper">
                        <x-label for="brand" :value="__('Brand')" />
                        <select data-style="block mt-1 w-full" name="brand" id="brand" class="form-control w-100">
                            <option disabled selected value> -- select an option -- </option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->name}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="category_wrapper">
                        <x-label for="categories" :value="__('Category')" />
                        <select multiple="" data-style="block mt-1 w-full" name="categories[]" class="form-control selectpicker w-100">
                            @foreach ($categories as $category)
                                <option value="{{$category->name}}">{{$category->name}}</option>
                            @endforeach
                        </select>                    
                    </div>
                    <div>
                        <x-label for="photos" :value="__('Photos')" />

                        <input required id="photos" class="block mt-1 w-full" multiple="multiple" name="photos[]" type="file" class="form-control">
                    </div>
                    @if (count($errors) > 0)
                        <ul><li>{{ $error }}</li></ul>
                    @endif
                    <div class="flex items-center justify-end mt-4">

                        <x-button type="submit" class="ml-3">
                            {{ __('Add Product') }}
                        </x-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
