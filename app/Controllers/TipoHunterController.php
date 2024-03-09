<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TipoHunterModel;
use App\Validation\TipoHunterValidation;

class TipoHunterController extends ResourceController
{
    public function index()
    {
        $tipo_hunter = new TipoHunterModel();
        $dados = $tipo_hunter->findAll();
        return $this->respond($dados);
    }

    public function create()
    {
        $validacoes = new TipoHunterValidation();
        if (!$this->validate($validacoes->tipo_hunter_store)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $tipo_hunter = new TipoHunterModel();
        $dados = $this->request->getJSON();
        $id = $tipo_hunter->insert($dados);
        $registro = $tipo_hunter->find($id);
        return $this->respondCreated($registro);
    }

    public function show($id = null)
    {
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$tipo_hunter) {
            return $this->failNotFound("Registro $id não encontrado.");
        }
        return $this->respond($registro);
    }

    public function update($id = null)
    {
        $validacoes = new TipoHunterValidation();
        if (!$this->validate($validacoes->tipo_hunter_update)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$registro) {
            return $this->failNotFound("Registro $id não encontrado.");
        }
        $dados = $this->request->getJSON();
        $tipo_hunter->update($id, $dados);
        $registro_atualizado = $tipo_hunter->find($id);
        return $this->respondUpdated($registro_atualizado);
    }

    public function delete($id = null)
    {
        $tipo_hunter = new TipoHunterModel();
        $registro = $tipo_hunter->find($id);
        if (!$registro) {
            return $this->failNotFound("Registro $id não encontrado.");
        }
        $tipo_hunter->delete($id);
        return $this->respondDeleted($registro);
    }
}