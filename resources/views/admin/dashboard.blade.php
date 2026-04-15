@extends('layouts.admin')

@section('page_title', $isRtl ? 'الرئيسية' : 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon bg-primary"><i class="fa-solid fa-users"></i></div>
        <div>
            <p class="stat-value">{{ number_format($stats['users']) }}</p>
            <div class="stat-label">{{ $isRtl ? 'المستخدمون' : 'Users' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-success"><i class="fa-solid fa-file-signature"></i></div>
        <div>
            <p class="stat-value">{{ number_format($stats['applications']) }}</p>
            <div class="stat-label">{{ $isRtl ? 'إجمالي الطلبات' : 'Total Applications' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-warning"><i class="fa-solid fa-clock"></i></div>
        <div>
            <p class="stat-value">{{ number_format($stats['pending_apps']) }}</p>
            <div class="stat-label">{{ $isRtl ? 'طلبات قيد المراجعة' : 'Pending Applications' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-info"><i class="fa-solid fa-envelope"></i></div>
        <div>
            <p class="stat-value">{{ number_format($stats['new_contacts']) }}</p>
            <div class="stat-label">{{ $isRtl ? 'رسائل جديدة' : 'New Messages' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-primary"><i class="fa-solid fa-briefcase"></i></div>
        <div>
            <p class="stat-value">{{ $stats['services'] }}</p>
            <div class="stat-label">{{ $isRtl ? 'الخدمات' : 'Services' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-success"><i class="fa-solid fa-building-columns"></i></div>
        <div>
            <p class="stat-value">{{ $stats['banks'] }}</p>
            <div class="stat-label">{{ $isRtl ? 'البنوك' : 'Banks' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-info"><i class="fa-solid fa-tags"></i></div>
        <div>
            <p class="stat-value">{{ $stats['offers'] }}</p>
            <div class="stat-label">{{ $isRtl ? 'العروض' : 'Offers' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon bg-danger"><i class="fa-solid fa-newspaper"></i></div>
        <div>
            <p class="stat-value">{{ $stats['articles'] }}</p>
            <div class="stat-label">{{ $isRtl ? 'المقالات' : 'Articles' }}</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
    <div class="admin-card">
        <div class="card-head">
            <h2><i class="fa-solid fa-file-signature"></i> {{ $isRtl ? 'أحدث الطلبات' : 'Recent Applications' }}</h2>
            <a href="{{ route('admin.applications.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">{{ $isRtl ? 'عرض الكل' : 'View All' }}</a>
        </div>
        <table class="admin-table">
            <thead>
            <tr>
                <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
                <th>{{ $isRtl ? 'البنك' : 'Bank' }}</th>
                <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                <th>{{ $isRtl ? 'التاريخ' : 'Date' }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentApplications as $app)
                <tr>
                    <td><a href="{{ route('admin.applications.show', $app) }}">{{ $app->full_name }}</a></td>
                    <td>{{ $app->bank?->name ?? '—' }}</td>
                    <td>
                        @php
                            $statusBadge = match($app->status) {
                                'approved' => 'badge-success',
                                'pending'  => 'badge-warning',
                                'rejected' => 'badge-danger',
                                default    => 'badge-muted',
                            };
                        @endphp
                        <span class="badge-pill {{ $statusBadge }}">{{ $app->status }}</span>
                    </td>
                    <td>{{ $app->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#9ca3af;">{{ $isRtl ? 'لا توجد طلبات بعد' : 'No applications yet' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <div class="card-head">
            <h2><i class="fa-solid fa-envelope"></i> {{ $isRtl ? 'أحدث الرسائل' : 'Recent Messages' }}</h2>
            <a href="{{ route('admin.contacts.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">{{ $isRtl ? 'عرض الكل' : 'View All' }}</a>
        </div>
        <table class="admin-table">
            <thead>
            <tr>
                <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
                <th>{{ $isRtl ? 'الموضوع' : 'Subject' }}</th>
                <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                <th>{{ $isRtl ? 'التاريخ' : 'Date' }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentContacts as $contact)
                <tr>
                    <td><a href="{{ route('admin.contacts.show', $contact) }}">{{ $contact->name }}</a></td>
                    <td>{{ \Illuminate\Support\Str::limit($contact->subject, 40) }}</td>
                    <td><span class="badge-pill {{ $contact->status === 'new' ? 'badge-primary' : 'badge-muted' }}">{{ $contact->status }}</span></td>
                    <td>{{ $contact->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:#9ca3af;">{{ $isRtl ? 'لا توجد رسائل بعد' : 'No messages yet' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
