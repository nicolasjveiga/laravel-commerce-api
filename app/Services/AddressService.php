<?php

namespace App\Services;

use App\Models\Address;
use App\Repositories\AddressRepository;

class AddressService
{
    protected $addressRepo;

    public function __construct(AddressRepository $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function listAll()
    {
        return $this->addressRepo->all();
    }

    public function show(Address $address)
    {
        return $this->addressRepo->find($address);
    }

    public function create(array $data): Address
    {
        return $this->addressRepo->create($data); 
    }

    public function update(Address $address, array $data): Address
    {
        return $this->addressRepo->update($address, $data);
    }

    public function delete(Address $address): Address
    {
        $this->addressRepo->delete($address);
        return $address;
    }
}