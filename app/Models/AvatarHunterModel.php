<?php

namespace App\Models;

use CodeIgniter\Model;

class AvatarHunterModel extends Model
{
    protected $table            = 'avatars_hunters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['hunter_id', 'imagem'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAvatarFiles($id)
    {
        $avatar_diretorio = WRITEPATH . 'uploads/avatars/' . $id;
        if (!is_dir($avatar_diretorio)) {
            return [];
        }
        $arquivos = glob($avatar_diretorio . '/*');
        $arquivo_lista = [];
        foreach ($arquivos as $a) {
            if (is_file($a)) {
                $arquivo_lista[] = [
                    'name' => basename($a),
                    'path' => $a,
                ];
            }
        }
        return $arquivo_lista;
    }

    public function getAvatarTrashFiles($id)
    {
        $avatar_diretorio = WRITEPATH . 'uploads/trash/avatars/' . $id;
        if (!is_dir($avatar_diretorio)) {
            return [];
        }
        $arquivos = glob($avatar_diretorio . '/*');
        $arquivo_lista = [];
        foreach ($arquivos as $a) {
            if (is_file($a)) {
                $arquivo_lista[] = [
                    'name' => basename($a),
                    'path' => $a,
                ];
            }
        }
        return $arquivo_lista;
    }

}