<?php

namespace App\Listeners;

use App\Mail\SeriesCreated;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SeriesCreated as SeriesCreatedEvent;

// implementando o envio de forma assíncrona 
class EmailUsersAboutSeriesCreated implements ShouldQueue 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SeriesCreatedEvent $event)
    {
        $userList = User::all();
        
        foreach($userList as $index => $user){

            $email = new SeriesCreated(
                $event->seriesName,
                $event->seriesId,
                $event->seriesSeasonsQty,
                $event->seriesEpisodesPerSeason,
            );

            // Mail::to($user)->send($email);            
            // Colocando o e-mail em uma fila de e-mails para que não há demora para o usuário
            // Mail::to($user)->queue($email);
            // Espera um tempo para ser processado no envio de e-mail
            // Exemplo utilizado pois o mailtrap só permite o envio de 5 e-mails por vez, necessitando de um delay para que não caia em failed_jobs
            
            $when = now()->addSeconds($index * 5);
            Mail::to($user)->later($when, $email);
        }

    }
}
