<!-- Page Body Start-->
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.webp') }}" alt="" style="max-width: 70% !important;"></a>
		  	<a href="{{ route('admin.dashboard') }}">
				<img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.png1') }}" alt="" style="max-width: 65% !important;">
			</a>  
		  <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.png') }}" alt="" style="max-width: 60% !important; margin-right:30px;"></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.png') }}" alt="" style="max-width: 10% !important;"></a>
                  <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
             
                <li class="sidebar-list {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg>
                    <span class="lan-3">Dashboard</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('manage-solution-type.index', 'manage-category.index', 'manage-sub-category.index', 'manage-sub-product.index', 'product-sizes.index', 'product-prints.index', 'product-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <span>Solutions</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-solution-type.index') }}" class="{{ request()->routeIs('manage-solution-type.index') ? 'active' : '' }}">Add Solutions</a></li>
                    <li><a href="{{ route('manage-category.index') }}" class="{{ request()->routeIs('manage-category.index') ? 'active' : '' }}">Category</a></li>
                    <li><a href="{{ route('manage-sub-category.index') }}" class="{{ request()->routeIs('manage-sub-category.index') ? 'active' : '' }}">Sub Category</a></li>
                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-projects.index', 'manage-category.index', 'manage-sub-category.index', 'manage-sub-product.index', 'product-sizes.index', 'product-prints.index', 'product-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                    </svg>
                    <span>Projects</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-projects.index') }}" class="{{ request()->routeIs('manage-projects.index') ? 'active' : '' }}">Add Projects</a></li>
                  </ul>
                </li>

                <li class="sidebar-list {{ request()->routeIs('manage-banner-intro.index', 'manage-gallery.index', 'manage-our-solutions.index', 'manage-our-features.index','manage-customized.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Home page</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-banner-intro.index') }}" class="{{ request()->routeIs('manage-banner-intro.index') ? 'active' : '' }}">Banner & Intro</a></li>
                    <li><a href="{{ route('manage-gallery.index') }}" class="{{ request()->routeIs('manage-gallery.index') ? 'active' : '' }}">Project Gallery</a></li>
                    <li><a href="{{ route('manage-our-features.index') }}" class="{{ request()->routeIs('manage-our-features.index') ? 'active' : '' }}">Our Features</a></li>
                    <li><a href="{{ route('manage-our-solutions.index') }}" class="{{ request()->routeIs('manage-our-solutions.index') ? 'active' : '' }}">Our Solutions</a></li>
                    <li><a href="{{ route('manage-customized.index') }}" class="{{ request()->routeIs('manage-customized.index') ? 'active' : '' }}">Customized Solutions</a></li>
                  </ul>
                </li>


              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>


        