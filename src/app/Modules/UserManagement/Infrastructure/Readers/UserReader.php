<?php

namespace App\Modules\UserManagement\Infrastructure\Readers;

use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Modules\UserManagement\Application\Responses\UserAllResponse;
use App\Modules\UserManagement\Application\Responses\UserByIdResponse;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Domain\UserRole;
use App\Shared\Paginator\PaginatedResult;

class UserReader implements UserReaderInterface
{
    public function all(?string $keyword, ?int $role_id): PaginatedResult
    {
        $query = User::query()
            ->with('role:id,name', 'department:id,name')
            ->orderByDesc('created_at');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%$keyword%")
                    ->orWhere('last_name', 'like', "%$keyword%");
            });
        }

        if (!empty($role_id)) {
            $query->where('role_id', $role_id);
        }

        $paginator = $query->paginate(20, [
            'id',
            'first_name',
            'last_name',
            'email',
            'role_id',
            'department_id'
        ]);

        $items = $paginator->getCollection()
            ->map(fn($user) => new UserAllResponse(
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->email ?? '[Trống]',
                $user->role->name,
                $user->department->name ?? ''
            ))
            ->toArray();

        return new PaginatedResult(
            $items,
            $paginator->currentPage(),
            $paginator->perPage(),
            $paginator->total(),
            $paginator->lastPage()
        );
    }

    public function allStaffs(?string $keyword, int $role_id = UserRole::ROLE_STAFF): PaginatedResult
    {
        return $this->all($keyword, $role_id);
    }

    public function findById(string $id): UserByIdResponse
    {
        $user = User::query()
            ->select(
                'id',
                'first_name',
                'last_name',
                'email',
                'role_id',
                'department_id'
            )
            ->where('id', $id)
            ->first();

        return new UserByIdResponse(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->email ?? '',
            $user->role_id,
            $user->department_id ?? ''
        );
    }

    public function count(): int
    {
        return User::count();
    }

    public function countByRoleId(int $role_id): int
    {
        return User::where('role_id', $role_id)->count();
    }
}
