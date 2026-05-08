<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileForm extends Component
{
    use WithFileUploads;

    public $firstname;
    public $lastname;
    public $email;
    public $avatar;
    public $new_avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
    }

    public function updatedNewAvatar()
    {
        $this->validate([
            'new_avatar' => 'image|max:10240',
        ]);
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        if ($this->new_avatar) {
            $path = $this->new_avatar->store('avatars', 'public');
            $user->avatar = $path;
        }
        $user->save();
        session()->flash('success', 'Profile updated successfully!');
    }

    public function updatePassword()
    {
        $user = Auth::user();
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }
        $user->password = Hash::make($this->new_password);
        $user->save();
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password updated successfully!');
    }

    public function editAddress($id)
    {
        // TODO: Implement address editing modal or inline form
    }

    public function deleteAddress($id)
    {
        $address = \App\Models\ShippingDetails::find($id);
        if ($address && $address->shipping_user == Auth::id()) {
            $address->delete();
            session()->flash('success', 'Address deleted successfully!');
        }
    }

    public function getAddressesProperty()
    {
        return \App\Models\ShippingDetails::where('shipping_user', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.profile-form', [
            'addresses' => $this->addresses,
        ]);
    }
}
