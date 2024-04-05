 <!--sidebar wrapper -->
 <div class="sidebar-wrapper" data-simplebar="true">
     <div class="sidebar-header">
         <div class="sidebar-logo">
             <a href="index.php">
                 <img src="{{asset('admin/assets/logo/logo.png')}}" class="logo-icon" alt="logo icon">
                 <!-- <img src="assets/img/close-nav-logo.png" class="small-icon" alt=""> -->
             </a>
         </div>
         <div class="toggle-icon ms-auto"><i class="fa-solid fa-bars"></i>
         </div>
     </div>
     <!--navigation-->
     <ul class="metismenu" id="menu">
         <li class="menu-label">MENU</li>

         <li>
             <a href="{{ route('dashboard')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Dashboard</div>
             </a>

         </li>
         <li>
             <a href="{{ route('user.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">User Management</div>
             </a>

         </li>

         <li>
             <a href="{{ route('interest_and_hobby.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Interest And Hobbies</div>
             </a>

         </li>
         <li>
             <a href="{{ route('lifestyle.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Lifestyle</div>
             </a>

         </li>
         <li>
             <a href="{{ route('zodiacsign.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Zodiac Sign</div>
             </a>

         </li>
         <li>
             <a href="{{ route('curseword.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Curse Word</div>
             </a>

         </li>

         <li>
             <a href="{{ route('blockreason.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Block Reason</div>
             </a>

         </li>

         <li>
             <a href="{{ route('feedbackreviewlist.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Feedback Review List</div>
             </a>

         </li>

         <li>
             <a href="{{ route('leavereason.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Leave Reason</div>
             </a>

         </li>

         <li>
             <a href="{{ route('religion.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Religion</div>
             </a>

         </li>

         <li>
             <a href="{{ route('size_of_organization.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Size Of Organization</div>
             </a>

         </li>

         <li>
             <a href="{{ route('verificationobject.index')}}" class="">
                 <div class="parent-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                         <mask id="mask0_0_1414" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="17">
                             <rect y="0.100098" width="16.8" height="16.8" fill="white" />
                         </mask>
                         <g mask="url(#mask0_0_1414)">
                             <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9997 5.70015L9.79967 2.01815C9.00251 1.30515 7.79684 1.30515 6.99968 2.01815L2.79968 5.70015C2.34989 6.10242 2.09488 6.67874 2.09968 7.28215L2.09968 13.4002C2.09968 14.5599 3.03988 15.5002 4.19968 15.5002H12.5997C13.7595 15.5002 14.6997 14.5599 14.6997 13.4002V7.27515C14.7025 6.6742 14.4476 6.10082 13.9997 5.70017L13.9997 5.70015ZM9.79968 14.1001H6.99968V10.6001C6.99968 10.2135 7.31308 9.90015 7.69968 9.90015H9.09968C9.48627 9.90015 9.79968 10.2135 9.79968 10.6001V14.1001ZM13.2997 13.4001C13.2997 13.7867 12.9863 14.1001 12.5997 14.1001H11.1997V10.6001C11.1997 9.44035 10.2595 8.50015 9.09968 8.50015H7.69968C6.53988 8.50015 5.59968 9.44035 5.59968 10.6001V14.1001H4.19968C3.81308 14.1001 3.49968 13.7867 3.49968 13.4001V7.27515C3.49994 7.07407 3.58664 6.88283 3.73769 6.75013L7.93768 3.07515C8.20193 2.84299 8.59742 2.84299 8.86168 3.07515L13.0617 6.75015C13.2127 6.88284 13.2994 7.07409 13.2997 7.27515V13.4001Z" fill="#6D7794" />
                         </g>
                     </svg>
                 </div>
                 <div class="menu-title">Verification Object</div>
             </a>

         </li>




         </li>

     </ul>
     <!--end navigation-->
 </div>