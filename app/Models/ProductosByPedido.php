<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductosByPedido
 * 
 * @property int $id_producto_by_pedido
 * @property int $id_pedido
 * @property int $id_producto
 * @property int $cantidad
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Producto $producto
 * @property Pedido $pedido
 *
 * @package App\Models
 */
class ProductosByPedido extends Model
{
	protected $table = 'productos_by_pedidos';
	protected $primaryKey = 'id_producto_by_pedido';

	protected $casts = [
		'id_pedido' => 'int',
		'id_producto' => 'int',
		'cantidad' => 'int'
	];

	protected $fillable = [
		'id_pedido',
		'id_producto',
		'cantidad'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}

	public function pedido()
	{
		return $this->belongsTo(Pedido::class, 'id_pedido');
	}
}
