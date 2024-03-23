<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create Customer
        </h2>
    </x-slot>


            <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Create customer
        </h2>
    </header>

    <form method="post" enctype="multipart/form-data" action="{{ route('customers.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="customer_email" :value="__('E-mail')" />
            <x-text-input id="customer_email" name="email" type="text" class="mt-1 block w-full" autocomplete="email" />
            <x-input-error :messages="$errors->createCustomer->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_company" :value="__('Company')" />
            <x-text-input id="customer_company" name="company" type="text" class="mt-1 block w-full" autocomplete="company" />
            <x-input-error :messages="$errors->createCustomer->get('company')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_website" :value="__('Website')" />
            <x-text-input id="customer_website" name="website" type="text" class="mt-1 block w-full"  autocomplete="website" />
            <x-input-error :messages="$errors->createCustomer->get('website')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="id_data[first_name]" type="text" class="mt-1 block w-full" autocomplete="first_name" />
            <x-input-error :messages="$errors->createCustomer->get('id_data.first_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="id_data[last_name]" type="text" class="mt-1 block w-full" autocomplete="last_name" />
            <x-input-error :messages="$errors->createCustomer->get('id_data.last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_id" :value="__('Identity Number')" />
            <x-text-input id="customer_id" maxlength="11" minlength="11" name="id_data[id]" type="text" class="mt-1 block w-full" autocomplete="id" />
            <x-input-error :messages="$errors->createCustomer->get('id_data.id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_serial_number" :value="__('Serial Number')" />
            <x-text-input id="customer_serial_number" name="id_data[serial_number]" type="text" class="mt-1 block w-full" autocomplete="serial_number" />
            <x-input-error :messages="$errors->createCustomer->get('id_data.serial_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_gender" :value="__('Gender')" />
            <input type="radio" name="id_data[gender]" value="male"> Male
            <input type="radio" name="id_data[gender]" value="female"> Female
            <x-input-error :messages="$errors->createCustomer->get('id_data.gender')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_birth_date" :value="__('Birth Date')" />
            <x-text-input id="customer_birth_date" name="id_data[birth_date]" type="date" class="mt-1 block w-full" autocomplete="birth_date" />
            <x-input-error :messages="$errors->createCustomer->get('id_data.birth_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="customer_id_file" :value="__('Identity File')" />
            <x-text-input id="customer_id_file" name="id_file" type="file" class="mt-1 block w-full" autocomplete="id_file" />
            <x-input-error :messages="$errors->createCustomer->get('id_file')" class="mt-2" />
        </div>
     

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
                </div>
            </div>

            
        </div>
    </div>
    </div>
</x-app-layout>
