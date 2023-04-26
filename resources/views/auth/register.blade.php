<x-app-layout>

    <x-auth-card>
        <x-slot name="logo">
            {{-- <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a> --}}

            <div class="container px-5 pt-24 mx-auto text-gray-600 bg-gray-100">
                <div class="flex flex-col text-center w-full">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">メンバー登録</h1>
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
