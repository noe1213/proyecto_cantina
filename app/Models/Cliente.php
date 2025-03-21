<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
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
		'contrasena', // Ocultar la contraseña
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

	// Especificar el campo de la contraseña
	public function getAuthPassword()
	{
		return $this->contrasena;
	}
}
