<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $addresses = Address::with('user')->get();

        return response()->json($addresses);
    }

    public function show(Address $address)
    {
        $address->load('user');

        return response()->json($address);
    }

    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();

        $address = $this->addressService->createAddress($validated);

        return response()->json($address, 201);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $validated = $request->validated();

        $address = $this->addressService->updateAddress($address, $validated);
    
        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $this->addressService->deleteAddress($address);

        return response()->json(null, 204);
    }
}
