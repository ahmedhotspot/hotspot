@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('My Financing Requests', 'طلباتي'))
@section('page_title', ln('Financing Requests', 'طلبات التمويل'))

@section('content')
<div class="client-card">
    <div class="card-head">
        <h2>{{ ln('Financing Requests', 'طلبات التمويل') }}</h2>
        <a href="{{ route('client.financing-request.create') }}" class="btn-c btn-c-primary">
            <i class="fa-solid fa-plus"></i> {{ ln('New Request', 'طلب جديد') }}
        </a>
    </div>

    @if($requests->count() > 0)
        <div style="overflow-x:auto;">
            <table class="client-table">
                <thead>
                    <tr>
                        <th>{{ ln('Request #', 'رقم الطلب') }}</th>
                        <th>{{ ln('Client Name', 'اسم العميل') }}</th>
                        <th>{{ ln('National ID', 'رقم الهوية') }}</th>
                        <th>{{ ln('Mobile', 'رقم الجوال') }}</th>
                        <th>{{ ln('Status', 'الحالة') }}</th>
                        <th>{{ ln('Submission Date', 'تاريخ التقديم') }}</th>
                        <th>{{ ln('Actions', 'الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td><a href="{{ route('client.financing-request.show', $request->id) }}">#{{ $request->request_number }}</a></td>
                            <td>{{ $request->client_name ?? '-' }}</td>
                            <td>{{ $request->national_id ?? '-' }}</td>
                            <td>{{ $request->phone ?? '-' }}</td>
                            <td><span class="badge-pill" style="background:#dbeafe;color:#1d4ed8;">{{ $request->status_label ?? '-' }}</span></td>
                            <td>{{ optional($request->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('client.financing-request.show', $request->id) }}" class="btn-c btn-c-outline btn-c-sm">
                                    {{ ln('View', 'عرض') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">
            {{ $requests->links() }}
        </div>
    @else
        <div class="empty">
            <i class="fa-solid fa-folder-open"></i>
            <h3>{{ ln('No financing requests', 'لا توجد طلبات تمويل') }}</h3>
            <p>{{ ln('You have not submitted any financing request yet', 'لم تقم بتقديم أي طلب تمويل بعد') }}</p>
            <a href="{{ route('client.financing-request.create') }}" class="btn-c btn-c-primary">
                <i class="fa-solid fa-plus"></i> {{ ln('Submit New Request', 'تقديم طلب جديد') }}
            </a>
        </div>
    @endif
</div>
@endsection
