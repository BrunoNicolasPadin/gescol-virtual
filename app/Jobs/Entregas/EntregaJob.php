<?php

namespace App\Jobs\Entregas;

use App\Mail\Entregas\EntregaCalificada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EntregaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entregaInfo;
    protected $alumno;

    public function __construct($alumno, $entregaInfo)
    {
        $this->alumno = $alumno;
        $this->entregaInfo = $entregaInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->alumno->rolUser->user->email)
            ->send(new EntregaCalificada($this->entregaInfo));
    }
}
