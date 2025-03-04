<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id_producto
 * @property string $nombre_producto
 * @property float $precio_producto
 * @property string $categoria_producto
 * @property int $stock_producto
 * @property int $stock_minimo
 * @property string|null $imagen
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Pedido[] $pedidos
 * @property Collection|Contorno[] $contornos
 *
 * @package App\Models
 */
class Producto extends Model
{
	protected $table = 'productos';
	protected $primaryKey = 'id_producto';

	protected $casts = [
		'precio_producto' => 'float',
		'stock_producto' => 'int',
		'stock_minimo' => 'int'
	];

	protected $fillable = [
		'nombre_producto',
		'precio_producto',
		'categoria_producto',
		'stock_producto',
		'stock_minimo',
		'imagen'
	];

	public function pedidos()
	{
		return $this->belongsToMany(Pedido::class, 'productos_by_pedidos', 'id_producto', 'id_pedido')
					->withPivot('id_producto_by_pedido', 'cantidad')
					->withTimestamps();
	}

	public function contornos()
	{
		return $this->belongsToMany(Contorno::class, 'productos_contornos', 'id_producto', 'id_contorno');
	}
}
