<?php namespace App\Http\Interfaces;


interface RepositoryInterface
{
    public function todos();

    public function crear($array);

    public function traer($id);

    public function eliminar($id);

    public function actualizar($id, $array);

}
