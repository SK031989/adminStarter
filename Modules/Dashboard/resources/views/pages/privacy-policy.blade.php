@extends('dashboard::layouts.admin')

@section('title', 'Privacy Policy')

@section('content')
<div class="py-8 max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-xl">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Privacy Policy</h1>
                <p class="text-xs text-slate-400 font-medium">Last updated: July 1, 2026</p>
            </div>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
            This policy describes how {{ config('app.name') }} collects, uses, and protects your personal data.
        </p>
    </div>

    {{-- Content Sections --}}
    <div class="space-y-6">

        @php
        $sections = [
            ['icon' => 'database', 'color' => 'blue', 'title' => '1. Data We Collect', 'body' => 'We collect information you provide directly when creating an account, including your name, email address, and payment information. We also collect usage data such as page views, feature interactions, and system logs to improve our platform.'],
            ['icon' => 'settings', 'color' => 'purple', 'title' => '2. How We Use Your Data', 'body' => 'We use your data to provide and improve our services, send transactional emails, process payments, and communicate about updates. We do not sell your personal information to third parties.'],
            ['icon' => 'lock', 'color' => 'emerald', 'title' => '3. Data Security', 'body' => 'All data is encrypted in transit using TLS 1.3 and at rest using AES-256. We conduct regular security audits and follow industry best practices to protect your information from unauthorized access.'],
            ['icon' => 'users', 'color' => 'orange', 'title' => '4. Sharing Your Data', 'body' => 'We may share data with trusted third-party processors (e.g., payment gateways, email providers) strictly to deliver our services. All processors are GDPR-compliant and bound by data processing agreements.'],
            ['icon' => 'clock', 'color' => 'rose', 'title' => '5. Data Retention', 'body' => 'We retain your account data for as long as your account is active or as needed to provide services. You may request deletion of your account and associated data at any time by contacting support.'],
            ['icon' => 'check-circle', 'color' => 'indigo', 'title' => '6. Your Rights', 'body' => 'You have the right to access, correct, export, or delete your personal data. For GDPR-protected individuals, you also have the right to restrict processing and lodge complaints with supervisory authorities.'],
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

        {{-- Contact Box --}}
        <div class="bg-purple-50 dark:bg-purple-500/10 border border-purple-200 dark:border-purple-500/20 rounded-2xl p-6 flex items-start gap-4">
            <div class="p-2.5 bg-purple-100 dark:bg-purple-500/20 text-purple-600 rounded-xl shrink-0">
                <i data-lucide="mail" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-bold text-purple-900 dark:text-purple-300 text-sm mb-1">Questions about this policy?</h3>
                <p class="text-sm text-purple-700 dark:text-purple-400 leading-relaxed">
                    Contact our Data Protection Officer at <a href="mailto:privacy@saastarter.com" class="font-semibold underline">privacy@saastarter.com</a>.
                    We typically respond within 48 hours.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
