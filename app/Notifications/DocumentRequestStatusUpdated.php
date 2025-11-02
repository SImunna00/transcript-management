<?php

namespace App\Notifications;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentRequestStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $documentRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(DocumentRequest $documentRequest)
    {
        $this->documentRequest = $documentRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $type = ucfirst($this->documentRequest->document_type);
        $status = ucfirst($this->documentRequest->status);

        $message = (new MailMessage)
            ->subject("$type Request Status Updated")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your request for $type has been updated to: $status");

        if ($this->documentRequest->status === 'approved' && $this->documentRequest->pdf_path) {
            $message->line('Your document is now available for download.')
                ->action('Download Document', route('document-requests.download', $this->documentRequest->id));
        } elseif ($this->documentRequest->status === 'rejected') {
            $message->line('If you have any questions, please contact the admin office.');
        }

        return $message->line('Thank you for using our service.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'document_request_id' => $this->documentRequest->id,
            'document_type' => $this->documentRequest->document_type,
            'status' => $this->documentRequest->status
        ];
    }
}
