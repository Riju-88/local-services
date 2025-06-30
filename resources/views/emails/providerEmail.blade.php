<div>
<h1>Hi {{ $provider->user->name }},</h1>

<p>Your provider <strong>{{ $provider->business_name }}</strong> has been successfully created!</p>

<p><strong>Business Description:</strong> {{ $provider->description }}</p>
<p><strong>Phone:</strong> {{ $provider->phone }}</p>
<p><strong>Email:</strong> {{ $provider->email }}</p>
<p><strong>Address:</strong> {{ $provider->address }}, {{ $provider->area }} – {{ $provider->pincode }}</p>

@if ($provider->contact_person_name)
    <p><strong>Contact Person:</strong> {{ $provider->contact_person_name }} ({{ $provider->contact_person_role }})</p>
    <p><strong>Contact Phone:</strong> {{ $provider->contact_person_phone }}</p>
@endif

<p>We’re thrilled to have your services listed on our platform!</p>

<p>Best regards,</p>
<p>The {{ config('app.name') }} Team</p>
</div>