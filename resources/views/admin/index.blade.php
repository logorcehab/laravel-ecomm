<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <div class="row py-5">
      <div class="col-lg-10 mx-auto">
        <div class="card rounded shadow border-0">
          <div 
            class="pt-3 pb-1 col-md-6 col-sm- ml-auto">
            <button type="button" class="btn btn-secondary ml-4"
              data-toggle="modal"
              data-target="#addProductsModal" 
              data-whatever="">
              <i class="fa fa-plus">&nbsp;Add Product</i>
            </button>
            <button type="button" class="btn btn-secondary ml-4"
              data-toggle="modal"
              data-target="#addCategoriesModal" 
              data-whatever="">
              <i class="fa fa-plus">&nbsp;Add Category</i>
            </button>
            <button type="button" class="btn btn-secondary ml-4"
              data-toggle="modal"
              data-target="#addBrandsModal" 
              data-whatever="">
              <i class="fa fa-plus">&nbsp;Add Brand</i>
            </button>
          </div>
          <div class="card-body pl-4 pb-4 pr-4 bg-white rounded">
            <div class="table-responsive">
              <table id="example" style="width:100%" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Images</th>
                    <th>Name</th>
                    <th>Categories</th>
                    <th>Brand</th>
                    <th>Price GH₵</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (json_decode($products) as $product)
                  <tr>
                      <td>
                      <div id="product.{{$product->id}}.Indicator" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                              <div class="carousel-item active">
                                <a href="{{ route('products.show',$product->id) }}">
                                  <img class="d-block" src="{{$product->images[0]}}" alt="">
                                </a>
                              </div>
                              @if (count($product->images)>1)
                                @foreach (range(1,(count($product->images)-1)) as $count)
                                <div class="carousel-item">
                                    <img class="d-block" src="{{$product->images[$count]}}" alt="">
                                </div>
                                @endforeach
                              @endif
                          </div>
                      </div>
                      </td>
                      <td>
                        <a 
                          href="#"
                          data-toggle="modal" data-target="#viewProductModal" 
                          data-product_name="{{$product->name}}"
                          data-product_price="{{$product->price}}"
                          data-product_description="{{$product->description}}"
                          data-product_quantity="{{$product->quantity}}"
                          data-product_brand="{{json_encode($product->brands)}}"
                          data-product_images="{{json_encode($product->images)}}"
                          data-product_categories="{{json_encode($product->categories)}}">
                          <span>{{$product->name}}</span>
                        </a>
                      </td>
                      <td>
                        @foreach ($product->categories as $category)
                        <span>{{$category->name}},&nbsp;</span>
                        @endforeach
                      </td>
                      <td>
                        <span>{{$product->brands->name}}</span>
                      </td>
                      <td>{{$product->price}}</td>
                      <td>{{$product->quantity}}</td>
                      <td>
                          <!-- Call to action buttons -->
                          <ul class="list-inline m-0 btn-group">
                              <li class="list-inline-item">
                                  <button 
                                    class="btn btn-primary btn-sm rounded-0"
                                    type="button" 
                                    data-toggle="modal" data-target="#viewProductModal" 
                                    data-product_name="{{$product->name}}"
                                    data-product_price="{{$product->price}}"
                                    data-product_description="{{$product->description}}"
                                    data-product_quantity="{{$product->quantity}}"
                                    data-product_brand="{{json_encode($product->brands)}}"
                                    data-product_images="{{json_encode($product->images)}}"
                                    data-product_categories="{{json_encode($product->categories)}}"
                                    >
                                    <i class="fa fa-eye"></i>
                                  </button>
                              </li>
                              <li class="list-inline-item">
                                <button 
                                  type="button" class="btn btn-success btn-sm rounded-0" 
                                  data-toggle="modal" data-target="#editProductModal" 
                                  data-product_name="{{$product->name}}"
                                  data-product_action="{{ route('products.update', $product->id) }}"
                                  data-product_price="{{$product->price}}"
                                  data-product_description="{{$product->description}}"
                                  data-product_quantity="{{$product->quantity}}"
                                  data-product_brands="{{json_encode($product->brands)}}"
                                  data-brands="{{json_encode($brands)}}"
                                  data-categories="{{json_encode($categories)}}"
                                  data-product_categories="{{json_encode($product->categories)}}"
                                >
                                  <i class="fa fa-edit"></i>
                                </button>
                              </li>
                              <li class="list-inline-item">
                                <button 
                                  type="button" class="btn btn-danger btn-sm rounded-0" 
                                  data-toggle="modal" data-target="#deleteProductModal" 
                                  data-product_name="{{$product->name}}"
                                  data-product_route="{{ route('products.delete', $product->id) }}"
                                >
                                  <i class="fa fa-trash"></i>
                                </button>
                              </li>
                          </ul>
                      </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- Modals -->
  <div class="modal fade" id="addProductsModal" tabindex="-1" role="dialog" aria-labelledby="addProductsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductsModalLongTitle">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('products.store') }}">
                @csrf
                <!-- Product Name -->
                <div class="row p-2">
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="product_name" class="block  w-full" type="name" name="name" :value="old('name')" required/>
                </div>
                <div class="row p-2">
                    <x-label for="description" :value="__('Description')" />
                    <textarea id="description" class="block  w-full" type="text" rows="4" name="description" :value="old('description')"></textarea>
                </div>
                <div class="row">
                  <div class="col-md-3">
                      <x-label for="price" :value="__('Price')" />
                      <x-input id="price" class="block  w-full" type="number" name="price" :value="old('price')"/>
                  </div>
                  <div class="col-md-3">
                      <x-label for="quantity" :value="__('Quantity')" />
                      <x-input id="quantity" class="block  w-full" type="number" name="quantity" :value="old('quantity')"/>
                  </div>
                </div>
                <div id="brand_wrapper" class="row p-2">
                    <x-label for="brand" :value="__('Brand')" />
                    <select data-style="block  w-full" name="brand" id="brand" class="form-control w-100">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach ($brands as $brand)
                            <option value="{{$brand->name}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="category_wrapper" class="row p-2">
                    <x-label for="categories" :value="__('Category')" />
                    <select multiple="" data-style="block mt-1 w-full" name="categories[]" class="form-control selectpicker w-100">
                        @foreach ($categories as $category)
                            <option value="{{$category->name}}">{{$category->name}}</option>
                        @endforeach
                    </select>                    
                </div>
                <div class="row p-2">
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
  </div>
  <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteProductModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="delete_form" method="post" action="">
            <p id="delete_product_name"></p>
            <p>Are you sure you want to delete this Product?</p>
            @csrf
            @method('DELETE')
            <button 
              class="btn btn-danger" 
              type="submit"
            >
            Delete
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProductModalLongTitle">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" class="form-horizontal" id="edit_form" enctype="multipart/form-data" action="">
              @csrf
              <!-- Product Name -->
              <div>
                  <x-label for="edit_name" :value="__('Name')" />
                  <x-input id="edit_name" class="block mt-1 w-full" type="name" placeholder="" name="name" :value="old('name')"  autofocus />
              </div>
              <div>
                  <x-label for="edit_description" :value="__('Description')" />
                  <textarea id="edit_description" class="block mt-1 w-full" type="text" rows="4" name="description" :value="old('description')" placeholder="" autofocus></textarea>
              </div>
              <div>
                  <x-label for="edit_price" :value="__('Price')" />
                  <x-input id="edit_price" class="block mt-1 w-full" type="number" placeholder="" name="price" :value="old('price')" autofocus />
              </div>
              <div>
                  <x-label for="edit_quantity" :value="__('Quantity')" />
                  <x-input id="edit_quantity" class="block mt-1 w-full" placeholder="" type="number" name="quantity" :value="old('quantity')" autofocus />
              </div>
              <div id="brand_wrapper">
                <x-label for="edit_brand" :value="__('Brand')" />
                <select data-style="block mt-1 w-full" name="brand" id="edit_brands" class="form-control w-100">
                  
                </select>
              </div>
              <div id="edit_category_wrapper">
                <x-label for='categories' :value="__('Category')" />
                <select data-style='block mt-1 w-full' id='mltislct' name='categories[]' class='form-control w-100' multiple></select>
              </div>
              <div>
                  <x-label for="edit_photos" :value="__('Photos')" />
                  <input  id="edit_photos" class="block mt-1 w-full" multiple="multiple" name="photos[]" type="file" class="form-control">
              </div>
              @if (count($errors) > 0)
                  <ul><li>{{ $error }}</li></ul>
              @endif
              <div class="flex items-center justify-end mt-4">
                  <x-button type="submit" class="ml-3">
                      {{ __('Edit Product') }}
                  </x-button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="addCategoriesModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoriesModalLongTitle">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <!-- Brand Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="category_name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
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
  </div>
  <div class="modal fade" id="addBrandsModal" tabindex="-1" role="dialog" aria-labelledby="addBrandsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBrandsModalLongTitle">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form method="POST" action="{{ route('brands.store') }}">
                    @csrf

                    <!-- Brand Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="brand_name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
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
  </div>
  <div class="modal fade" 
    id="viewProductModal" tabindex="-1" role="dialog" 
    aria-labelledby="viewProductModalTitle" aria-hidden="true"
    style="
      height:100%;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewProductModalLongTitle">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="single_product">
            <div class="container-fluid" style=" background-color: #fff; padding: 11px;">
              <div class="row">
                <div class="col-md-3 order-md-1 order-2" style="max-height: 40vh; overflow-y: scroll;">
                  <ul id="image_list" class="image_list">
                    
                  </ul>
                </div>
                <div class="col-md-5 order-md-2 order-1">
                  <div id="image_selected">
                    <img id="changeMe" 
                      src=""
                      style="
                          width:100%;
                          height:auto"
                      alt=""></div>
                </div>
                <div class="col-md-4 order-3">
                  <div class="product_description">
                    <div id="show_product_name"></div>
                    <div id="show_product_brand"></div>
                    <div id="show_product_categories"></div>
                    <div>GH₵<span id="show_product_price"></span></div>
                    <hr class="singleline">
                      <div id="show_product_description"></div>
                    <hr class="singleline">
                    <div class="row">
                      <div class="col-xs-6" style="margin-left: 13px;">
                        <div>
                          <span>Quantity: </span>
                          <span id="show_product_quantity"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="btn-group"
                        style="
                          margin-left: 15px;
                          margin-top: 5px;">
                        <a href="" 
                          class="btn btn-success rounded-0" type="button" 
                          data-toggle="tooltip" data-placement="top" title="Edit">
                          Edit
                        </a>
                        <form method="post" action=""> 
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
    </div>
  </div>
</div>
<script>
  $('#deleteProductModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var productName = button.data('product_name')
    var productRoute = button.data('product_route')
    var modal = $(this)

    modal.find('#delete_form').attr('action', productRoute)
    modal.find('#delete_product_name').text(productName)
    console.log(modal.attr('action'))
  });
  $('#editProductModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 


    var productCategories = button.data('product_categories')
    var productBrand = button.data('product_brands')
    var brands = button.data('brands')
    var categories = button.data('categories')
    var brandsOptionsHtml = ""
    var categoriesOptionsHtml = ""

    var modal = $(this)

    brands.forEach(brand => {
      if(productBrand.id === brand.id ){
        brandsOptionsHtml+=`<option selected value="${brand.name}">${brand.name}</option>`
      }
      else{
        brandsOptionsHtml+=`<option value="${brand.name}">${brand.name}</option>`
      }
    });
    categories.forEach(category => {
      productCategories.forEach(productCategory => {
        if(productCategory.id === category.id ){
          categoriesOptionsHtml+=`<option selected id="category${category.id}" value="${category.name}">${category.name}</option>`
        }
        else{
          categoriesOptionsHtml+=`<option id="category${category.id}" value="${category.name}">${category.name}</option>`
        }
      });
    });

    modal.find('#edit_name').attr('placeholder', button.data('product_name'))
    modal.find('#edit_description').attr('placeholder', button.data('product_description'))
    modal.find('#edit_price').attr('placeholder', button.data('product_price'))
    modal.find('#edit_quantity').attr('placeholder', button.data('product_quantity'))


    modal.find('#mltislct').empty()
    console.log(modal.find('#edit_categories'))
    modal.find('#mltislct').append(categoriesOptionsHtml)
    $('#mltislct').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth:'300px',
      enableCaseInsensitiveFiltering: true,
      filterPlaceholder:'Search Here..'
    });
    modal.find('#edit_brands').empty()
    modal.find('#edit_brands').append(brandsOptionsHtml)
  })
  $('#viewProductModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget) 

    const modal = $(this)
    const categories = button.data('product_categories')
    const images = button.data('product_images')
    let categoriesHtml = ''
    let imagesHtml = ''


    categories.forEach((category, i) => {
      categoriesHtml += (i!==(categories.length-1))? `${category.name} • ` : `${category.name}`
    });
    images.forEach(image => {
      imagesHtml += `<li id="image.${image}" style="margin:5px;"><img src="${image}" alt="" role="button"> </li>`
    });

    modal.find('#show_product_name').text(button.data('product_name'))
    modal.find('#show_product_brand').text(button.data('product_brands'))
    modal.find('#show_product_description').text(button.data('product_description'))
    modal.find('#show_product_price').text(button.data('product_price'))
    modal.find('#show_product_quantity').text(button.data('product_quantity'))
    modal.find('#show_product_brand').text(button.data('product_brand').name)
    modal.find('#show_product_categories').text(categoriesHtml)
    modal.find('#image_list').empty()
    modal.find('#image_list').append(imagesHtml)
    modal.find('#changeMe').attr('src',images[0])
    modal.find('#show_product_form').text(button.data('product_action'))

  })

  </script>
</x-app-layout>
