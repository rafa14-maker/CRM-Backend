<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice_terms;
    protected $package_terms;
    protected $bank_information;
    protected $lead_fetch_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice_terms = $invoice->invoice_terms_and_conditions;
        $this->package_terms = $invoice->package_terms_and_conditions;
        $this->bank_information = $invoice->bank_information;
        $this->lead_fetch_url = $invoice->lead_fetch_url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invoice Mail',
        );
    }

    
    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.invoice.index',
            with: [
                'invoice_terms' => $this->invoice_terms,
                'package_terms' => $this->package_terms,
                'bank_information' => $this->bank_information,
                'lead_fetch_url' => $this->lead_fetch_url
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
