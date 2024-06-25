<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Luna Hotel</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">

			<li>
					<a href="{{route('admin.dashboard')}}">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Manage Team</div>
					</a>
					<ul>
						<li> <a href="{{route('all.employees')}}"><i class='bx bx-radio-circle'></i>All Employees</a>
						</li>
						<li> <a href="{{route('add.employee')}}"><i class='bx bx-radio-circle'></i>Add New Employee</a>
						</li>
					</ul>
				</li>


				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Manage Website Banner</div>
					</a>
					<ul>
						<li> <a href="{{route('banner.details')}}"><i class='bx bx-radio-circle'></i>Update Banner</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Manage Room Type</div>
					</a>
					<ul>
						<li> <a href="{{route('room.type.list')}}"><i class='bx bx-radio-circle'></i>Room Type List</a>
						</li>
					</ul>
				</li>


				<li class="menu-label">Gestionare Rezervari</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Rezervari</div>
					</a>
					<ul>
						<li> <a href="{{route('booking.list')}}"><i class='bx bx-radio-circle'></i>Lista Rezervarilor</a>
						</li>
						<li> <a href="ecommerce-products-details.html"><i class='bx bx-radio-circle'></i>Product Details</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Components</div>
					</a>
					<ul>
						<li> <a href="component-alerts.html"><i class='bx bx-radio-circle'></i>Alerts</a>
						</li>
						<li> <a href="component-accordions.html"><i class='bx bx-radio-circle'></i>Accordions</a>
						</li>
					</ul>
				</li>
				


				

			
			
				<li class="menu-label">Others</li>
			

				<li>
					<a href="#" target="_blank">
						<div class="parent-icon"><i class="bx bx-support"></i>
						</div>
						<div class="menu-title">Support</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>