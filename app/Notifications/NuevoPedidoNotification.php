<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoPedidoNotification extends Notification implements ShouldQueue
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
                    ->subject('🎉 Nuevo Pedido en La Super Bodega del Mueble')
                    ->greeting('Hola ' . $notifiable->nombres . ',')
                    ->line('Se ha generado un nuevo pedido en el sistema.')
                    ->line('ID del pedido: #' . $this->pedido->id_pedido)
                    ->line('Cliente: ' . $this->pedido->cliente->nombre)
                    ->line('Total: $' . number_format($this->pedido->total_pedido, 0, ',', '.'))
                    ->action('Ver Pedido', url('/admin/pedidos/' . $this->pedido->id_pedido))
                    ->line('¡Gracias por usar nuestro sistema!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Nuevo pedido #' . $this->pedido->id_pedido . ' de ' . $this->pedido->cliente->nombre,
            'url' => '/admin/pedidos/' . $this->pedido->id_pedido,
            'icon' => 'shopping-cart',
            'type' => 'info'
        ];
    }
}