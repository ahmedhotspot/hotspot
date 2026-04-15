@extends('layouts.client')

@include('client.financing-request._home_theme')

@section('title', ln('Choose Offer', 'اختر العرض'))
@section('page_title', ln('Choose Your Financing Offer', 'اختر عرض التمويل المناسب'))

@section('content')
<div class="client-card">
    <div class="card-head">
        <h2>{{ ln('Choose Your Financing Offer', 'اختر عرض التمويل المناسب') }}</h2>
    </div>

    <div class="alert alert-success">
        {{ ln('Payment completed successfully. You can now choose an offer.', 'تم الدفع بنجاح. يمكنك الآن اختيار العرض.') }}
    </div>

    <form method="POST" action="{{ route('client.financing-request.select-offer', $request->id) }}">
        @csrf
        <div style="overflow-x:auto;">
            <table class="client-table">
                <thead>
                    <tr>
                        <th>{{ ln('Select', 'اختر') }}</th>
                        <th>{{ ln('Bank', 'البنك') }}</th>
                        <th>{{ ln('Monthly Installment', 'القسط الشهري') }}</th>
                        <th>{{ ln('Financing Amount', 'مبلغ التمويل') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                        <tr>
                            <td><input type="radio" name="selected_offer_id" value="{{ $offer['id'] }}" required></td>
                            <td>{{ $offer['bank'] ?? '-' }}</td>
                            <td>{{ $offer['monthly'] ?? '-' }}</td>
                            <td>{{ $offer['amount'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; color:var(--c-muted); padding:2rem;">
                                {{ ln('No offers available yet.', 'لا توجد عروض متاحة حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($offers ?? []))
            <div style="margin-top:1rem; text-align:end;">
                <button type="submit" class="btn-c btn-c-primary">{{ ln('Select Offer', 'اختيار العرض') }}</button>
            </div>
        @endif
    </form>
</div>
@endsection
