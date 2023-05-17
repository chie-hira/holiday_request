<x-app-layout>
<!-- Page Heading -->
    {{-- <header class="text-xs sm:text-sm bg-sky-50 shadow-md shadow-sky-500/50">
        <div class="flex max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('users.index') }}" class="text-sky-600 inline-flex mr-2 hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                        clip-rule="evenodd" />
                </svg>
                <div class="px-2">
                    ユーザー一覧
                </div>
            </a>
        </div>
    </header> --}}

    <x-auth-card>
        <x-slot name="logo">
            <div class="container px-5 mx-auto text-gray-600">
                <div class="flex flex-col text-center w-full">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ユーザー登録</h1>
                    <p class="mx-auto leading-relaxed text-base">
                        採用職員を登録してください。
                    </p>
                </div>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>

            <!-- Email Address -->
            {{-- <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div> --}}

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <!-- Employee -->
            <div class="mt-4">
                <x-label for="employee" :value="__('Employee')" />

                <x-input id="employee" class="block mt-1 w-full" type="number" name="employee" :value="old('employee')"
                    required autofocus />
            </div>

            <!-- Factory_id -->
            <div class="mt-4">
                <x-label for="factory_id" :value="__('Factory')" />

                <select name="factory_id" id="factory_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    @foreach ($factory_categories as $factory_category)
                        <option value="{{ $factory_category->id }}" @if ($factory_category->id === (int) old('factory_id')) selected @endif>
                            {{ $factory_category->factory_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department_id -->
            <div class="mt-4">
                <x-label for="department_id" :value="__('Department')" />

                <select name="department_id" id="department_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    @foreach ($department_categories as $department_category)
                        <option value="{{ $department_category->id }}"
                            @if ($department_category->id === (int) old('department_id')) selected @endif>
                            {{ $department_category->department_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> --}}

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    </x-guest-layout>
