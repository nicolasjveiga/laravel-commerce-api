<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;
use App\Repositories\AddressRepository;

class AddressService
{
    protected $addressRepo;

    public function __construct(AddressRepository $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function listAll(User $user)
    {
        if($user->isAdmin()){
            return $this->addressRepo->all();
        }

        return $this->addressRepo->listByUser($user);
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

    public function delete(Address $address): void
    {
        $this->addressRepo->delete($address);
    }
}