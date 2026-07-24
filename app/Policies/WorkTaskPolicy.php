<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkTask;
use App\Services\Security\CompanyScopeService;
use App\Domain\Collaboration\TaskLifecycle;

class WorkTaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('collaboration.view')
            || $user->hasPermission('collaboration.manage')
            || $user->hasPermission('employee.self_service');
    }

    public function view(User $user, WorkTask $workTask): bool
    {
        if (! $this->viewAny($user) || ! $this->sameCompany($user, $workTask)) {
            return false;
        }

        if ($user->hasPermission('collaboration.view') || $user->hasPermission('collaboration.manage')) {
            return true;
        }

        return $workTask->created_by_user_id === $user->id || $workTask->assigned_to_user_id === $user->id;
    }

    public function create(User $user): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        return $user->hasPermission('collaboration.manage') || $user->hasPermission('employee.self_service');
    }

    public function assign(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        return $user->hasPermission('collaboration.manage') && $this->sameCompany($user, $workTask) && $workTask->status !== 'completed';
    }

    public function requestTransfer(User $user, WorkTask $workTask): bool
    {
        return $this->updateStatus($user, $workTask);
    }

    public function updateStatus(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        if (! $this->sameCompany($user, $workTask) || in_array($workTask->status, TaskLifecycle::terminalStatuses(), true)) {
            return false;
        }

        return $user->hasPermission('collaboration.manage')
            || $workTask->created_by_user_id === $user->id
            || $workTask->assigned_to_user_id === $user->id;
    }

    public function updateDetails(User $user, WorkTask $workTask): bool
    {
        return $this->updateStatus($user, $workTask);
    }

    public function comment(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        return $this->view($user, $workTask) && ! in_array($workTask->status, ['rejected', 'cancelled'], true);
    }

    public function updateChecklist(User $user, WorkTask $workTask): bool
    {
        return $this->updateStatus($user, $workTask);
    }

    public function manageSubtasks(User $user, WorkTask $workTask): bool
    {
        return $this->updateStatus($user, $workTask);
    }

    public function logTime(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        return $this->view($user, $workTask) && ! in_array($workTask->status, TaskLifecycle::terminalStatuses(), true);
    }

    public function watch(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        return $this->view($user, $workTask) && $workTask->status !== 'cancelled';
    }

    public function archive(User $user, WorkTask $workTask): bool
    {
        if ($this->isReadOnly($user)) {
            return false;
        }

        if (! $this->sameCompany($user, $workTask)) {
            return false;
        }

        return $user->hasPermission('collaboration.manage')
            || $workTask->created_by_user_id === $user->id
            || $workTask->assigned_to_user_id === $user->id;
    }

    public function approveCompletion(User $user, WorkTask $workTask): bool
    {
        return ! $this->isReadOnly($user)
            && $this->sameCompany($user, $workTask)
            && $user->hasPermission('collaboration.manage');
    }

    public function reopen(User $user, WorkTask $workTask): bool
    {
        return $this->approveCompletion($user, $workTask) && $workTask->status === 'rejected';
    }

    private function sameCompany(User $user, WorkTask $workTask): bool
    {
        return app(CompanyScopeService::class)->allows($user, $workTask->company_id);
    }

    private function isReadOnly(User $user): bool
    {
        return $user->role?->scope_level === 'readonly';
    }
}
