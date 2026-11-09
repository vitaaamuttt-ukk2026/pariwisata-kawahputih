@extends('layouts.panel')
@section('title', 'Test Upload')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Test Upload File</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.test-upload.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih File:</label>
            <input type="file" name="foto" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Upload Test
        </button>
    </form>
    
    <div class="mt-8 p-4 bg-gray-100 rounded">
        <h3 class="font-bold mb-2">Debug Info:</h3>
        <ul class="text-sm">
            <li>Form method: POST</li>
            <li>Form enctype: multipart/form-data</li>
            <li>Input name: foto</li>
            <li>Destination: public/hero/</li>
        </ul>
    </div>
</div>
@endsection