<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cariox</title>
    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $faviconUrl = $siteSettings && $siteSettings->favicon 
            ? Storage::url($siteSettings->favicon) 
            : asset('favicon.ico');
        $tinyMceLocalPath = public_path('vendor/tinymce/tinymce.min.js');
        $tinyMceScriptUrl = file_exists($tinyMceLocalPath)
            ? asset('vendor/tinymce/tinymce.min.js')
            : 'https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js';
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <!-- Simple icon font for demonstration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            @if(isset($siteSettings) && $siteSettings->logo)
                <img src="{{ Storage::url($siteSettings->logo) }}" alt="{{ $siteSettings->logo_alt_text ?? 'Cariox Admin' }}" style="max-height: 50px; width: auto; max-width: 100%; object-fit: contain;">
            @else
                <h2>Cariox Admin</h2>
            @endif
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="document.getElementById('homeSubMenu').classList.toggle('show')">
                    <i class="fas fa-layer-group"></i>
                    Home
                    <i class="fas fa-chevron-down" style="margin-left:auto; font-size: 0.8rem;"></i>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.home.*') || request()->routeIs('admin.testimonial.*') ? 'show' : '' }}" id="homeSubMenu">
                    <li>
                        <a href="{{ route('admin.home.banner.index') }}" class="nav-link {{ request()->routeIs('admin.home.banner.*') ? 'active' : '' }}">
                            <i class="fas fa-image"></i>
                            Banner Content
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.testimonial.index') }}" class="nav-link {{ request()->routeIs('admin.testimonial.*') ? 'active' : '' }}">
                            <i class="fas fa-comment-dots"></i>
                            Testimonials
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="document.getElementById('aboutSubMenu').classList.toggle('show')">
                    <i class="fas fa-user-friends"></i>
                    About
                    <i class="fas fa-chevron-down" style="margin-left:auto; font-size: 0.8rem;"></i>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.about.*') || request()->routeIs('admin.choose_us.*') || request()->routeIs('admin.journey.*') ? 'show' : '' }}" id="aboutSubMenu">
                    <li>
                        <a href="{{ route('admin.about.index') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                            <i class="fas fa-info-circle"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.choose_us.index') }}" class="nav-link {{ request()->routeIs('admin.choose_us.*') ? 'active' : '' }}">
                            <i class="fas fa-check-square"></i>
                            Choose Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.journey.index') }}" class="nav-link {{ request()->routeIs('admin.journey.*') ? 'active' : '' }}">
                            <i class="fas fa-route"></i>
                            Journey
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="document.getElementById('productSubMenu').classList.toggle('show')">
                    <i class="fas fa-box-open"></i>
                    Product
                    <i class="fas fa-chevron-down" style="margin-left:auto; font-size: 0.8rem;"></i>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.category.*') || request()->routeIs('admin.subcategory.*') || request()->routeIs('admin.product.*') ? 'show' : '' }}" id="productSubMenu">
                    <li>
                        <a href="{{ route('admin.category.index') }}" class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                            <i class="fas fa-sitemap"></i>
                            Category
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.subcategory.index') }}" class="nav-link {{ request()->routeIs('admin.subcategory.*') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            Subcategory
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.product.index') }}" class="nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            Products
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.service.index') }}" class="nav-link {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell"></i>
                    Services
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.blog.index') }}" class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    <i class="fas fa-blog"></i>
                    Blog
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.contact.index') }}" class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                    <i class="fas fa-address-book"></i>
                    Contact
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.brand.index') }}" class="nav-link {{ request()->routeIs('admin.brand.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    Brand
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.client.index') }}" class="nav-link {{ request()->routeIs('admin.client.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i>
                    Clients
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="document.getElementById('submitSubMenu').classList.toggle('show')">
                    <i class="fas fa-file-import"></i>
                    Submits
                    <i class="fas fa-chevron-down" style="margin-left:auto; font-size: 0.8rem;"></i>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.form_data.*') || request()->routeIs('admin.newsletter.*') ? 'show' : '' }}" id="submitSubMenu">
                    <li>
                        <a href="{{ route('admin.form_data.index') }}" class="nav-link {{ request()->routeIs('admin.form_data.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            Form Datas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope-open-text"></i>
                            Newsletter
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.metadata.index') }}" class="nav-link {{ request()->routeIs('admin.metadata.*') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    Metadata / SEO
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="document.getElementById('settingSubMenu').classList.toggle('show')">
                    <i class="fas fa-cog"></i>
                    Settings
                    <i class="fas fa-chevron-down" style="margin-left:auto; font-size: 0.8rem;"></i>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.settings.*') ? 'show' : '' }}" id="settingSubMenu">
                    <li>
                        <a href="{{ route('admin.settings.info') }}" class="nav-link {{ request()->routeIs('admin.settings.info') ? 'active' : '' }}">
                            <i class="fas fa-info-circle"></i>
                            Site Information
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.header_links.index') }}" class="nav-link {{ request()->routeIs('admin.settings.header_links.*') ? 'active' : '' }}">
                            <i class="fas fa-link"></i>
                            Header Links
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div>
                <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f8fafc; color: var(--primary-color, #4b2382); border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <i class="fas fa-external-link-alt"></i> Visit Site
                </a>
            </div>
            <div class="user-menu">
                <a href="{{ route('admin.profile') }}" class="user-info" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 0.75rem;">
                    @if(auth('admin')->user()->profile_image)
                        <div class="avatar" style="background-image: url('{{ Storage::url(auth('admin')->user()->profile_image) }}'); background-size: cover; background-position: center;">
                        </div>
                    @else
                        <div class="avatar">
                            {{ substr(auth('admin')->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <span style="display: block; font-weight: 600; font-size: 0.9rem;">{{ auth('admin')->user()->name }}</span>
                        <span style="display: block; font-size: 0.75rem; color: var(--text-light);">Administrator <i class="fas fa-edit" style="font-size: 0.7rem; margin-left: 2px;"></i></span>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div style="padding: 1.5rem;">
            @include('admin.partials.alerts')
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    
    <script src="{{ $tinyMceScriptUrl }}"></script>
    <script>
        window.TINYMCE_BASE_URL = @json(file_exists($tinyMceLocalPath) ? asset('vendor/tinymce') : 'https://cdn.jsdelivr.net/npm/tinymce@7');
        
        $(document).ready(function() {
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    order: [],
                    dom: "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                         "<'row'<'col-sm-12'tr>>" +
                         "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    language: {
                        search: "Search:",
                        searchPlaceholder: "",
                        lengthMenu: "Show _MENU_ entries",
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        }
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('js/admin-tinymce.js') }}"></script>
    @include('admin.partials.section_heading_validation')
    @stack('scripts')
</body>
</html>
