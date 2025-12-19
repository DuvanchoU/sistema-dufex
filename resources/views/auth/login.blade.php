@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">OrderRae</h1>
        <p class="text-gray-600 mt-2">Inicia sesión para continuar</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBB8A0] focus:border-[#CBB8A0]"
                required
            >
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBB8A0] focus:border-[#CBB8A0]"
                required
            >
        </div>

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    class="h-4 w-4 text-[#CBB8A0] rounded focus:ring-[#CBB8A0]"
                >
                <label for="remember" class="ml-2 text-sm text-gray-700">Recordarme</label>
            </div>
        </div>

        <button
            type="submit"
            class="w-full px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition shadow-sm">
            Iniciar Sesión
        </button>
    </form>
</div>
@endsection