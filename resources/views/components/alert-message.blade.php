@if(session()->has('error'))
<div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
    {{ session()->get('error') }}
</div>
@endif
@if(session()->has('success'))
<div class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700 mb-3" role="alert">
    {{ session()->get('success') }}
</div>
@endif
