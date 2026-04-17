<footer class="bg-white lg:grid lg:grid-cols-5 dark:bg-gray-900 border-t-8 border-[#e6d9cb]">
  <div class="relative block h-32 lg:col-span-2 lg:h-full">
    <img src="{{ asset($footer->footer_image) }}" alt="" class="absolute inset-0 h-full w-full object-cover">
  </div>

  <div class="px-4 pt-16 pb-4 sm:px-6 lg:col-span-3 lg:px-8 bg-[#7a4025]">
    <div class="grid grid-cols-1 md:grid-cols-3">
      <div class="flex flex-col col-span-1">
        <span class="text-lg font-semibold text-white">Visit our physical stores</span>
        <p class="mt-4 text-sm text-gray-300">
          {{ $footer->contact_info }}
        </p>
      </div>
      {{-- Branch List --}}
      <div class="overflow-x-auto mb-8 col-span-1 md:col-span-2">
        <table class="min-w-full text-left text-white text-sm border-collapse">
          <thead>
            <tr>
              <th class="px-2 py-1 font-semibold">Branch Name</th>
              <th class="px-2 py-1 font-semibold">Address</th>
              <th class="px-2 py-1 font-semibold">Contact</th>
              <th class="px-2 py-1 font-semibold">Map</th>
            </tr>
          </thead>
          <tbody>
            @foreach($branches as $branch)
              <tr>
                <td class="px-2 py-1">{{ $branch->branch_name }}</td>
                <td class="px-2 py-1">
                  @php
                    $address = $branch->branch_address;
                    $truncated = mb_strimwidth($address, 0, 50);
                  @endphp
                  <span>
                    <span class="truncated-address">{{ $truncated }}@if(mb_strlen($address) > 50)<a href="#" class="text-blue-200 underline ml-1 show-full-address" onclick="event.preventDefault(); this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='inline-block';">...</a>@endif</span>
                    @if(mb_strlen($address) > 50)
                      <span style="display:none; max-width: 250px; word-break: break-word; white-space: pre-line;" class="full-address">{{ $address }}</span>
                    @endif
                  </span>
                </td>
                <td class="px-2 py-1">{{ $branch->branch_contact ?? '' }}</td>
                <td class="px-2 py-1">
                  @if(!empty($branch->branch_mapLink))
                    <a href="{{ $branch->branch_mapLink }}" target="_blank" rel="noopener" class="inline-block text-white hover:text-blue-300">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                      </svg>
                    </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    

    <div class="mt-4 border-t border-gray-100 pt-4 dark:border-gray-800">
      <div class="sm:flex sm:items-center sm:justify-between">
        <ul class="flex flex-wrap gap-4 text-xs">
          
        </ul>

        <p class="mt-8 text-xs text-gray-500 sm:mt-0 dark:text-gray-400">
          © 2026. LadyG ArtsnCrafts. All rights reserved.
        </p>
      </div>
    </div>
  </div>
</footer>