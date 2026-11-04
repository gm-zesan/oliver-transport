@extends('layouts.passenger')

@section('title', 'Profile Settings — Oliver Transport')

@section('hero_title', 'Profile & Security Settings')

@section('hero_meta')
    <span class="inline-flex items-center gap-1.5 bg-white/10 text-slate-200 border border-white/15 backdrop-blur-md px-2.5 py-1 rounded-xl">
        <svg class="h-3.5 w-3.5 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span>Manage your personal information, contact phone, and account credentials</span>
    </span>
@endsection

@section('passenger_content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <!-- Column 1: Profile Information Card -->
        <div class="rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-xs">
            <div class="mb-6 pb-4 border-b border-slate-100">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-[#16A34A] mb-1">
                    <span class="h-2 w-2 rounded-full bg-[#22C55E]"></span>
                    <span>Personal Details</span>
                </span>
                <h2 class="text-xl font-black text-slate-900 font-heading">
                    Profile Information
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Update your account display name, email address, and optional phone number.
                </p>
            </div>

            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Column 2: Password & Security Card -->
        <div class="rounded-3xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-xs">
            <div class="mb-6 pb-4 border-b border-slate-100">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-black uppercase tracking-wider text-slate-500 mb-1">
                    <svg class="h-3.5 w-3.5 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Security &amp; Credentials</span>
                </span>
                <h2 class="text-xl font-black text-slate-900 font-heading">
                    Update Password
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </div>

            @include('profile.partials.update-password-form')
        </div>

    </div>
@endsection
