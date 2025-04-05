<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'members' => UserResource::collection($this->whenLoaded('members')),
            'roles' => $this->whenLoaded('roles'),
            'invites' => TeamInviteResource::collection($this->whenLoaded('invites')), // Load invites
        ];
    }
}
