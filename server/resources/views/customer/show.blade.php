<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Show Customer
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                            <div>
                                <h6 style="font-weight: bold">Email</h6>
                                {{$customer->email}}
                            </div>
                            <div>
                                <h6 style="font-weight: bold">Company</h6>
                                {{$customer->company}}
                            </div>
                            <div>
                                <h6 style="font-weight: bold">Website</h6>
                                {{$customer->website}}
                            </div>
                            <div>
                                <h6 style="font-weight: bold">First Name:</h6>
                                {{$customer->id_data['first_name']}}
                            </div>
                            <div>
                                <h6 style="font-weight: bold">Last Name:</h6>
                                {{$customer->id_data['last_name']}}
                            </div>
                            <div>
                                <h6 style="font-weight: bold">ID:</h6>
                                {{$customer->id_data['id']}}
                            </div>

                            <div>
                            <h6 style="font-weight: bold">Gender:</h6>
                                {{$customer->id_data['gender']}}
                            </div>
                            
                            <div>
                            <h6 style="font-weight: bold">Birh Date:</h6>
                                {{$customer->id_data['birth_date']}}
                            </div>
                            <div>
                            <h6 style="font-weight: bold">Serial Number:</h6>
                                {{$customer->id_data['serial_number']}}
                            </div>
                    </section>
                    <section>
                        <div>
                            <h6 style="font-weight: bold">Fotoğraf :</h6>
                            <img src="data:image/jpeg;base64, {{$files[0]['data']}}"/>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
