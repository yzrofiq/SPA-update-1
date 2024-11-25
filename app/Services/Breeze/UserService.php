<?php

namespace App\Services\Breeze;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Buat pengguna baru.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUser(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }

    /**
     * Temukan pengguna berdasarkan ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Perbarui informasi pengguna.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->findUserById($id);
        if ($user) {
            $user->name = $data['name'] ?? $user->name;
            $user->email = $data['email'] ?? $user->email;

            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();
            return $user;
        }
        return null;
    }

    /**
     * Hapus pengguna berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->findUserById($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}
