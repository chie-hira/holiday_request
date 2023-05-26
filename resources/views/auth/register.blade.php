<x-app-layout>

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
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

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

            <!-- Department_id -->
            <div class="mt-4">
                <x-label for="group_id" :value="__('Group')" />

                <select name="group_id" id="gropu_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    @foreach ($group_categories as $group_category)
                        <option value="{{ $group_category->id }}"
                            @if ($group_category->id === (int) old('group_id')) selected @endif>
                            {{ $group_category->group_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Adoption_date -->
            <div class="mt-4">
                <x-label for="adoption_date" :value="__('Adoption')" />
                <x-input type="date" id="adoption_date" name="adoption_date" class="block mt-1 w-full" :value="old('adoption_date')" required/>
            </div>

            <!-- Birthday -->
            <div class="mt-4">
                <x-label for="birthday" :value="__('Birthday')" />
                <x-input type="number" id="birth_m" name="birth_m" min="1" max='12' class="mt-1 w-20" :value="old('birth_m')" required/>{{ __('月') }}
                <x-input type="number" id="birth_d" name="birth_d" min="1" max='31' class="mt-1 ml-2 w-20" :value="old('birth_m')" required/>{{ __('日') }}
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
    <div class="flex flex-col sm:justify-center items-center">
        <div class="w-full sm:max-w-md">
            <div class="mb-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('users.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </div>
    </x-guest-layout>
