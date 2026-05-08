<div>
    {{-- Branch Indicator (clickable) --}}
    @if($currentBranch)
        <button wire:click="openModal" class="flex items-center gap-2 px-3 py-1 bg-[#e6d9cb] text-[#7a4025] rounded hover:bg-[#d19658] font-semibold text-sm shadow">
            <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
            <span>{{ $currentBranch->branch_name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </button>
    @else
        <button wire:click="openModal" class="flex items-center gap-2 px-3 py-1 bg-[#e6d9cb] text-[#7a4025] rounded hover:bg-[#d19658] font-semibold text-sm shadow">
            <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
            <span>Select Branch</span>
        </button>
    @endif

    {{-- Modal for branch selection --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
                <h2 class="text-xl font-bold text-[#7a4025] mb-4">Select a Branch</h2>
                <ul class="flex flex-col gap-3">
                    @foreach($branches as $branch)
                        <li>
                            <button wire:click="selectBranch({{ $branch->id }})" onclick="setTimeout(() => window.location.reload(), 300)" class="w-full text-left px-4 py-2 rounded border border-[#e6d9cb] hover:bg-[#e6d9cb] {{ $currentBranch && $currentBranch->id == $branch->id ? 'bg-[#e6d9cb] font-bold' : '' }}">
                                {{ $branch->branch_name }}
                                <span class="block text-xs text-gray-500">{{ $branch->branch_address }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
