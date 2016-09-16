<?php

namespace PHPComRapadura;

use Symfony\Component\Yaml\Yaml;

class Tradutor
{
    protected $caminhoDaTraducao;
    protected $termos;

    public function __construct($lingua = null)
    {
        $this->caminhoDaTraducao = getcwd() . "/lingua/{$lingua}.yml";
        if(!file_exists($this->caminhoDaTraducao))
            file_put_contents($this->caminhoDaTraducao, []);
        else
            $this->termos = Yaml::parse(file_get_contents($this->caminhoDaTraducao));
    }

    public function caminhoDaTraducao()
    {
        return $this->caminhoDaTraducao;
    }

    public function traduz($termo, $parametros = [])
    {
        if(array_key_exists($termo, $this->termos))
            return vsprintf($this->termos[$termo], $parametros);

        return false;
    }

    public function adicionaTermo($termo, $termoTraduzido)
    {
        $this->termos[$termo] = $termoTraduzido;
        $this->escreveTermosTraduzidos();
        return true;
    }

    public function escreveTermosTraduzidos()
    {
        $termos = Yaml::dump($this->termos);
        file_put_contents($this->caminhoDaTraducao(), $termos);
    }
}