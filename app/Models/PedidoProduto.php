<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoProduto extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'pedido_id', 
        'produto_id', 
        'qtdeconferida', 
        'conferido', 
        'qtde',
        'checklist',
        'elm',
        'aprov',
        'concl',
        'datanec',
        'cen',
        'dep',
        'criado',
        'aprovador',
        'dataaprov',
        'horaprov',
        'ordem'
    ];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidoprodutos';

    public static function proximoItem ($pedido_id, $acao, $ordem)
    {
        // Inicio da separação e continuação
        if (is_null($ordem) && $acao == 'next')
        {
            $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', $pedido_id)
                              ->where('pedidoprodutos.conferido', 0)
                              ->orderby('pedidoprodutos.ordem')->first();
                              
            return $item;
        }
        // Próximo item
        elseif (!is_null($ordem) && $acao == 'next')
        {
            $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', $pedido_id)
                              ->where('pedidoprodutos.conferido', 0)
                              ->where('pedidoprodutos.ordem', '>', $ordem)
                              ->orderBy('pedidoprodutos.ordem')->first();

                            
            // Se for e confirmação do ultimo item 
            if (!isset($item))
                $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', $pedido_id)
                              ->where('pedidoprodutos.conferido', 0)
                              ->orderBy('pedidoprodutos.ordem', 'desc')->first();
            return $item;
        }
        // voltar
        elseif (!is_null($ordem) && $acao == 'voltar')
        {
            $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', $pedido_id)
                              ->where('pedidoprodutos.conferido', 0)
                              ->where('pedidoprodutos.ordem', '<', $ordem)
                              ->orderBy('pedidoprodutos.ordem', 'desc')->first();

            return $item;

        }
        // pular
        elseif (!is_null($ordem) && $acao == 'pular')
        {
            $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', $pedido_id)
                              ->where('pedidoprodutos.conferido', 0)
                              ->where('pedidoprodutos.ordem', '>', $ordem)
                              ->orderBy('pedidoprodutos.ordem')->first();

            return $item;
        }
    }
}
