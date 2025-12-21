<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AsesorAsignadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Pedido $pedido)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('🤝 Te han asignado un nuevo cliente')
                    ->greeting('Hola ' . $notifiable->nombres . ',')
                    ->line('Te han asignado el pedido #' . $this->pedido->id_pedido . ' para acompañar al cliente.')
                    ->line('Cliente: ' . $this->pedido->cliente->nombre)
                    ->line('Total: $' . number_format($this->pedido->total_pedido, 0, ',', '.'))
                    ->action('Ver Pedido', url('/admin/pedidos/' . $this->pedido->id_pedido))
                    ->line('Por favor, contacta al cliente lo antes posible.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Te han asignado el pedido #' . $this->pedido->id_pedido . ' de ' . $this->pedido->cliente->nombre,
            'url' => '/admin/pedidos/' . $this->pedido->id_pedido,
            'icon' => 'user-tie',
            'type' => 'warning'
        ];
    }
}