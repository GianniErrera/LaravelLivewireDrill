<div>


    <div class="border border-b-gray-300 rounded-xl">

        @forelse ($events as $event)
        <div class="p-4 border-b border-b-gray-400 rounded-xl ml-2 mr-2' }}">
            <div class="flex flex-row justify-between">
                <div>
                    <p class="text-sm mb-3"> {{ $event->date }} </p>
                </div>
                <div>
                    <p class="text-sm mb-3"> {{ $event->eventDescription }} </p>
                </div>
                <div class="icon-container col-xs-12 col-sm-4 mr-2">
                    @if($event->isItRecurringYearly)
                        <svg class="w-4 text-gray-500 mr-4" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Page-1" stroke="currentColor" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g class="fill-current">
                                        <path d="M1,3.99508929 C1,2.8932319 1.8926228,2 2.99508929,2 L17.0049107,2 C18.1067681,2 19,2.8926228 19,3.99508929 L19,18.0049107 C19,19.1067681 18.1073772,20 17.0049107,20 L2.99508929,20 C1.8932319,20 1,19.1073772 1,18.0049107 L1,3.99508929 Z M3,6 L17,6 L17,18 L3,18 L3,6 Z M5,0 L7,0 L7,2 L5,2 L5,0 Z M13,0 L15,0 L15,2 L13,2 L13,0 Z M5,9 L7,9 L7,11 L5,11 L5,9 Z M5,13 L7,13 L7,15 L5,15 L5,13 Z M9,9 L11,9 L11,11 L9,11 L9,9 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z M13,9 L15,9 L15,11 L13,11 L13,9 Z M13,13 L15,13 L15,15 L13,15 L13,13 Z" id="Combined-Shape"></path>							</g>
                                </g>
                        </svg>
                    @endif
                </div>
            </div>

        </div>
        @empty
            <p class="p-4">No events yet</p>
        @endforelse


    </div>
</div>
