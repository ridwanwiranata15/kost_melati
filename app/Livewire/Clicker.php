<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Clicker extends Component
{
    public $username = "testuser";
    public $name;
    public $email;
    public $password;
    public function createNewUser(){
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);
    }
    public function handleClick(){
        dump("click");
    }
    public function render()
    {
        $title = "Tests";
        $users = User::all();
        return view('livewire.clicker', [
            "title" => $title,
            'users' => $users

        ]);
    }

}
