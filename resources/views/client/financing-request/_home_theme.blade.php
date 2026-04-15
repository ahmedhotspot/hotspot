{{-- Re-skin the client dashboard layout to use the home page theme (colors + logo).
     Included from financing-request views only via @push('styles') / @push('scripts'). --}}

@php
    $homeLocale = app()->getLocale();
    $homeLogoKey = $homeLocale === 'ar' ? 'logo_ar' : 'logo_en';
    $homeLogo = isset($siteSettings)
        ? $siteSettings->get($homeLogoKey, 'assets/img/logo_ar.png')
        : 'assets/img/logo_ar.png';
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    :root {
        --c-primary: #FF4040;
        --c-primary-light: #FFEDED;
        --c-primary-dark: #D32F2F;
        --c-gradient: linear-gradient(135deg, #FF4040 0%, #FF6B6B 100%);
    }

    /* Force Cairo font across the financing-request pages */
    body, body * ,
    .client-sidebar, .client-sidebar *,
    .client-topbar, .client-topbar *,
    .client-content, .client-content *,
    input, select, textarea, button, .btn, h1, h2, h3, h4, h5, h6 {
        font-family: 'Cairo', system-ui, -apple-system, sans-serif !important;
    }

    /* Sidebar brand: hide the logo entirely on financing-request pages */
    .client-sidebar .brand-logo { display: none !important; }

    /* Avatar + active nav: red gradient instead of blue/indigo */
    .client-sidebar .user-avatar,
    .client-sidebar .nav-link.active {
        background: var(--c-gradient) !important;
        color: #fff !important;
    }

    /* Welcome banner (used in dashboards) — swap to home gradient */
    .welcome-banner { background: var(--c-gradient) !important; }

    /* Buttons + chips */
    .btn-c-primary { background: var(--c-primary) !important; color: #fff !important; }
    .btn-c-primary:hover { background: var(--c-primary-dark) !important; }
    .client-topbar .user-chip i { color: var(--c-primary) !important; }

    /* Stat-icon primary tint */
    .stat-icon.bg-primary { background: var(--c-primary-light) !important; color: var(--c-primary-dark) !important; }

    /* Bootstrap btn-primary used by stepper actions */
    .btn-primary, .btn.btn-primary {
        background: var(--c-gradient) !important;
        border-color: var(--c-primary) !important;
    }
    .btn-primary:hover, .btn.btn-primary:hover {
        background: var(--c-primary-dark) !important;
        border-color: var(--c-primary-dark) !important;
    }
    .btn-outline-primary, .btn.btn-outline-primary {
        color: var(--c-primary) !important;
        border-color: var(--c-primary) !important;
    }
    .btn-outline-primary:hover, .btn.btn-outline-primary:hover {
        background: var(--c-primary) !important;
        color: #fff !important;
    }

    /* Stepper accent (current step circle / labels) */
    .stepper-item.current .stepper-circle {
        background: var(--c-primary) !important;
        box-shadow: 0 0 0 6px rgba(255, 64, 64, .15) !important;
    }
    .stepper-item.current .stepper-step,
    .stepper-item.current .stepper-title,
    .stepper-item.current .stepper-status {
        color: var(--c-primary) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        var brand = document.querySelector('.client-sidebar .brand-logo');
        if (brand) { brand.remove(); }
        var name = document.querySelector('.client-sidebar .brand-name');
        if (name) {
            name.textContent = {!! json_encode(app()->getLocale() === 'ar' ? 'هوت سبوت' : 'Hotspot') !!};
        }
        var topbar = document.querySelector('.client-topbar h1');
        // leave topbar title alone — controlled by @yield('page_title')
    })();
</script>
@endpush
