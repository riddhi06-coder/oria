<!-- Page Body Start-->
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.png') }}" alt="" style="max-width: 20% !important;"></a>
		  	<a href="{{ route('admin.dashboard') }}">
				<img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo-icon.png') }}" alt="" style="max-width: 65% !important;">
			</a>  
		  <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo-1.png') }}" alt="" ></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo-icon.png') }}" alt=""></a>
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

                <li class="sidebar-list {{ request()->routeIs('user-list.index', 'user-permissions.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link sidebar-title {{ request()->routeIs('user-list.index', 'user-permissions.index') ? 'active' : '' }}" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                        </svg>
                        <span>User Management</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('user-list.index') }}" class="sidebar-link {{ request()->routeIs('user-list.index') ? 'active' : '' }}">
                                New User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user-permissions.index') }}" class="sidebar-link {{ request()->routeIs('user-permissions.index') ? 'active' : '' }}">
                                User Permissions
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-list {{ request()->routeIs('about.index') ? 'active' : '' }}">
                    <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link" href="{{ route('about.index') }}">
                        <svg class="stroke-icon"> 
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-table') }}"></use>
                        </svg>
                        <span>About US</span>
                    </a>
                </li>


                <li class="sidebar-list {{ request()->routeIs('collections.index', 'product-category.index', 'product-fabrics.index', 'fabric-composition.index', 'product-sizes.index', 'product-prints.index', 'product-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <span>Store Management</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('collections.index') }}" class="{{ request()->routeIs('collections.index') ? 'active' : '' }}">Collections</a></li>
                    <li><a href="{{ route('product-category.index') }}" class="{{ request()->routeIs('product-category.index') ? 'active' : '' }}">Product Category</a></li>
                    <li><a href="{{ route('product-fabrics.index') }}" class="{{ request()->routeIs('product-fabrics.index') ? 'active' : '' }}">Product Fabrics</a></li>
                    <li><a href="{{ route('fabric-composition.index') }}" class="{{ request()->routeIs('fabric-composition.index') ? 'active' : '' }}">Fabric Composition</a></li>
                    <li><a href="{{ route('product-sizes.index') }}" class="{{ request()->routeIs('product-sizes.index') ? 'active' : '' }}">Product Sizes</a></li>
                    <li><a href="{{ route('product-prints.index') }}" class="{{ request()->routeIs('product-prints.index') ? 'active' : '' }}">Print Options</a></li>
                    <li><a href="{{ route('product-details.index') }}" class="{{ request()->routeIs('product-details.index') ? 'active' : '' }}">Product Details</a></li>
                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('banner-details.index', 'new-arrivals.index', 'collection-details.index', 'shop-category.index', 'product-policies.index', 'testimonials.index', 'social-media.index', 'footer.index') ? 'active' : '' }}">
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
                    <li><a href="{{ route('banner-details.index') }}" class="{{ request()->routeIs('banner-details.index') ? 'active' : '' }}">Banner Details</a></li>
                    <li><a href="{{ route('new-arrivals.index') }}" class="{{ request()->routeIs('new-arrivals.index') ? 'active' : '' }}">New Arrivals</a></li>
                    <li><a href="{{ route('collection-details.index') }}" class="{{ request()->routeIs('collection-details.index') ? 'active' : '' }}">Collection Details</a></li>
                    <li><a href="{{ route('shop-category.index') }}" class="{{ request()->routeIs('shop-category.index') ? 'active' : '' }}">Shop By Category</a></li>
                    <li><a href="{{ route('product-policies.index') }}" class="{{ request()->routeIs('product-policies.index') ? 'active' : '' }}">Product Policies</a></li>
                    <li><a href="{{ route('testimonials.index') }}" class="{{ request()->routeIs('testimonials.index') ? 'active' : '' }}">Testimonials</a></li>
                    <li><a href="{{ route('social-media.index') }}" class="{{ request()->routeIs('social-media.index') ? 'active' : '' }}">Social Media</a></li>
                    <li><a href="{{ route('footer.index') }}" class="{{ request()->routeIs('footer.index') ? 'active' : '' }}">Footer</a></li>
                  </ul>
                </li>

                <li class="sidebar-list {{ request()->routeIs('terms.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('terms.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-learning') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-learning') }}"></use>
                    </svg>
                    <span>Terms & Condition</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('shipping.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('shipping.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-support-tickets') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-support-tickets') }}"></use>
                    </svg>
                    <span>Shipping & Delivery</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('return.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('return.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#return-box') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#return-box') }}"></use>
                    </svg>
                    <span>Return & Exchange</span>
                  </a>
                </li>


                <li class="sidebar-list {{ request()->routeIs('privacy.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('privacy.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#customers') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#customers') }}"></use>
                    </svg>
                    <span>Privacy Policy</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('seo-tags.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('seo-tags.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                    </svg>
                    <span>SEO</span>
                  </a>
                </li>



                <li class="sidebar-list {{ request()->routeIs('stock-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('stock-details.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#sale') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#sale') }}"></use>
                    </svg>
                    <span>Stock Management</span>
                  </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('reports.list') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('reports.list') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-file') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-file') }}"></use>
                    </svg>
                    <span>Reports</span>
                  </a>
                </li>
                
                <li class="sidebar-list {{ request()->routeIs('users.list') ? 'active' : '' }}">
                    <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link" href="{{ route('users.list') }}">
                        <svg class="stroke-icon"> 
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#orders') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('admin/assets/svg/icon-sprite.svg#orders') }}"></use>
                        </svg>
                        <span>Order Tracking</span>
                    </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('order-tracking.user') ? 'active' : '' }}">
                    <i class="fa fa-list1"></i>
                    <a class="sidebar-link1" href="{{ route('order-tracking.user', ['id' => Auth::id()]) }}">
                    </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('user.view') ? 'active' : '' }}">
                    <i class="fa fa-user"></i>
                    <a class="sidebar-link1" href="{{ route('user.view', ['id' => Auth::id()]) }}">
                    </a>
                </li>

                <li class="sidebar-list {{ request()->routeIs('orders-tracking.details', ['order_id' => $order->order_id ?? '']) ? 'active' : '' }}">
                    <i class="fa fa-user1"></i>
                    @if(!empty($order->order_id)) 
                        <a class="sidebar-link1" href="{{ route('orders-tracking.details', ['order_id' => $order->order_id]) }}">
                        </a>
                    @else
                    @endif
                </li>
              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>


        