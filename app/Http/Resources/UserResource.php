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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar_url' => $this->avatarUrl(),
            'two_factor_enabled' => $this->hasEnabledTwoFactorAuthentication(),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'current_team' => TeamResource::make($this->whenLoaded('currentTeam')),
            'roles' => $this->whenLoaded('roles'),
            'permissions' => [
                'update_team' => $request->user()->can('update team'),//calls the permission using can() not the policy
                'leave_team' => $request->user()->can('leave'),
                'view_team_members' => $request->user()->can('view team members'),
                'remove_team_members' => $request->user()->can('remove team members'),
                'invite_to_team' => $request->user()->can('invite to team'),
                'revoke_invitation' => $request->user()->can('revoke invitation'),
                'change_member_roles' => $request->user()->can('change member roles'),
                'change_and_remove_members_and_roles' => $request->user()->canany(['change member roles', 'remove team members'])
            ],

        ];
    }
}
