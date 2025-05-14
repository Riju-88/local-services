<div class="space-y-4">
    @foreach ($users as $user)
        <div class="bg-gradient-to-r from-indigo-400 to-indigo-700 text-white p-4 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center text-center sm:text-left">
                <!-- Name -->
                <div class="text-2xl font-semibold">
                    {{ $user->name }}
                </div>

                <!-- Email -->
                <div class="text-xl opacity-80">
                    {{ $user->email }}
                </div>

                <!-- Roles -->
                <div class="text-base font-medium sm:text-right text-lg">
                    <span class="text-indigo-200">Roles: </span>
                    <span>{{ $user->getRoleNames()->join(', ') }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
