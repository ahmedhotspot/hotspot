<!doctype html>
<html lang="{{ $currentLocale ?? app()->getLocale() }}" dir="{{ $isRtl ?? true ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $isRtl ? 'لوحة التحكم' : 'Admin Dashboard') | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('Hotspot_Redesign/assets/css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:slnt,wght@-2,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-variation-settings: "slnt" -2;
        }
    </style>
    <style>
        :root {
            --admin-sidebar-w: 260px;
            --admin-bg: #f5f7fb;
            --admin-border: #e6e9f0;
            --admin-text: #1e2333;
            --admin-muted: #6b7280;
            --admin-primary: #0d6efd;
            --admin-success: #16a34a;
            --admin-danger: #dc2626;
            --admin-warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: {{ $isRtl ?? true ? "'Cairo'" : "'Inter'" }}, system-ui, sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-w);
            background: #0f172a;
            color: #cbd5e1;
            padding: 1.25rem 0;
            position: fixed;
            top: 0;
            bottom: 0;
            {{ $isRtl ?? true ? 'right' : 'left' }}: 0;
            overflow-y: auto;
            z-index: 100;
        }

        .admin-sidebar .brand {
            padding: 0 1.25rem 1.25rem;
            border-bottom: 1px solid #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .admin-sidebar .brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0d6efd, #6366f1);
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .admin-sidebar .brand-name {
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .admin-sidebar .nav-section {
            padding: 0 .5rem;
            margin-bottom: .5rem;
        }

        .admin-sidebar .nav-title {
            font-size: .7rem;
            text-transform: uppercase;
            color: #64748b;
            padding: .5rem 1rem;
            letter-spacing: .05em;
        }

        .admin-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .65rem 1rem;
            border-radius: 8px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: .92rem;
            font-weight: 500;
            transition: all .15s;
        }

        .admin-sidebar .nav-link:hover {
            background: #1e293b;
            color: white;
        }

        .admin-sidebar .nav-link.active {
            background: linear-gradient(135deg, #0d6efd, #6366f1);
            color: white;
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .admin-main {
            flex: 1;
            margin-{{ $isRtl ?? true ? 'right' : 'left' }}: var(--admin-sidebar-w);
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: white;
            border-bottom: 1px solid var(--admin-border);
            padding: .85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-topbar h1 {
            font-size: 1.15rem;
            margin: 0;
            font-weight: 700;
        }

        .admin-topbar .actions {
            display: flex;
            gap: .75rem;
            align-items: center;
        }

        .admin-topbar .user-chip {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .4rem .8rem;
            background: var(--admin-bg);
            border-radius: 999px;
            font-size: .88rem;
            font-weight: 600;
        }

        .admin-topbar .user-chip i {
            color: var(--admin-primary);
        }

        .admin-content {
            padding: 1.5rem;
            flex: 1;
        }

        .admin-card {
            background: white;
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 1.25rem;
        }

        .admin-card+.admin-card {
            margin-top: 1rem;
        }

        .admin-card .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: .85rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-card .card-head h2 {
            font-size: 1.05rem;
            margin: 0;
            font-weight: 700;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.25rem;
        }

        .stat-card .stat-value {
            font-size: 1.7rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .stat-card .stat-label {
            color: var(--admin-muted);
            font-size: .85rem;
            margin-top: .35rem;
        }

        .stat-icon.bg-primary {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-icon.bg-success {
            background: #dcfce7;
            color: #166534;
        }

        .stat-icon.bg-warning {
            background: #fef3c7;
            color: #a16207;
        }

        .stat-icon.bg-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .stat-icon.bg-info {
            background: #e0e7ff;
            color: #4338ca;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: .8rem .75rem;
            text-align: {{ $isRtl ?? true ? 'right' : 'left' }};
            border-bottom: 1px solid var(--admin-border);
            font-size: .9rem;
        }

        .admin-table th {
            background: #f9fafb;
            font-weight: 600;
            color: var(--admin-muted);
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .admin-table tr:hover td {
            background: #fafbff;
        }

        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem .9rem;
            border-radius: 8px;
            font-size: .88rem;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-admin-primary {
            background: var(--admin-primary);
            color: white;
        }

        .btn-admin-primary:hover {
            background: #0b5ed7;
            color: white;
        }

        .btn-admin-outline {
            background: white;
            color: var(--admin-text);
            border-color: var(--admin-border);
        }

        .btn-admin-outline:hover {
            background: var(--admin-bg);
        }

        .btn-admin-danger {
            background: var(--admin-danger);
            color: white;
        }

        .btn-admin-danger:hover {
            background: #b91c1c;
            color: white;
        }

        .btn-admin-sm {
            padding: .3rem .6rem;
            font-size: .8rem;
        }

        .badge-pill {
            display: inline-block;
            padding: .2rem .6rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #a16207;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-muted {
            background: #f3f4f6;
            color: #4b5563;
        }

        .badge-primary {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-field label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: .4rem;
            color: var(--admin-text);
        }

        .form-field input[type=text],
        .form-field input[type=email],
        .form-field input[type=url],
        .form-field input[type=number],
        .form-field input[type=password],
        .form-field input[type=tel],
        .form-field input[type=date],
        .form-field input[type=datetime-local],
        .form-field select,
        .form-field textarea {
            width: 100%;
            padding: .6rem .8rem;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            font-size: .92rem;
            font-family: inherit;
        }

        .form-field textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-field .err {
            color: var(--admin-danger);
            font-size: .8rem;
            margin-top: .3rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .lang-tabs {
            display: flex;
            gap: .5rem;
            margin-bottom: .5rem;
        }

        .lang-tab {
            padding: .3rem .75rem;
            border-radius: 6px;
            border: 1px solid var(--admin-border);
            background: white;
            cursor: pointer;
            font-size: .8rem;
            font-weight: 600;
        }

        .lang-tab.active {
            background: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        .lang-pane {
            display: none;
        }

        .lang-pane.active {
            display: block;
        }

        .alert {
            padding: .8rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: .9rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        @media (max-width: 900px) {
            .admin-sidebar {
                transform: translateX({{ $isRtl ?? true ? '100%' : '-100%' }});
                transition: transform .25s;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-{{ $isRtl ?? true ? 'right' : 'left' }}: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $nav = [
            [
                'section' => $isRtl ? 'عام' : 'General',
                'items' => [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'label' => $isRtl ? 'الرئيسية' : 'Dashboard'],
                ],
            ],
            [
                'section' => $isRtl ? 'المحتوى' : 'Content',
                'items' => [
                    [
                        'route' => 'admin.pages.index',
                        'icon' => 'fa-file-lines',
                        'label' => $isRtl ? 'الصفحات' : 'Pages',
                    ],
                    [
                        'route' => 'admin.services.index',
                        'icon' => 'fa-briefcase',
                        'label' => $isRtl ? 'الخدمات' : 'Services',
                    ],
                    [
                        'route' => 'admin.banks.index',
                        'icon' => 'fa-building-columns',
                        'label' => $isRtl ? 'البنوك' : 'Banks',
                    ],
                    ['route' => 'admin.offers.index', 'icon' => 'fa-tags', 'label' => $isRtl ? 'العروض' : 'Offers'],
                    [
                        'route' => 'admin.articles.index',
                        'icon' => 'fa-newspaper',
                        'label' => $isRtl ? 'المقالات' : 'Articles',
                    ],
                    [
                        'route' => 'admin.faqs.index',
                        'icon' => 'fa-circle-question',
                        'label' => $isRtl ? 'الأسئلة الشائعة' : 'FAQs',
                    ],
                    [
                        'route' => 'admin.testimonials.index',
                        'icon' => 'fa-comment-dots',
                        'label' => $isRtl ? 'آراء العملاء' : 'Testimonials',
                    ],
                    [
                        'route' => 'admin.trust-metrics.index',
                        'icon' => 'fa-chart-simple',
                        'label' => $isRtl ? 'مؤشرات الثقة' : 'Trust Metrics',
                    ],
                    [
                        'route' => 'admin.steps.index',
                        'icon' => 'fa-list-ol',
                        'label' => $isRtl ? 'كيف نعمل' : 'How It Works',
                    ],
                ],
            ],
            [
                'section' => $isRtl ? 'الموقع' : 'Site',
                'items' => [
                    ['route' => 'admin.menus.index', 'icon' => 'fa-bars', 'label' => $isRtl ? 'القوائم' : 'Menus'],
                    [
                        'route' => 'admin.social.index',
                        'icon' => 'fa-share-nodes',
                        'label' => $isRtl ? 'وسائل التواصل' : 'Social Links',
                    ],
                    [
                        'route' => 'admin.content-blocks.index',
                        'icon' => 'fa-puzzle-piece',
                        'label' => $isRtl ? 'محتوى الصفحات' : 'Page Content',
                    ],
                    [
                        'route' => 'admin.settings.index',
                        'icon' => 'fa-gear',
                        'label' => $isRtl ? 'الإعدادات' : 'Settings',
                    ],
                    ['route' => 'admin.media.index', 'icon' => 'fa-image', 'label' => $isRtl ? 'الوسائط' : 'Media'],
                ],
            ],
            [
                'section' => $isRtl ? 'النشاط' : 'Activity',
                'items' => [
                    [
                        'route' => 'admin.applications.index',
                        'icon' => 'fa-file-signature',
                        'label' => $isRtl ? 'طلبات التمويل' : 'Applications',
                    ],
                    [
                        'route' => 'admin.contacts.index',
                        'icon' => 'fa-envelope',
                        'label' => $isRtl ? 'رسائل التواصل' : 'Contact Messages',
                    ],
                ],
            ],
            [
                'section' => $isRtl ? 'المستخدمون' : 'Users',
                'items' => [
                    ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => $isRtl ? 'المستخدمون' : 'Users'],
                ],
            ],
        ];
    @endphp

    <div class="admin-layout">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="brand">
                <div class="brand-logo">H</div>
                <div class="brand-name">{{ $siteSettings->get('site_name_' . app()->getLocale(), config('app.name')) }}
                </div>
            </div>
            @foreach ($nav as $section)
                <div class="nav-section">
                    <div class="nav-title">{{ $section['section'] }}</div>
                    @foreach ($section['items'] as $item)
                        @php $active = request()->routeIs($item['route']) || request()->routeIs(str_replace('.index','.*', $item['route'])); @endphp
                        <a href="{{ \Route::has($item['route']) ? route($item['route']) : '#' }}"
                            class="nav-link {{ $active ? 'active' : '' }}">
                            <i class="fa-solid {{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endforeach
            <div class="nav-section" style="margin-top: 2rem;">
                <a href="{{ route('home') }}" class="nav-link"><i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>{{ $isRtl ? 'عرض الموقع' : 'View Site' }}</span></a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link"
                        style="background: none; border: 0; width: 100%; text-align: {{ $isRtl ? 'right' : 'left' }}; cursor: pointer; font: inherit; color: inherit;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>{{ $isRtl ? 'تسجيل الخروج' : 'Logout' }}</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <h1>@yield('page_title', $isRtl ? 'لوحة التحكم' : 'Dashboard')</h1>
                <div class="actions">
                    <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                        class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-language"></i> {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
                    </a>
                    <div class="user-chip">
                        <i class="fa-solid fa-user-shield"></i>
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error') || $errors->any())
                    <div class="alert alert-danger">
                        {{ session('error') ?? ($isRtl ? 'يوجد أخطاء في البيانات المدخلة' : 'Please correct the errors below') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('.lang-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const group = tab.closest('.lang-group');
                if (!group) return;
                group.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
                group.querySelectorAll('.lang-pane').forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                group.querySelector('.lang-pane[data-lang="' + tab.dataset.lang + '"]').classList.add(
                    'active');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
