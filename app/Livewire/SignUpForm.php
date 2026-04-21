<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SignUpForm extends Component
{
    public $fname = '';
    public $lname = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showWelcomeModal = false;
    public $isLoading = false;

    protected $rules = [
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    public function register()
    {
        $this->isLoading = true;
        $this->validate();

        $user = User::create([
            'firstname' => $this->fname,
            'lastname' => $this->lname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        $this->showWelcomeModal = true;
        $this->isLoading = false;
    }

    public function redirectToHome()
    {
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.sign-up-form');
    }
}
