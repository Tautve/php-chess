<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Array\AsciiArray;
use Chess\Eval\BackwardPawnEval;
use Chess\Tests\AbstractUnitTestCase;

class BackwardPawnEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function kaufman_16()
    {
        $position = [
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            5 => [ ' p ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' P ', ' . ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' P ', ' . ', ' . ', ' . ', ' . ', ' k ', ' . ' ],
            1 => [ ' . ', ' P ', ' . ', ' K ', ' . ', ' . ', ' . ', ' . ' ],
            0 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
        ];

        $board = (new AsciiArray($position))->toBoard('w');

        $expected = [
            'w' => 2,
            'b' => 1,
        ];

        $backwardPawnEval = (new BackwardPawnEval($board))->eval();

        $this->assertSame($expected, $backwardPawnEval);
    }

    /**
     * @test
     */
    public function kaufman_16_recognizes_defended_pawns(): void
    {
        $position = [
            7 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
            6 => [ ' . ', ' . ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ' ],
            5 => [ ' p ', ' . ', ' . ', ' p ', ' . ', ' . ', ' . ', ' . ' ],
            4 => [ ' . ', ' . ', ' p ', ' P ', ' . ', ' . ', ' . ', ' . ' ],
            3 => [ ' . ', ' . ', ' P ', ' P ', ' P ', ' . ', ' . ', ' . ' ],
            2 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' k ', ' . ' ],
            1 => [ ' . ', ' P ', ' . ', ' K ', ' . ', ' . ', ' . ', ' . ' ],
            0 => [ ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ', ' . ' ],
        ];

        $board = (new AsciiArray($position))->toBoard('w');

        $expected = [
            'w' => 0,
            'b' => 1,
        ];

        $backwardPawnEval = (new BackwardPawnEval($board))->eval();

        $this->assertSame($expected, $backwardPawnEval);
    }
}
