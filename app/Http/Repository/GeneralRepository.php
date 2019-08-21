<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\Schema;

abstract class GeneralRepository
{

    protected $model;
    protected $campospresindibles = ['id','created_at','updated_at'];

    public function todos(){
        return $this->model->all();
    }

    public function traer($id){
        return $this->model->findOrFail($id);
    }

    public function crear($array){
        if(is_array($array)){
            $a = get_defined_vars($array);
        }else{
            $a =get_object_vars($array);
        }

        unset($array['guardar']);
        $this->model->fill($array);
        $this->model->save();
    }

    public function eliminar($id){
        $elemento = $this->model->find($id);
        $elemento->delete();
    }

    public function actualizar($id,$array){
        $elemento = $this->model->find($id);
        $elemento->update($array);
    }

    public function arrayParaFormulario(){
        /**
         * @todo Resolver de forma más eficiente.
         */

        $tabla = $this->model->getTable();
        $forgein = (method_exists($this->model,'getForgein')) ? $this->model->getForgein() : null;
        $pestanas = (method_exists($this->model,'getPivot')) ? $this->model->getPivot() : null;
        $campos = Schema::getColumnListing($tabla);

        $final = [];

        for($i=0;$i<count($campos);$i++){
            $final[$campos[$i]] = Schema::getColumnType($tabla,$campos[$i]);
        }

        if(method_exists($this->model,'quitarDeFormulario')){
            $quitar = $this->model->quitarDeFormulario();
            for($i=0;$i<count($quitar);$i++){
                unset($final[$quitar[$i]]);
            }
        }

        if($forgein!=null){
            foreach($forgein as $i=>$v) {
                $final[$i]=$v;
            }
        }


        for($i=0;$i<count($this->campospresindibles);$i++){
            unset($final[$this->campospresindibles[$i]]);
        }

        $ordenado=[];

        if(property_exists($this->model,'orden')){
            foreach($this->model->orden as $elemento){
                $ordenado[$elemento] = $final[$elemento];
            }
        }else{
            $ordenado = $final;
        }

        $ordenado['pestanas']=[];

        if($pestanas!=null){
            foreach($pestanas as $i=>$v) {
                $ordenado['pestanas'][$i]=$v;
            }
        }

        return $ordenado;

    }

}
