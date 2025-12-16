<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.app')]
#[Title('Edit Pengguna')]
class Edit extends Component
{
    public User $user;

    #[Rule('required|max:255')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    public string $password = '';

    #[Rule('required|in:admin,petugas,pegawai')]
    public string $role = 'pegawai';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('success', 'Pengguna berhasil diperbarui.');

        return redirect()->route('admin.user.index');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
