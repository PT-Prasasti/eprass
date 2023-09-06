<?php

namespace App\Notifications;

use App\Models\VisitReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewVisitReportNotification extends Notification
{
    use Queueable;

    protected $visitReport;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(VisitReport $visitReport)
    {
        $this->visitReport = $visitReport;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'A new visit report for :visit has been added by :sales',
            'report_uuid' => $this->visitReport->uuid,
            'visit_id' => $this->visitReport->visit_schedule_id,
            'sales_id' => $this->visitReport->sales_id,
        ];
    }
}
