<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $ci
 * @property string $correo
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property string $contrasena
 * @property string $confir_contra
 * @property string $respuesta_secreta
 * @property int $dia_n
 * @property int $mes_n
 * @property int $anio_n
 * @property string $municipio
 * @property string $parroquia
 * @property string $calle
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Pedido[] $pedidos
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	protected $primaryKey = 'ci';
	public $incrementing = false;

	protected $casts = [
		'ci' => 'int',
		'dia_n' => 'int',
		'mes_n' => 'int',
		'anio_n' => 'int'
	];

	protected $hidden = [
		'respuesta_secreta'
	];

	protected $fillable = [
		'ci',
		'correo',
		'nombre',
		'apellido',
		'telefono',
		'contrasena',
		'confir_contra',
		'respuesta_secreta',
		'dia_n',
		'mes_n',
		'anio_n',
		'municipio',
		'parroquia',
		'calle'
	];

	public function pedidos()
	{
		return $this->hasMany(Pedido::class, 'cliente_ci');
	}
}
