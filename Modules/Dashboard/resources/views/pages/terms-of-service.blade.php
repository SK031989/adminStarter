@extends('dashboard::layouts.admin')

@section('title', 'Terms of Service')

@section('content')
<div class="py-8 max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-blue-100 dark:bg-blue-500/10 text-blue-600 rounded-xl">
                <i data-lucide="scroll-text" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Terms of Service</h1>
                <p class="text-xs text-slate-400 font-medium">Effective: July 1, 2026 · Version 2.1</p>
            </div>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
            By using {{ config('app.name') }}, you agree to these terms. Please read them carefully.
        </p>
    </div>

    {{-- Content Sections --}}
    <div class="space-y-6">

        @php
        $sections = [
            ['icon' => 'file-text', 'color' => 'blue', 'title' => '1. Acceptance of Terms', 'body' => 'By accessing or using our platform, you confirm that you are at least 18 years old and agree to be bound by these Terms of Service. If you do not agree, please discontinue use immediately.'],
            ['icon' => 'credit-card', 'color' => 'purple', 'title' => '2. Subscription & Billing', 'body' => 'Subscriptions are billed monthly or annually in advance. All fees are non-refundable except as required by law. We reserve the right to change pricing with 30-day advance notice.'],
            ['icon' => 'shield', 'color' => 'emerald', 'title' => '3. Acceptable Use', 'body' => 'You may not use the platform to engage in illegal activity, distribute malware, spam, or infringe intellectual property rights. Accounts violating these rules may be suspended without notice.'],
            ['icon' => 'copyright', 'color' => 'orange', 'title' => '4. Intellectual Property', 'body' => 'All platform code, design, content, and trademarks are owned by SaaS Starter Inc. Your content remains yours, but you grant us a license to host and display it as necessary to provide the service.'],
            ['icon' => 'alert-triangle', 'color' => 'rose', 'title' => '5. Limitation of Liability', 'body' => 'To the maximum extent permitted by law, SaaS Starter shall not be liable for indirect, incidental, or consequential damages. Our total liability to you shall not exceed the fees paid in the last 3 months.'],
            ['icon' => 'refresh-cw', 'color' => 'indigo', 'title' => '6. Changes to Terms', 'body' => 'We may update these terms periodically. We will notify you via email or in-app notification at least 14 days before material changes take effect. Continued use constitutes acceptance.'],
        ];
        @endphp

        @foreach($sections as $s)
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6">
            <div class="flex items-start gap-4">
                <div class="p-2.5 bg-{{ $s['color'] }}-100 dark:bg-{{ $s['color'] }}-500/10 text-{{ $s['color'] }}-600 rounded-xl shrink-0 mt-0.5">
                    <i data-lucide="{{ $s['icon'] }}" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="font-bold text-slate-900 dark:text-white text-sm mb-2">{{ $s['title'] }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $s['body'] }}</p>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Agreement Box --}}
        <div class="bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 rounded-2xl p-6 flex items-start gap-4">
            <div class="p-2.5 bg-blue-100 dark:bg-blue-500/20 text-blue-600 rounded-xl shrink-0">
                <i data-lucide="info" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-bold text-blue-900 dark:text-blue-300 text-sm mb-1">Legal inquiries</h3>
                <p class="text-sm text-blue-700 dark:text-blue-400 leading-relaxed">
                    For legal questions, contact us at <a href="mailto:legal@saastarter.com" class="font-semibold underline">legal@saastarter.com</a>
                    or by mail at SaaS Starter Inc., 123 Cloud Avenue, San Francisco, CA 94107.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
