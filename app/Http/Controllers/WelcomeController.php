<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use RicorocksDigitalAgency\Soap\Facades\Soap;

class WelcomeController extends Controller {

    public function index()
    {
        Auth::logout();
        return view('welcome');
    }
    
    public function store(Request $request)
    {
        $acesso = json_decode(Soap::to('http://192.168.3.100:8080/soap/wsdl?targetURI=webservices')
                                  ->call('wsLoginCorporativo', ['login' => $request->login, 'senha' => $request->senha ])
                                  ->response->saida);

        // Verifica se login foi realizado com sucesso no Corporativo
        if (isset($acesso->{'ds-saida'}->{'t-usuario'}))
        {
            $teste = User::all();

            dd($teste);
            // Pesquisa de usuário já está inserido na Base de Dados 
            $usuario = User::where('matricula', $acesso->{'ds-saida'}->{'t-usuario'}[0]->matricula)->get();


            // Insere usuário na Base de Dados 
            if (count($usuario) == 0)
            {
                $dados['name'] = $acesso->{'ds-saida'}->{'t-usuario'}[0]->nome;
                $dados['matricula'] = $acesso->{'ds-saida'}->{'t-usuario'}[0]->matricula;
                $dados['email'] = $acesso->{'ds-saida'}->{'t-usuario'}[0]->email ?? "";
                $dados['setor'] = $acesso->{'ds-saida'}->{'t-usuario'}[0]->setor ?? "";
                $usuario = User::create($dados);
                Auth::loginUsingId($usuario['id']);
            }else
                Auth::loginUsingId($usuario[0]['id']); 
            
             return view('dashboard'); 

        }else
            return redirect ('/')->with('mensagem', 'Usuário ou senha incorreta');
    }
}