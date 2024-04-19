 <!--start header -->
 <header>
     <div class="topbar d-flex align-items-center">
         <nav class="navbar navbar-expand gap-3">
             <div class="mobile-toggle-menu"><i class="fa-solid fa-bars"></i>
             </div>

             <div class="top-menu ms-auto">

             </div>
             <div class="user-box dropdown">
                 <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <div class="user-img-wrp">
                         <img src="{{asset('admin/assets/images/avatars/avatar-2.png')}}" class="user-img" alt="user avatar">
                     </div>
                     <div class="user-info">
                         @if(Auth::guard('web')->check())
                         <p class="user-name mb-0"> {{ Auth::guard('web')->user()->email }}</p>
                         @endif

                         <i class="fa-solid fa-angle-down"></i>
                     </div>
                 </a>
                 <ul class="dropdown-menu dropdown-menu-end">
                     <li><a class="dropdown-item d-flex align-items-center" href="{{ route('changePassword')}}"><i class="fa-regular fa-user"></i><span>Change Password</span></a>
                     </li>

                     <li>

                         <form action="{{ route('logout') }}" method="post">
                             @csrf
                             <button class="dropdown-item d-flex align-items-center" type="submit"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
                         </form>

                     </li>
                 </ul>
             </div>

         </nav>
     </div>
 </header>
 <!--end header -->