<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{

    public function imprimir(Request $request)
    {
        $produto = Produto::find($request->produto_id);
    
        // Dados
        $descricao = $produto->descricao;
        $codigo = $produto->codigosap;
        $rua = $produto->codigorua;

        // Divide em linhas de até 30 caracteres
        $linhas = str_split($descricao, 36);

        // 100mm x 30mm = 800 x 240 dots aproximadamente
        $zplDescricao = "";

        $y = 40; // posição inicial Y
        foreach ($linhas as $linha) {
            $zplDescricao .= "^FO230,{$y}^A0N,30,30^FD{$linha}^FS\n";
            $y += 35; // distância entre linhas
        }

        $zpl = "^XA
        ^POI 
        ^PW800
        ^LL240
        ^LH0,0

        ^FO30,40^A0N,32,32^FD{$codigo}^FS    // Código impresso acima
        ^FO30,70^BQ,2,6^FDQA,{$codigo}^FS    // QR Code logo abaixo do código

        {$zplDescricao}     // Descrição à direita

        ^FO330,120^A0N,70,70^FD{$rua}^FS    // Rua 

        ^XZ";
        // IP da impressora
        $printerIp = "192.168.26.28";
        $printerPort = 9100; // porta padrão

        $socket = @fsockopen($printerIp, $printerPort, $errno, $errstr, 5);

        if (!$socket)
            return redirect()->route('pesquisa')->with('msg', "Falha ao conectar à impressora: $errstr");

        fwrite($socket, $zpl);
        fclose($socket);

        return redirect()->route('pesquisa')->with('msg', 'Impressão realizda com sucesso.');
    }

    public function imprimirpulmao(Request $request)
    {
        $produto = Produto::find($request->produto_id);
    
        // Dados 
        $descricao = $produto->descricao;
        $codigo = $produto->codigosap;
        $rua = $produto->codigorua;
        $unidades = $request->unidades;
        $qtde_impressao = (int) $request->qtde_impressao;

        // Divide em linhas de até 30 caracteres
        $linhas = str_split($descricao, 36);

        // 100mm x 30mm = 800 x 240 dots aproximadamente
        $zplDescricao = "";

        $y = 25; // posição inicial Y
        foreach ($linhas as $linha) {
            $zplDescricao .= "^FO230,{$y}^A0N,30,30^FD{$linha}^FS\n";
            $y += 35; // distância entre linhas
        }

        $zpl = "";
        
        for ($i = 0; $i < $qtde_impressao; $i++) 
        {
            $zpl .= "^XA
            ^POI 
            ^PW800
            ^LL240
            ^LH0,0

            ^FO30,40^A0N,32,32^FD{$codigo}^FS    // Código impresso acima
            ^FO30,70^BQ,2,6^FDQA,{$codigo}|{$unidades}^FS    // QR Code logo abaixo do código

            {$zplDescricao}     // Descrição à direita

            ^FO330,100^A0N,70,70^FD{$rua}^FS    // Rua 

            ^FO400,170^A0N,60,60^FD{$unidades} UN^FS      // Número grande

            ^XZ\n";
        }

        // IP da impressora
        $printerIp = "192.168.26.28";
        $printerPort = 9100; // porta padrão

        $socket = @fsockopen($printerIp, $printerPort, $errno, $errstr, 5);

        if (!$socket) {
            return redirect()->route('pulmao')->with('msg', "Falha ao conectar à impressora: $errstr");
        }

        // Envia todas as etiquetas em uma só vez
        fwrite($socket, $zpl);
        fclose($socket);

        return redirect()->route('pulmao')->with('msg', "Impressão de {$qtde_impressao} etiqueta(s) realizada com sucesso.");

    }
}
