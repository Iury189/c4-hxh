<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\{HunterModel,RecompensadoModel,RecompensaModel};
use App\Validation\RecompensadoValidation;

class RecompensadoController extends BaseController
{
    public function index()
    {
        $model = new RecompensadoModel();
        $recompensados = [
            'recompensados' => $model->select('recompensados.id,
            hunters.nome_hunter,recompensas.descricao_recompensa,
            recompensas.valor_recompensa,recompensados.concluida')
            ->join('hunters', 'hunters.id = recompensados.hunter_id')
            ->join('recompensas', 'recompensas.id = recompensados.recompensa_id')
            ->paginate(5),
            'pager' => $model->pager,
        ];
        return view('recompensado/index', $recompensados);
    }

    public function search()
    {
        $model = new RecompensadoModel();
        $pesquisa = $this->request->getGet('search');
        $recompensados = [
            'recompensados' => $model->select('recompensados.id,
            hunters.nome_hunter,recompensas.descricao_recompensa,
            recompensas.valor_recompensa,recompensados.concluida')
            ->join('hunters', 'hunters.id = recompensados.hunter_id')
            ->join('recompensas', 'recompensas.id = recompensados.recompensa_id')
            ->like('hunters.nome_hunter', $pesquisa, 'both')
            ->orLike('recompensas.descricao_recompensa', $pesquisa, 'both')
            ->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
        ];
        return view('recompensado/index', $recompensados);
    }

    public function create()
    {
        $recompensa = new RecompensaModel();
        $recompensado = new RecompensadoModel();
        $hunter = new HunterModel();

        $recompensas = $recompensa->findAll();
        $hunters = $hunter->findAll();

        $recompensas_atribuidas = $recompensado->select('recompensa_id')->findAll();
        $recompensas_atribuidas_id = array_column($recompensas_atribuidas, 'recompensa_id');

        $recompensas_disponiveis = array_filter($recompensas, function ($recompensa) use ($recompensas_atribuidas_id) {
            return !in_array($recompensa['id'], $recompensas_atribuidas_id);
        });

        $recompensas_disponiveis = array_column($recompensas_disponiveis, null, 'id');
        $hunters = array_column($hunters, null, 'id');

        $dados = [
            'recompensas' => $recompensas_disponiveis, 
            'hunters' => $hunters, 
        ];

        return view('recompensado/create', $dados);
    }

    public function store()
    {
        $model = new RecompensadoModel();
        $validacoes = new RecompensadoValidation();
        if (!$this->validate($validacoes->recompensado_store)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados_tratados = [
            'recompensa_id' => (int) $this->request->getVar('recompensa_id'),
            'hunter_id' => (int) $this->request->getVar('hunter_id'),
            'concluida' => (boolean) $this->request->getVar('concluida'),
        ];
        $model->insert($dados_tratados);
        $id = $model->insertID();
        $registro_cadastrado = $model->select('recompensados.*, hunters.nome_hunter')
        ->join('hunters', 'hunters.id = recompensados.hunter_id')->find($id);
        $nome_recompensado = $registro_cadastrado['nome_hunter'];
        return redirect()->to(route_to('indexRecompensado'))->with('success', "Recompensado $nome_recompensado foi inserido com sucesso.");
    }

    public function view($id)
    {
        $model = new RecompensadoModel();
        $recompensa = new RecompensaModel();
        $hunter = new HunterModel();

        $recompensas = $recompensa->findAll();
        $hunters = $hunter->findAll();

        $recompensas = array_column($recompensas, null, 'id');
        $hunters = array_column($hunters, null, 'id');

        $dados = [
            'recompensados' => $model->getRecompensado($id),
            'recompensas' => $recompensas, 
            'hunters' => $hunters,  
        ];

        return view('recompensado/view', $dados);
    }

    public function edit($id)
    {
        $model = new RecompensadoModel();
        $recompensa = new RecompensaModel();
        $hunter = new HunterModel();

        $recompensas = $recompensa->findAll();
        $hunters = $hunter->findAll();

        $recompensas = array_column($recompensas, null, 'id');
        $hunters = array_column($hunters, null, 'id');

        $dados = [
            'recompensados' => $model->getRecompensado($id),
            'recompensas' => $recompensas, 
            'hunters' => $hunters,  
        ];

        return view('recompensado/edit', $dados);
    }

    public function update($id)
    {
        $model = new RecompensadoModel();
        $validacoes = new RecompensadoValidation();
        if (!$this->validate($validacoes->recompensado_update)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $dados_tratados = [
            'recompensa_id' => (int) $this->request->getVar('recompensa_id'),
            'hunter_id' => (int) $this->request->getVar('hunter_id'),
            'concluida' => (boolean) $this->request->getVar('concluida'),
        ];
        $model->update($id, $dados_tratados);
        $registro_cadastrado = $model->select('recompensados.*, hunters.nome_hunter')
        ->join('hunters', 'hunters.id = recompensados.hunter_id')->find($id);
        $nome_recompensado = $registro_cadastrado['nome_hunter'];
        return redirect()->to(route_to('indexRecompensado'))->with('info', "Recompensado $nome_recompensado foi atualizada com sucesso.");
    }

    public function delete($id)
    {
        $model = new RecompensadoModel();
        $registro_cadastrado = $model->select('recompensados.*, hunters.nome_hunter')
        ->join('hunters', 'hunters.id = recompensados.hunter_id')->find($id);
        $nome_recompensado = $registro_cadastrado['nome_hunter'];
        $model->delete($id);
        log_message('warning', "Recompensado $nome_recompensado foi enviado para a lixeira.");
        return redirect()->to(route_to('indexRecompensado'))->with('warning', "Recompensado $nome_recompensado foi enviado para a lixeira.");
    }

    public function onlyDeleted()
    {
        $model = new RecompensadoModel();
        $recompensados = [
            'recompensados' => $model->select('recompensados.id,
            hunters.nome_hunter,recompensas.descricao_recompensa,
            recompensas.valor_recompensa,recompensados.concluida')
            ->join('hunters', 'hunters.id = recompensados.hunter_id')
            ->join('recompensas', 'recompensas.id = recompensados.recompensa_id')
            ->onlyDeleted()->paginate(5),
            'pager' => $model->pager,
        ];
        return view('recompensado/trash', $recompensados);
    }

    public function searchTrash()
    {
        $model = new RecompensadoModel();
        $pesquisa = $this->request->getGet('search');
        $recompensados = [
            'recompensados' => $model->select('recompensados.id,
            hunters.nome_hunter,recompensas.descricao_recompensa,
            recompensas.valor_recompensa,recompensados.concluida')
            ->join('hunters', 'hunters.id = recompensados.hunter_id')
            ->join('recompensas', 'recompensas.id = recompensados.recompensa_id')
            ->like('nome_hunter', $pesquisa, 'both')
            ->orLike('descricao_recompensa', $pesquisa, 'both')
            ->onlyDeleted()->paginate(5),
            'pager' => $model->pager,
            'pesquisa' => $pesquisa,
        ];
        return view('recompensado/trash', $recompensados);
    }

    public function restoreDeleted($id)
    {
        $model = new RecompensadoModel();
        $registro_deletado = $model->onlyDeleted()
        ->select('recompensados.*, hunters.nome_hunter')
        ->join('hunters', 'hunters.id = recompensados.hunter_id')->find($id);
        $nome_hunter = $registro_deletado['nome_hunter'];
        if ($registro_deletado) {
            $model->onlyDeleted()->builder()->update(['deleted_at' => null], ['id' => $id]);
            log_message('info', "Recompensado $nome_hunter foi restaurado(a).");
            return redirect()->to(route_to('trashRecompensado'))->with('success', "Recompensado $nome_hunter retornou para a listagem principal.");
        } else {
            return redirect()->to(route_to('trashRecompensado'))->with('warning', "Recompensado $nome_hunter não encontrado(a) ou já restaurado(a).");
        }
    }

    public function deletePermanently($id)
    {
        $model = new RecompensadoModel();
        $registro_deletado = $model->onlyDeleted()
        ->select('recompensados.*, hunters.nome_hunter')
        ->join('hunters', 'hunters.id = recompensados.hunter_id')->find($id);
        $nome = $registro_deletado['nome_hunter'];
        if ($registro_deletado){
            $model->onlyDeleted()->where('id', $id)->purgeDeleted();
            log_message('alert', "Recompensado $nome foi excluído(a) permanentemente.");
            return redirect()->to(route_to('trashRecompensado'))->with('danger', "Recompensado $nome foi excluído(a) permanentemente.");
        } else {
            return redirect()->to(route_to('trashRecompensado'))->with('warning', "Não é possível excluir o recompensado $nome permanentemente.");
        }
    }

}