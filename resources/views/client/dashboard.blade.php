@extends('layouts.client')

@section('page_title', $isRtl ? 'الرئيسية' : 'Dashboard')

@section('content')
    @php
        $name = auth()->user()->name;
        $hour = (int) now()->format('H');
        if ($isRtl) {
            if ($hour < 12)        $greeting = 'صباح الخير';
            elseif ($hour < 18)    $greeting = 'مساء الخير';
            else                   $greeting = 'مساء الخير';
        } else {
            if ($hour < 12)        $greeting = 'Good morning';
            elseif ($hour < 18)    $greeting = 'Good afternoon';
            else                   $greeting = 'Good evening';
        }
    @endphp

    <div class="welcome-banner">
        <div>
            <h2>
                {{ $isRtl
                    ? 'أهلاً وسهلاً بك، ' . $name . ' 👋'
                    : $greeting . ', ' . $name . ' 👋' }}
            </h2>
            <p>
                {{ $isRtl
                    ? 'يسعدنا انضمامك إلينا. من هنا يمكنك متابعة جميع طلباتك ومعرفة آخر المستجدات.'
                    : 'We are glad to have you. Track all your requests and latest updates from here.' }}
            </p>
        </div>
        <a href="{{ route('client.financing-request.create') }}" class="btn-c" style="background:white; color:#0d6efd;">
            <i class="fa-solid fa-plus"></i>
            {{ $isRtl ? 'طلب تمويل جديد' : 'New Finance Request' }}
        </a>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary"><i class="fa-solid fa-list"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['total']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'إجمالي الطلبات' : 'Total Requests' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-info"><i class="fa-solid fa-clock"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['new']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'طلبات جديدة' : 'New' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-warning"><i class="fa-solid fa-hourglass-half"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['reviewing']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'قيد المراجعة' : 'Reviewing' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success"><i class="fa-solid fa-circle-check"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['approved']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'موافق عليها' : 'Approved' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-danger"><i class="fa-solid fa-circle-xmark"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['rejected']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'مرفوضة' : 'Rejected' }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success"><i class="fa-solid fa-flag-checkered"></i></div>
            <div>
                <p class="stat-value">{{ number_format($stats['completed']) }}</p>
                <div class="stat-label">{{ $isRtl ? 'مكتملة' : 'Completed' }}</div>
            </div>
        </div>
    </div>

    <div class="client-card">
        <div class="card-head">
            <h2>{{ $isRtl ? 'طلباتي' : 'My Requests' }}</h2>
            <a href="{{ route('client.financing-request.create') }}" class="btn-c btn-c-primary btn-c-sm">
                <i class="fa-solid fa-plus"></i>
                {{ $isRtl ? 'طلب جديد' : 'New Request' }}
            </a>
        </div>

        @if($applications->count() === 0)
            <div class="empty">
                <i class="fa-solid fa-inbox"></i>
                <p>{{ $isRtl ? 'لا توجد طلبات حتى الآن. قدّم طلبك الأول الآن.' : 'No requests yet. Submit your first request.' }}</p>
                <a href="{{ route('client.financing-request.create') }}" class="btn-c btn-c-primary">
                    {{ $isRtl ? 'قدّم طلبك الأول' : 'Submit Your First Request' }}
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $isRtl ? 'الخدمة' : 'Service' }}</th>
                            <th>{{ $isRtl ? 'البنك' : 'Bank' }}</th>
                            <th>{{ $isRtl ? 'المبلغ' : 'Amount' }}</th>
                            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                            <th>{{ $isRtl ? 'التاريخ' : 'Date' }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $app)
                        @php
                            $statusColors = [
                                'new'       => ['#e0e7ff', '#4338ca'],
                                'reviewing' => ['#fef3c7', '#a16207'],
                                'approved'  => ['#dcfce7', '#166534'],
                                'rejected'  => ['#fee2e2', '#991b1b'],
                                'completed' => ['#dbeafe', '#1d4ed8'],
                            ];
                            $statusLabelsAr = [
                                'new' => 'جديد', 'reviewing' => 'قيد المراجعة',
                                'approved' => 'موافق', 'rejected' => 'مرفوض', 'completed' => 'مكتمل',
                            ];
                            [$bg, $fg] = $statusColors[$app->status] ?? ['#f3f4f6', '#4b5563'];
                            $label = $isRtl ? ($statusLabelsAr[$app->status] ?? $app->status) : ucfirst($app->status);
                        @endphp
                        <tr>
                            <td>#{{ $app->id }}</td>
                            <td>{{ $app->service->name ?? '—' }}</td>
                            <td>{{ $app->bank->name ?? '—' }}</td>
                            <td>{{ $app->amount ? number_format($app->amount) : '—' }}</td>
                            <td>
                                <span class="badge-pill" style="background: {{ $bg }}; color: {{ $fg }};">{{ $label }}</span>
                            </td>
                            <td style="color:#6b7280;">{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('client.applications.show', $app) }}" class="btn-c btn-c-outline btn-c-sm">
                                    {{ $isRtl ? 'التفاصيل' : 'View' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:1rem 0 0;">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection
