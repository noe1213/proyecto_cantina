<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contorno
 * 
 * @property int $id_contorno
 * @property string $nombre_contorno
 * @property string|null $descripcion
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Contorno extends Model
{
	protected $table = 'contornos';
	protected $primaryKey = 'id_contorno';
	public $timestamps = false;

	protected $fillable = [
		'nombre_contorno',
		'descripcion'
	];

	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'productos_contornos', 'id_contorno', 'id_producto');
	}
}
