<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function __construct(private readonly CryptoService $cryptoService)
    {
        
    }

    public function create()
    {
        return view('customer.create');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'customers' => Customer::all(),
        ];

        return view('customer.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('createCustomer', [
            'id_data' => ['required', 'array'],
            'id_data.first_name' => ['required', 'string', 'max:50', 'min:3'],
            'id_data.last_name' => ['required', 'string', 'max:50', 'min:3'],
            'id_data.id' => ['required', 'string', 'max:11', 'min:11'],
            'id_data.serial_number' => ['required', 'string', 'max:255'],
            'id_data.birth_date' => ['required', 'date', 'before:today', 'date_format:Y-m-d'],
            'id_data.gender' => ['required','in:male,female'],
            'website' => ['required', 'url', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'id_file' => ['required', 'file', 'mimes:image,jpg,jpeg,png,bmp', 'max:10000'],
        ]);
        
        $encryptionKey = $this->cryptoService->generateEncryptionKey();
        $iv = $this->cryptoService->generateRandomIV();

        $encrypted =  $this->cryptoService->encrypt($validated['id_file']->get(), $encryptionKey, $iv);

        $name = $validated['id_file']->getClientOriginalName() . '.enc';

        Storage::disk('public')->put($name, $encrypted);

        $encryptedIdData = collect($validated['id_data'])->map(fn($value, $key) => $this->cryptoService->simpleEncrpyt($value))->toArray();

        $validated['id_data'] = $encryptedIdData;

        unset($validated['id_file']);

        $customer = Customer::create($validated);

        $customer->files()->create([
            'encryption_key' => $encryptionKey,
            'iv' => $iv,
            'key' => 'id_front',
            'value' => $name,
        ]);

        return redirect()->route('customers.index')->with('status', 'customer-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $files = $customer->files()->get()->map(fn($file) => [
            'key' => $file->key,
            'value' => $file->value,
            'data' => base64_encode($this->cryptoService->decrypt(Storage::disk('public')->get($file->value), $file->encryption_key, $file->iv))
        ]);

        return view('customer.show', ['customer' => $customer, 'files' => $files ]);
    }
     

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
