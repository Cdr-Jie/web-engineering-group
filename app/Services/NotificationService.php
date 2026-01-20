<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Admin;
use App\Models\User;

class NotificationService
{
    /**
     * Notify all admins about a new user registration.
     */
    public static function notifyAdminUserRegistration(User $user)
    {
        $admins = Admin::whereIn('role', ['admin', 'super_admin', 'moderator'])->with('user')->get();

        foreach ($admins as $admin) {
            // Only notify if admin has an associated user
            if ($admin->user_id) {
                Notification::create([
                    'user_id' => $admin->user_id,
                    'type' => 'user_registered',
                    'title' => 'New User Registration',
                    'message' => "{$user->name} ({$user->email}) has registered as a new user.",
                    'data' => ['user_id' => $user->id],
                ]);
            }
        }
    }

    /**
     * Notify all admins about a new event created.
     */
    public static function notifyAdminEventCreated(User $creator, $event)
    {
        $admins = Admin::whereIn('role', ['admin', 'super_admin', 'moderator'])->with('user')->get();

        foreach ($admins as $admin) {
            // Only notify if admin has an associated user
            if ($admin->user_id) {
                Notification::create([
                    'user_id' => $admin->user_id,
                    'type' => 'event_created',
                    'title' => 'New Event Created',
                    'message' => "{$creator->name} has created a new event: {$event->name}",
                    'data' => ['event_id' => $event->id],
                ]);
            }
        }
    }

    /**
     * Notify a user when they successfully register for an event.
     */
    public static function notifyUserEventRegistration(User $user, $event)
    {
        Notification::create([
            'user_id' => $user->id,
            'type' => 'registration_confirmed',
            'title' => 'Registration Confirmed',
            'message' => "You have successfully registered for {$event->name}!",
            'data' => ['event_id' => $event->id],
        ]);
    }

    /**
     * Notify event creator when someone registers for their event.
     */
    public static function notifyEventCreatorNewRegistration(User $participant, $event)
    {
        if ($event->user_id) {
            Notification::create([
                'user_id' => $event->user_id,
                'type' => 'new_participant',
                'title' => 'New Event Registration',
                'message' => "{$participant->name} has registered for your event: {$event->name}",
                'data' => ['event_id' => $event->id, 'participant_id' => $participant->id],
            ]);
        }
    }

    /**
     * Get unread notification count for a user.
     */
    public static function getUnreadCount(User $user)
    {
        return $user->notifications()->whereNull('read_at')->count();
    }

    /**
     * Mark all notifications as read for a user.
     */
    public static function markAllAsRead(User $user)
    {
        $user->notifications()->whereNull('read_at')->update(['read_at' => now()]);
    }

    /**
     * Notify event creator when their event is approved.
     */
    public static function notifyEventApproved(Admin $admin, $event)
    {
        if ($event->user_id) {
            Notification::create([
                'user_id' => $event->user_id,
                'type' => 'event_approved',
                'title' => 'Event Approved',
                'message' => "Your event '{$event->name}' has been approved and is now live!",
                'data' => ['event_id' => $event->id],
            ]);
        }
    }

    /**
     * Notify event creator when their event is rejected.
     */
    public static function notifyEventRejected(Admin $admin, $event)
    {
        if ($event->user_id) {
            Notification::create([
                'user_id' => $event->user_id,
                'type' => 'event_rejected',
                'title' => 'Event Rejected',
                'message' => "Your event '{$event->name}' has been rejected. Reason: {$event->rejection_reason}",
                'data' => ['event_id' => $event->id],
            ]);
        }
    }
}
