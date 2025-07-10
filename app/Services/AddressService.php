<?php

namespace App\Services;

use App\Models\Address;

class AddressService
{
    public function createAddress(array $data): Address
    {
        return Address::create($data); 
    }

    public function updateAddress(Address $address, array $data): Address
    {
        $address->update($data);

        return $address;
    }

    public function deleteAddress(Address $address): Address
    {
        $address->delete();
        
        return $address;
    }
}