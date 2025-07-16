<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    public function all()
    {
        return Address::all();
    }

    public function find(Address $address)
    {
        return $address->load('user');
    }

    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(Address $address, array $data): Address
    {
        $address->update($data);
        return $address;
    }

    public function delete(Address $address): void
    {
        $address->delete();
    }
}