<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Customers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <table class="table-auto">
                        <thead>
                            <tr>
                            <th>id</th>
                            <th>email</th>
                            <th>website</th>
                            <th>company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->website}}</td>
                                    <td>{{ $customer->company }}</td>
                                    <td><a href="{{ route('customers.show',['customer'=> $customer->id])}}"> detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
