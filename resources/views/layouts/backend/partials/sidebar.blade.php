<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <div class="c-sidebar-brand-full" alt="{{ env('APP_NAME') }} Logo">
            <img src="{{ asset('assets/img/logo-new.png') }}" width="190" height="100">
        </div>
        <svg class="c-sidebar-brand-minimized" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/coreui/assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <div class="c-sidebar-brand d-lg-none">
        <img src="{{ asset('assets/img/logo-new.png') }}" width="190" height="100">
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('home') }}">
                <i class="c-sidebar-nav-icon c-icon cil-home"></i> Dashboard
            </a>
        </li>

        <li class="c-sidebar-nav-title">Background Management</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('background.index') }}">
                <i class="c-sidebar-nav-icon c-icon cil-image1"></i> List Background 
            </a>
        </li>

        <li class="c-sidebar-nav-title">Frame Management</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('frame.index') }}">
                <i class="c-sidebar-nav-icon c-icon cil-filter-frames"></i> List Frame 
            </a>
        </li>

        <li class="c-sidebar-nav-title">Photo Management</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('photo.index') }}">
                <i class="c-sidebar-nav-icon c-icon cil-image1"></i> List Photo
                <span class="badge badge-info">NEW</span>
            </a>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>