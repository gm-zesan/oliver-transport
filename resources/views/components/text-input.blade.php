@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full min-h-[48px] rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-base text-slate-900 placeholder-slate-400 shadow-xs focus:border-[#22C55E] focus:outline-none focus:ring-2 focus:ring-[#22C55E] disabled:bg-slate-100 disabled:cursor-not-allowed']) }}>
