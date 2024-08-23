<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $allRoles = Role::all();

        $userRoleIds = UserRole::where('user_id', $this->id)->pluck('role_id')->toArray();

        $filteredRoles = $allRoles->filter(function ($role) use ($userRoleIds) {
            return in_array($role->id, $userRoleIds);
        });
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => RoleResource::collection($filteredRoles),
        ];
    }
}
