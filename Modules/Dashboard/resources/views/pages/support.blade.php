@extends('dashboard::layouts.admin')

@section('title', 'Support')

@section('content')
<div class="py-8 max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2.5 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 rounded-xl">
                <i data-lucide="life-buoy" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Support Center</h1>
                <p class="text-xs text-slate-400 font-medium">We're here to help · Avg. response time: 2 hours</p>
            </div>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
            Get help with your account, billing, integrations, and anything else. Choose a channel below.
        </p>
    </div>

    {{-- Contact Channels --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 text-center hover:border-purple-400 dark:hover:border-purple-500 transition group">
            <div class="mx-auto mb-4 p-3 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-2xl w-fit group-hover:scale-110 transition-transform">
                <i data-lucide="mail" class="w-6 h-6"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Email Support</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Send us a message and we'll get back to you within 2 business hours.</p>
            <a href="mailto:support@saastarter.com" class="inline-flex items-center gap-1.5 text-xs font-semibold text-purple-600 hover:text-purple-700 dark:text-purple-400 no-underline">
                support@saastarter.com
                <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition group">
            <div class="mx-auto mb-4 p-3 bg-blue-100 dark:bg-blue-500/10 text-blue-600 rounded-2xl w-fit group-hover:scale-110 transition-transform">
                <i data-lucide="message-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Live Chat</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Chat with our support team in real-time. Available Monday–Friday, 9am–6pm UTC.</p>
            <button class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                Start a chat
                <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 text-center hover:border-emerald-400 dark:hover:border-emerald-500 transition group">
            <div class="mx-auto mb-4 p-3 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 rounded-2xl w-fit group-hover:scale-110 transition-transform">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Documentation</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Browse our in-depth guides, API references, and step-by-step tutorials.</p>
            <a href="#" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 no-underline">
                View docs
                <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

    </div>

    {{-- FAQ Section --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-3">
            <i data-lucide="help-circle" class="w-4 h-4 text-purple-500"></i>
            <h2 class="font-bold text-slate-900 dark:text-white text-sm">Frequently Asked Questions</h2>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @php
            $faqs = [
                ['q' => 'How do I reset my password?', 'a' => 'Go to the Login page and click "Forgot Password". Enter your email and we\'ll send a reset link within a few minutes.'],
                ['q' => 'Can I change my billing plan mid-cycle?', 'a' => 'Yes. Upgrades are prorated immediately. Downgrades take effect at the start of the next billing cycle.'],
                ['q' => 'How do I export my data?', 'a' => 'Navigate to Settings → Account → Data Export. You can download all your data as a CSV or JSON file.'],
                ['q' => 'What payment methods are accepted?', 'a' => 'We accept all major credit cards (Visa, Mastercard, Amex), PayPal, and bank transfers for annual plans over $500.'],
                ['q' => 'How do I add team members?', 'a' => 'Go to Settings → Team and click "Invite Member". Enter their email and assign a role. They\'ll receive an invitation email.'],
                ['q' => 'Is there a free trial?', 'a' => 'Yes — every new account gets a 14-day free trial on the Growth Pro plan. No credit card required to start.'],
            ];
            @endphp

            @foreach($faqs as $faq)
            <div class="px-6 py-4 flex items-start gap-3">
                <div class="p-1.5 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-lg shrink-0 mt-0.5">
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white mb-0.5">{{ $faq['q'] }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Submit a Ticket --}}
    <div class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 text-white">
        <div class="flex items-start gap-4">
            <div class="p-2.5 bg-white/20 rounded-xl shrink-0">
                <i data-lucide="send" class="w-5 h-5"></i>
            </div>
            <div class="flex-grow">
                <h3 class="font-bold text-white text-sm mb-1">Can't find your answer?</h3>
                <p class="text-xs text-purple-100 mb-4 leading-relaxed">Submit a support ticket and our team will respond within 2 business hours. Include as much detail as possible to speed up resolution.</p>
                <a href="mailto:support@saastarter.com?subject=Support%20Request" class="inline-flex items-center gap-2 bg-white text-purple-700 hover:bg-purple-50 font-semibold text-xs px-4 py-2 rounded-xl no-underline transition">
                    <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                    Submit a Ticket
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
