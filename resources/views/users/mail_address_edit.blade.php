<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('users.partials.update-profile-information-form')
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-2xl w-full mx-auto mt-8">
            <div class="relative w-30 h-8 mb-2">
                <x-return-button class="px-8 absolute inset-y-0 right-0" href="{{ route('users.edit', $user) }}">
                    {{ __('戻　る') }}
                </x-return-button>
            </div>
            <div class="relative w-30 h-8">
                <x-back-home-button class="absolute inset-y-0 right-0" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
</x-app-layout>
