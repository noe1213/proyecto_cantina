<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductosByContorno
 * 
 * @property int $id_producto_by_contorno
 * @property int $id_producto
 * @property int $id_contorno
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Producto $producto
 * @property Contorno $contorno
 *
 * @package App\Models
 */
class ProductosByContorno extends Model
{
	protected $table = 'productos_by_contornos';
	protected $primaryKey = 'id_producto_by_contorno';

	protected $casts = [
		'id_producto' => 'int',
		'id_contorno' => 'int'
	];

	protected $fillable = [
		'id_producto',
		'id_contorno'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}

	public function contorno()
	{
		return $this->belongsTo(Contorno::class, 'id_contorno');
	}
}
