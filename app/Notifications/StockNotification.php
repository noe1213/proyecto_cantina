<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StockNotification extends Notification
{
    use Queueable;

    private $producto;

    public function __construct($producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Opciones: mail, database, etc.
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('¡Atención! Stock bajo')
            ->line('El producto ' . $this->producto->nombre_producto . ' está por debajo del nivel mínimo.')
            ->action('Revisar Producto', url('/productos/' . $this->producto->id_producto))
            ->line('Por favor, revisa tus existencias lo antes posible.');
    }

    public function toArray($notifiable)
    {
        return [
            'producto_id' => $this->producto->id_producto,
            'nombre_producto' => $this->producto->nombre_producto,
            'stock_actual' => $this->producto->stock_producto,
        ];
    }
}
