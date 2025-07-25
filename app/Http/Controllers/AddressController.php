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
        $this->authorize('viewAny', Address::class);
        return response()->json($this->addressService->listAll());
    }

    public function myAddresses(Request $request){
        $user = $request->user();
        $addresses = $this->addressService->listByUser($user);
        return response()->json($addresses);
    }

    public function show(Address $address)
    {
        $this->authorize('view', $address);
        return response()->json($this->addressService->show($address));
    }

    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->create($request->validated());
        return response()->json($address, 201);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);
        $address = $this->addressService->update($address, $request->validated());
        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $this->addressService->delete($address);
        return response()->json(null, 204);
    }
}
