<?php

use \PHPComRapadura\Tradutor;

class TradutorTest extends PHPUnit\Framework\TestCase
{

    public function testCriaInstanciaDaLinguaNaoTraduzida()
    {
        $t = new Tradutor('pt_BR');
        $this->assertEquals(getcwd() . "/lingua/pt_BR.yml", $t->caminhoDaTraducao());
        $this->assertTrue(file_exists($t->caminhoDaTraducao()));
        return $t;
    }

    /**
     * @depends testCriaInstanciaDaLinguaNaoTraduzida
     */
    public function testExiteTraducaoParaOTermo(Tradutor $t)
    {
        $this->assertEquals("Bem-vindo", $t->traduz("Welcome"));
        $this->assertEquals(false, $t->traduz("Welcome Alef"));
    }

    /**
     * @depends testCriaInstanciaDaLinguaNaoTraduzida
     */
    public function testAdionaTermoNoArquivo(Tradutor $t)
    {
        $this->assertTrue($t->adicionaTermo("Welcome %s", "Bem-vindo %s"));
        $this->assertTrue($t->adicionaTermo("Welcome %s %s", "Bem-vindo %s %s"));
    }

    public function testVerificaSeTermoWelcomeFoiInseridoNoArquivo()
    {
        $t = new Tradutor('pt_BR');
        $this->assertEquals("Bem-vindo Alef Castelo", $t->traduz("Welcome %s %s", ['Alef', 'Castelo']));
    }
}