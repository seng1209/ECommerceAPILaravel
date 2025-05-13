<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
//            'user_id' => $this->user_id,
//            'role_id' => $this->role_id,
            'user' => new UserResource($this->user),
            'role' => new RoleResource($this->role),
        ];
    }
}
