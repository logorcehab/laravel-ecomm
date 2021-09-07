<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <button
    class="navbar-toggler"
    type="button"
    data-toggle="collapse"
    data-target="#sidebarMenu"
    aria-controls="sidebarMenu"
    aria-expanded="false"
    aria-label="Toggle navigation"
    >
    <i class="fa fa-bars"></i>
  </button>
    <a class="navbar-brand" href="#">Project</a>
  
    <div class="collapse navbar-collapse" id="">
        <form class="form-inline col-md-7 ml-auto " style="width: 100%" id="">
            <input class="form-control ml-2" type="search" style="width: 75%" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-lg-0 ml-2" type="submit">Search</button>
        </form>
      <ul class="navbar-nav my-2 my-sm-0">
        <li class="nav-item dropdown mr-2">
          @auth('customer')
            <button class="btn btn-outline-secondary my-2 my-sm-0 nav-link dropdown-toggle" style="width: 9rem;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user">&nbsp;<span class="d-inline-block text-truncate" style="width: 6rem;">{{Auth::guard('customer')->user()->name}}</span></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">My Account</a>
              <a class="dropdown-item" href="#">Orders</a>
              <a class="dropdown-item" href="{{route('customer.logout')}}">Log  Out</a>
            </div>
          @endauth
          @guest('customer')
            <button class="btn btn-outline-secondary my-2 my-sm-0 nav-link dropdown-toggle" style="width: 7rem;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user">&nbsp;Account</i>
            </button>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">My Account</a>
              <a class="dropdown-item" href="{{route('customer.login.index')}}">Sign In</a>
              <a class="dropdown-item" href="#">Orders</a>
            </div>
          @endguest
        </li>
        <li class="nav-item">
          <button class="btn btn-outline-secondary my-0 my-lg-0 nav-link" 
            style="border: 0px; padding-left: 10px;"
            href="#">
            <i class="fa fa-shopping-cart">&nbsp;Cart</i>
          </button>
        </li>
      </ul>
    </div>
    <a class="navbar-toggler" 
      data-toggle="collapse"
      style="border: 0px" >
      <i class="fa fa-search"></i>
    </a>
    <a class="navbar-toggler" style="border: 0px" data-toggle="collapse">
      <i class="fa fa-user"></i>
    </a>
    {{-- // TODO Account modal --}}
    <a class="navbar-toggler" 
      data-toggle="collapse"
      style="border: 0px">
      <i class="fa fa-shopping-cart"></i>
    </a>
  </nav>