<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($product->name) }}
        </h2>
    </x-slot>

    <div class="super_container">
    
    <div class="single_product">
        <div class="container-fluid" style=" background-color: #fff; padding: 11px;">
            <div class="row">
                <div class="col-lg-2 order-lg-1 order-2" style="max-height: 100%; overflow-y: scroll;">
                    <ul class="image_list">
                        @foreach ($product->images as $image)
                        <li data-image="{{asset(Storage::url($image->filename))}}" id="image.{{$image->id}}">
                            <img 
                                src="{{asset(Storage::url($image->filename))}}" alt="" 
                                role="button"
                                onclick="changeTo('{{asset(Storage::url($image->filename))}}')">
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4 order-lg-2 order-1">
                    <div class="image_selected">
                        <img id="changeMe" 
                            src="{{asset(Storage::url($product->images[0]->filename))}}"
                            style="
                                width:100%;
                                height:auto"
                            alt=""></div>
                </div>
                <div class="col-lg-6 order-3">
                    <div class="product_description">
                        <div class="product_name">{{$product->name}}</div>
                        <div class="product_name">{{$product->brands->name}}</div>
                        <div> <span class="product_price">GH₵ {{$product->price}}</span></div>
                        <hr class="singleline">
                            <div class="product_description">{{$product->description}}</div>
                        <hr class="singleline">
                        <div class="order_info d-flex flex-row">
                            <form action="#">
                        </div>
                        <div class="row">
                            <div class="col-xs-6" style="margin-left: 13px;">
                                <div class="product_quantity">
                                    <span>Quantity: {{$product->quantity}}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <a href="{{ route('products.edit', $product->id)}}" 
                                    class="btn btn-success rounded-0" type="button" 
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    Edit
                                </a>
                                <form method="post" action="{{ route('products.delete', $product->id) }}"> 
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger rounded-0" 
                                        type="submit" data-toggle="tooltip" data-placement="top" title="Delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            </div>
        </div>
    </div>
</div>
   <script type="text/javascript">
                    document.body.style.backgroudImage = "url('http://127.0.0.1:8000/storage/photos/v2nzHoXHam38yS6TE0EPpaQqVyoegj6ngQw3Nm4c.jpg')"

        function changeTo(url){
            const changeMe = document.getElementById('changeMe')
        }
   </script>
</x-app-layout>
