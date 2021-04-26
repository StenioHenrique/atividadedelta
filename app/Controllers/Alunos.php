<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Alunos extends BaseController
{
    public function index()
    {
        $alunoModel = new \App\Models\AlunoModel();
        $data['alunos'] = $alunoModel->find();
        $data['titulo'] = "Alunos";
        $data['msg'] = $this->session->getFlashdata('msg');
        echo View('alunos', $data);
    }

    // abrir a view para inserir aluno 
    public function inserir()
    {
        // inicializar view
        $data['titulo'] = "Inserir novo aluno";
        $data['acao'] = 'Inserir';
        $data['msg'] = '';
        $data['aluno'] = null;
        echo View('alunos_form', $data);
    }

    // salvar o aluno cadastrado na view
    public function salvar()
    {

        // verificar o metodo HTTP para validar que ouve dados vindos do 
        // navegador para então validar a inserção de dados
        $request = \Config\Services::request();
        $method = $request->getMethod();

        // verificar se ouve um submit do tipo post para fazer o cadastro
        if ($method == 'post') {
            // criar uma instancia da model para armazenar no banco de dados
            $alunoModel = new \App\Models\AlunoModel();
            $nome = $request->getPost('nome');
            $alunoModel->set('nome', $nome);
            $alunoModel->set('endereco', $request->getPost('endereco'));

            // manipular a imagem e seu nome e para guardar na respectiva pasta
            $file = $request->getFile('imagem');
            $nomeImagem = str_replace(' ', '_', strtolower($nome)) . '_' . $file->getName();

            // verfica a validade da imagem
            if (!$file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }
            $file->move("../public/imgs/", $nomeImagem);

            // armazena a url da imagem para referenciá-la ao aluno
            $alunoModel->set('imgaluno', "/imgs/" . $nomeImagem);

            // tenta executar a inserção e retorna para a listagem de listagem de alunos 
            // informando a resultado do comando de insercao
            if ($alunoModel->insert()) {
                return json_encode(true);
            } else {
                return json_encode(false);
            }
        }
    }

    // carregar e preparar a view para a atualização do aluno
    public function editar($alunoid)
    {

        //prepara as informações da view de editar
        $data['titulo'] = "Editar aluno";
        $data['acao'] = 'Editar';
        $data['msg'] = '';

        // carrega e prepara o aluno com o ID passado para a atualização
        $alunoModel = new \App\Models\AlunoModel();
        $aluno = $alunoModel->find($alunoid);

        if (!isset($aluno)) {
            return redirect()->to(base_url('/alunos'));
        } else {
            $request = \Config\Services::request();
            $method = $request->getMethod();
            // verificar se ouve um submit do tipo post para fazer o cadastro
            if ($method == 'post') {
                $nome = $request->getPost('nome');
                $aluno->nome = $nome;
                $aluno->endereco = $request->getPost('endereco');

                // manipular a imagem e seu nome e para guardar na respectiva pasta
                $file = $request->getFile('imagem');
                $nomeImagem = str_replace(' ', '_', strtolower($nome)) . '_' . $file->getName();

                // verfica a validade da imagem
                //guarda a imagem e atualiza o aluno
                if ($file->isValid()) {
                    $file->move("../public/imgs/", $nomeImagem);
                    $aluno->imgaluno = "/imgs/" . $nomeImagem;
                }
                $db      = \Config\Database::connect();
                $builder = $db->table('aluno');
                $builder->where('alunoid', $alunoid);
                $aluno = (array)$aluno;
                if ($builder->update($aluno)) {
                    return json_encode(true);
                } else {
                    return json_encode(false);
                }
            }

            $data['aluno'] = $aluno;
            echo View('alunos_form', $data);
        }
    }

    // excluir aluno 
    public function excluir($alunoid = null)
    {
        // testar para validar o alunoid passado 
        if (is_null($alunoid)) {
            $this->session->setFlashdata('msg', 'Aluno não encontrado');
            return redirect()->to(base_url('/alunos'));
        }

        // com o aluno valido executar o comando de exclusão
        // retornando valores do tipo boolean em formato json para validar 
        // com o sweet alert
        $alunoModel = new \App\Models\AlunoModel();
        if ($alunoModel->delete($alunoid)) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}
