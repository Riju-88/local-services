<div>
    <div 
        x-data="{
            show: @entangle('show'),
            init() {
                this.$watch('show', value => {
                    if (value) {
                        setTimeout(() => {
                            this.show = false;
                        }, {{ $duration }});
                    }
                });
            }
        }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-4 right-4 max-w-sm w-full z-50"
        style="display: none;"
    >
        <div @class([
            'rounded-lg p-4 shadow-lg border-l-4',
            'bg-green-50 border-green-500 dark:bg-green-900/30 dark:border-green-500' => $type === 'success',
            'bg-red-50 border-red-500 dark:bg-red-900/30 dark:border-red-500' => $type === 'error',
            'bg-yellow-50 border-yellow-500 dark:bg-yellow-900/30 dark:border-yellow-500' => $type === 'warning',
            'bg-blue-50 border-blue-500 dark:bg-blue-900/30 dark:border-blue-500' => $type === 'info'
        ])>
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($type === 'success')
                        <x-heroicon-o-check-circle class="h-6 w-6 text-green-500 dark:text-green-400" />
                    @elseif($type === 'error')
                        <x-heroicon-o-x-circle class="h-6 w-6 text-red-500 dark:text-red-400" />
                    @elseif($type === 'warning')
                        <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-yellow-500 dark:text-yellow-400" />
                    @else
                        <x-heroicon-o-information-circle class="h-6 w-6 text-blue-500 dark:text-blue-400" />
                    @endif
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium" @class([
                        'text-green-800 dark:text-green-100' => $type === 'success',
                        'text-red-800 dark:text-red-100' => $type === 'error',
                        'text-yellow-800 dark:text-yellow-100' => $type === 'warning',
                        'text-blue-800 dark:text-blue-100' => $type === 'info'
                    ])>
                        {{ $message }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <button 
                        @click="show = false" 
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors"
                    >
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
