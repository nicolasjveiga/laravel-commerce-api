<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Services\AddressService;
use App\Http\Resources\AddressResource;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Address::class);

        $user = $request->user();

        $addresses = $this->addressService->listAll($user);

        return AddressResource::collection($addresses);
    }

    public function show(Address $address)
    {
        $this->authorize('view', $address);
        
        $address = $this->addressService->show($address);

        return new AddressResource($address);
    }

    public function store(StoreAddressRequest $request)
    {
        $this->authorize('create', Address::class);

        $validated = $request->validated();

        $address = $this->addressService->create($validated);
        
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);
        
        $validated = $request->validated();

        $address = $this->addressService->update($address, $validated);
        
        return new AddressResource($address);
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $this->addressService->delete($address);
        
        return response()->json(null, 204);
    }
}
