 <!--begin::Sidebar-->
 <aside class="app-sidebar d-flex flex-column bg-white " data-bs-theme="light">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand text-center py-5">
         <a href="{{ asset('lte/dist/index.html') }}"
             class="d-flex align-items-center justify-content-center text-decoration-none ">
             <img src="{{ asset('logoPRPM.svg') }}" width="50" height="50" alt="Logo PRPM" class="me-3">
             <div class="text-start">
                 <span class="d-block fw-bold fs-4 text-dark mb-0">PRPM</span>
                 <span class="d-block text-muted fs-6">Triguna Dharma</span>
             </div>
         </a>
     </div>


     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">


         <nav class="mt-2">
             <!--begin::Sidebar Menu-->
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                 aria-label="Main navigation" data-accordion="false" id="navigation">



                 @role('admin')
                     <li class="nav-item menu-open">
                         <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                             <i class="nav-icon bi bi-speedometer"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>
                 @endrole



                 @role('dosen')
                     <li class="nav-item menu-open">
                         <a href="{{ route('dosen.dashboard') }}" class="nav-link active">
                             <i class="nav-icon bi bi-speedometer"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>

                     <li class="nav-item ">
                         <a href="{{ route('dosen.penelitian.index') }}" class="nav-link  ">
                             <i class="bi bi-lightbulb-fill"></i>
                             <p>
                                 Penelitian
                             </p>
                         </a>

                     </li>

                     <li class="nav-item ">
                         <a href="{{ route('dosen.pengabdian.index') }}" class="nav-link  ">
                             <i class="bi bi-people-fill"></i>
                             <p>
                                 Pengabdian
                             </p>
                         </a>
                     </li>
                 @endrole

                 @role('ketua_prpm')
                     <li class="nav-item menu-open">
                         <a href="{{ route('ketua-prpm.dashboard') }}" class="nav-link active">
                             <i class="nav-icon bi bi-speedometer"></i>
                             <p>
                                 Dashboard
                             </p>
                         </a>
                     </li>
                  
                     <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="bi bi-file-earmark-text-fill"></i>
                         <p>
                             Reviews
                             <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('ketua-prpm.review.penelitian.proposal.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Penelitian</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('ketua-prpm.review.pengabdian.proposal.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Pengabdian</p>
                             </a>
                         </li>
                       
                     </ul>
                 @endrole

                 @role('reviewer')

                     <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="bi bi-file-earmark-text-fill"></i>

                         <p>
                             Reviews
                            
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('reviewer.review.penelitian.proposal.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Penelitian</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('reviewer.review.pengabdian.proposal.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Pengabdian</p>
                             </a>
                         </li>
                       
                     </ul>
                 @endrole


                 {{-- <li class="nav-item ">
                                 <a href="{{ route('dosen.uploadLaporan-pengabdian') }}" class="nav-link ">
                                     <i class="nav-icon bi bi-circle"></i>
                                     <p>Upload laporan</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                      <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="bi bi-file-earmark-text-fill"></i>
                         <p class="ps-3">Luaran</p>
                     </a>
                 </li> --}}
          





             @role('admin')
                 <li class="nav-item">
                     <a href="{{ route('admin.pusat-notifikasi') }}" class="nav-link">
                         <i class="bi bi-bell-fill"></i>
                         <p>Pusat Nontifikasi</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="bi bi-people-fill"></i>
                         <p>
                             Users management
                             <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('admin.user-registration.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>Users Registraion</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.assign-role.index') }}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>assign role</p>
                             </a>
                         </li>
                       
                     </ul>
                 @endrole


                 <hr>
                 {{-- <li class="nav-header">SETTING</li> --}}





             <li class="nav-item">
                 <a href="{{ route('profile.edit') }}" class="nav-link">
                     <i class="bi bi-gear-fill"></i>
                     <p class="ps-3">Pengaturan Profile</p>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="#" class="nav-link" id="logoutBtn">
                     <i class="bi bi-box-arrow-left"></i>
                     <p class="ps-3">Log out</p>
                 </a>
             </li>

             <!-- Form hidden untuk logout -->
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form>


         </ul>
         <!--end::Sidebar Menu-->
     </nav>
 </div>
 <!--end::Sidebar Wrapper-->

 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     document.getElementById('logoutBtn').addEventListener('click', function(e) {
         e.preventDefault();

         Swal.fire({
             title: 'Yakin ingin logout?',
             text: "Sesi kamu akan berakhir.",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             cancelButtonColor: '#6c757d',
             confirmButtonText: 'Ya, Logout',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById('logout-form').submit();
             }
         })
     });
 </script>
</aside>
<!--end::Sidebar-->
