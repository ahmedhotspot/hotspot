@extends('layouts.admin')

@section('page_title', $isRtl ? 'الرسائل' : 'Contact Messages')

@section('content')
<div class="admin-card">
    <div class="card-head">
        <h2>{{ $isRtl ? 'الرسائل الواردة' : 'Contact Messages' }}</h2>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>{{ $isRtl ? 'الاسم' : 'Name' }}</th>
            <th>{{ $isRtl ? 'البريد' : 'Email' }}</th>
            <th>{{ $isRtl ? 'الموضوع' : 'Subject' }}</th>
            <th>{{ $isRtl ? 'الحالة' : 'Status' }}</th>
            <th>{{ $isRtl ? 'التاريخ' : 'Date' }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($contacts as $contact)
            <tr>
                <td><strong>{{ $contact->name }}</strong></td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->subject }}</td>
                <td>
                    <span class="badge-pill {{ $contact->status === 'new' ? 'badge-success' : '' }}">{{ $contact->status }}</span>
                </td>
                <td>{{ $contact->created_at?->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;" onsubmit="return confirm('{{ $isRtl ? 'تأكيد الحذف؟' : 'Confirm delete?' }}')">
                        @csrf @method('DELETE')
                        <button class="btn-admin btn-admin-danger btn-admin-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:2rem;">{{ $isRtl ? 'لا توجد رسائل' : 'No messages' }}</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $contacts->links() }}</div>
</div>
@endsection
