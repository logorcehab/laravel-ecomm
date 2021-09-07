 <!-- Sidebar -->
@inject('data', 'App\Models\Category')
<nav id="sidebarMenu"
	class="collapse d-lg-block sidebar collapse bg-white"
 >
	<div class="sidebar-sticky">
		<div class="list-group list-group-flush mx-3 mt-4">
			@if ($data->all())
				@foreach ($data->all() as $category)
				<a
					href="#"
					class="list-group-item list-group-item-action py-2 ripple"
					aria-current="true">
						<i class="fas fa-tachometer-alt fa-fw me-3"></i>
						<span>{{$category->name}}</span>
				</a>
				@endforeach
			@endif
		</div>
	</div>
</nav>