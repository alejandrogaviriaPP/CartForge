@if (session('success'))
    <div class="mb-6 bg-green-50/80 backdrop-blur-md border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 bg-red-50/80 backdrop-blur-md border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-medium">
        {{ session('error') }}
    </div>
@endif
