<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Acceso
 * 
 * @property int $id_acceso
 * @property string $correo
 * @property string $clave
 * @property string $respuesta_secreta
 * @property int $tipo_usuario
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Acceso extends Model
{
	protected $table = 'acceso';
	protected $primaryKey = 'id_acceso';

	protected $casts = [
		'tipo_usuario' => 'int'
	];

	protected $hidden = [
		'respuesta_secreta'
	];

	protected $fillable = [
		'correo',
		'clave',
		'respuesta_secreta',
		'tipo_usuario'
	];
}
