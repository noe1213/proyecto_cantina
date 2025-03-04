<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contorno
 * 
 * @property int $id_contorno
 * @property string $nombre_contorno
 * @property string|null $descripcion
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Contorno extends Model
{
	protected $table = 'contornos';
	protected $primaryKey = 'id_contorno';

	protected $fillable = [
		'nombre_contorno',
		'descripcion'
	];

	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'productos_by_contornos', 'id_contorno', 'id_producto')
					->withPivot('id_producto_by_contorno')
					->withTimestamps();
	}
}
