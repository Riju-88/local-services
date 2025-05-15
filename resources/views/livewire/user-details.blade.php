<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">User Profile</h1>

    <div class="border p-4 rounded shadow">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Joined:</strong> {{ $user->created_at->format('F j, Y') }}</p>
    </div>
</div>
