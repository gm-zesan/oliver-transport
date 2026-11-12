<!-- Driver / Non-Passenger Role Restriction Modal -->
<div id="role-restriction-modal" 
     class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/75 backdrop-blur-sm transition-opacity duration-200" 
     aria-labelledby="role-restriction-title" 
     role="dialog" 
     aria-modal="true">
    
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Card Container -->
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 p-6 sm:p-8 animate-in fade-in zoom-in-95 duration-150">
            
            <!-- Close 'X' Button -->
            <button type="button" 
                    onclick="closeRoleRestrictionModal()" 
                    class="absolute top-5 right-5 h-9 w-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Icon Header -->
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 border border-amber-200 text-amber-600 mb-4 shadow-xs">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Title & Explanatory Body -->
            <div class="text-center space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    <span>{{ __('Driver Account Active') }}</span>
                </span>
                
                <h3 id="role-restriction-title" class="text-xl sm:text-2xl font-black font-heading text-slate-900 tracking-tight">
                    {{ __('Shuttle Booking Unavailable') }}
                </h3>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-md mx-auto pt-1">
                    {{ __('You are currently logged in as a :role. Shuttle seat reservations are exclusively reserved for :passenger accounts.', ['role' => __('Driver (Rider)'), 'passenger' => __('Passenger')]) }}
                </p>

                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    {{ __('To reserve a seat for intercity travel, please sign in with a passenger account.') }}
                </p>
            </div>

            <!-- Action Buttons Grid -->
            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                <!-- Sign in as Passenger / Switch Account -->
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl bg-slate-900 hover:bg-[#22C55E] text-white px-5 py-2.5 text-xs sm:text-sm font-bold shadow-xs transition cursor-pointer">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>{{ __('Sign in as Passenger') }}</span>
                    </button>
                </form>

                <!-- Open Driver Panel -->
                @auth
                    @if(auth()->user()->isRider())
                        <a href="{{ route('rider.dashboard') }}" 
                           class="w-full sm:w-auto inline-flex min-h-[46px] items-center justify-center gap-2 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 px-5 py-2.5 text-xs sm:text-sm font-bold transition">
                            <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span>{{ __('Go to Driver Panel') }}</span>
                        </a>
                    @endif
                @endauth
            </div>

        </div>
    </div>
</div>

