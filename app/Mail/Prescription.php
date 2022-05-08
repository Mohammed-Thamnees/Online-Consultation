<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class Prescription extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'patient_name' => $this->appointment->patient->first_name.' '.$this->appointment->patient->last_name,
            'date' => $this->appointment->date,
            'doctor_name' => $this->appointment->doctor->doctordetails->first_name.' '.$this->appointment->doctor->doctordetails->last_name,
            'designation' => $this->appointment->doctor->designation,
            'id' => $this->appointment->id,
        ];
        $pdf = PDF::loadView('admin.mail.test', $data);
        return $this->view('admin.mail.prescription')
                    ->subject('Doctor Prescription')
                    ->attachData($pdf->output(), "prescription.pdf" , [
                        'mime' => 'application/pdf',
                    ]);
    }
}
