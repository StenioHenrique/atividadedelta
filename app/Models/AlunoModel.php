<?php

namespace App\Models;

use CodeIgniter\Model;

class AlunoModel extends Model
{
    protected $table = 'aluno';
    protected $primaryKey = 'alunoid';
    protected $allowedFields = ['alunoid','nome', 'endereco', 'imgaluno'];
    protected $returnType = 'object';
}
