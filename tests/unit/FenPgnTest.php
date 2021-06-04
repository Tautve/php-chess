<?php

namespace Chess\Tests\Unit\Fen;

use Chess\FenPgn;
use Chess\Tests\AbstractUnitTestCase;

class FenPgnTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4()
    {
        $pgn = (new FenPgn(
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3'
        ))->create();

        $expected = 'e4';

        $this->assertEquals($expected, $pgn);
    }

    /**
     * @test
     */
    public function Nf3()
    {
        $pgn = (new FenPgn(
            'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq -',
            'rnbqkbnr/pppppppp/8/8/8/5N2/PPPPPPPP/RNBQKB1R b KQkq -'
        ))->create();

        $expected = 'Nf3';

        $this->assertEquals($expected, $pgn);
    }
}
