<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductosContorno
 * 
 * @property int $id_producto
 * @property int $id_contorno
 * 
 * @property Contorno $contorno
 * @property Producto $producto
 *
 * @package App\Models
 */
class ProductosContorno extends Model
{
	protected $table = 'productos_contornos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_producto' => 'int',
		'id_contorno' => 'int'
	];

	public function contorno()
	{
		return $this->belongsTo(Contorno::class, 'id_contorno');
	}

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}
}
