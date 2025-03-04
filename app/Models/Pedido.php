<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 * 
 * @property int $id_pedido
 * @property int $cliente_ci
 * @property string $metodo_pago
 * @property int $hora_pedido
 * @property int $minutos_pedido
 * @property int $dia_pedido
 * @property int $mes_pedido
 * @property int $anio_pedido
 * @property int $estado_pedido
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Cliente $cliente
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Pedido extends Model
{
	protected $table = 'pedidos';
	protected $primaryKey = 'id_pedido';

	protected $casts = [
		'cliente_ci' => 'int',
		'hora_pedido' => 'int',
		'minutos_pedido' => 'int',
		'dia_pedido' => 'int',
		'mes_pedido' => 'int',
		'anio_pedido' => 'int',
		'estado_pedido' => 'int'
	];

	protected $fillable = [
		'cliente_ci',
		'metodo_pago',
		'hora_pedido',
		'minutos_pedido',
		'dia_pedido',
		'mes_pedido',
		'anio_pedido',
		'estado_pedido'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cliente_ci');
	}

	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'productos_by_pedidos', 'id_pedido', 'id_producto')
					->withPivot('id_producto_by_pedido', 'cantidad')
					->withTimestamps();
	}
}
