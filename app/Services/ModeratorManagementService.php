<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class ModeratorManagementService
{
    /**
     * @return LengthAwarePaginator<User>
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with(['roles' => fn ($query) => $query->select(['id', 'name', 'guard_name'])])
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * @param array{name: string, email: string, password: string, role: string} $data
     */
    public function store(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $role = Role::findOrCreate($data['role'], 'web');
            $user->assignRole($role);

            return $user;
        });
    }

    /**
     * @param array{name: string, email: string, password?: string|null, role: string} $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $fields = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (! empty($data['password'])) {
                $fields['password'] = Hash::make($data['password']);
            }

            $user->update($fields);

            $role = Role::findOrCreate($data['role'], 'web');
            $user->syncRoles([$role]);

            return $user;
        });
    }

    /**
     * @throws ValidationException
     */
    public function delete(User $user, User $currentUser): void
    {
        if ($user->id === $currentUser->id) {
            throw ValidationException::withMessages([
                'error' => 'لا يمكنك حذف حسابك الشخصي الذي تستخدمه حالياً.',
            ]);
        }

        if ($user->email === 'admin@intok.com' || $user->id === 1) {
            throw ValidationException::withMessages([
                'error' => 'لا يمكن حذف حساب المدير العام الأساسي للنظام.',
            ]);
        }

        DB::transaction(function () use ($user): void {
            $user->roles()->detach();
            $user->delete();
        });
    }
}

