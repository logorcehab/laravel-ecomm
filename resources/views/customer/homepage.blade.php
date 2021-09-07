@extends('customer.layouts.app')
@section('content')
		{{-- Home Page Slider --}}
		<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
				</div>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="img/img.jpg" class="mr-auto ml-auto" style="width: 70%" alt="...">
					</div>
					<div class="carousel-item">
						<img src="img/img.jpg" class="mr-auto ml-auto" style="width: 70%" alt="...">
					</div>
					<div class="carousel-item">
						<img src="img/img.jpg" class="mr-auto ml-auto" style="width: 70%" alt="...">
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
		</div>
		<div class="products">
			@forelse ($categories as $category)
				<div class="brands_container row ml-auto mr-auto p-4">
					<div class="card w-100">
						<div class="card-header">
						{{$category->name}}
						</div>
						<div class="card-body row">

						@forelse ($category->products as $product)
							<div class="col-md-3 col-sm-12">
							  <div class="card">
								<img src="{{$product->images[0]->filename}}" class="card-img-top" alt="{{$product->name}}">
								<div class="card-body">
								  <h5 class="card-title">{{$product->name}}</h5>
								  <p class="card-text">{{$product->description}}</p>
								</div>
							  </div>
							</div>
						@empty
							
						@endforelse
						</div>
					</div>
					
				</div>
			@empty
				
			@endforelse
		</div>
		<div class="category_cards-container">
			{{-- sort by brands --}}
			{{-- Forech category(5) -> get assoc brands(3) -> then get brand's products(10) --}}
			
		</div>
@endsection