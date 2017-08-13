<?php
namespace PGNChess\Tests;

use PGNChess\Board;
use PGNChess\PGN\Symbol;
use PGNChess\PGN\Converter;
use PGNChess\Piece\Bishop;
use PGNChess\Piece\King;
use PGNChess\Piece\Knight;
use PGNChess\Piece\Pawn;
use PGNChess\Piece\Queen;
use PGNChess\Piece\Rook;
use PGNChess\Type\RookType;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiateDefaultBoard()
    {
        $board = new Board;
        $this->assertEquals(count($board), 32);
        $this->assertEquals(count($board->getStatus()->squares->used->w), 16);
        $this->assertEquals(count($board->getStatus()->squares->used->b), 16);
    }

    public function testInstantiateCustomBoard()
    {
        $pieces = [
            new Bishop(Symbol::COLOR_WHITE, 'c1'),
            new Queen(Symbol::COLOR_WHITE, 'd1'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8')
        ];
        $board = new Board($pieces);
        $this->assertEquals(count($board), 7);
        $this->assertEquals(count($board->getStatus()->squares->used->w), 4);
        $this->assertEquals(count($board->getStatus()->squares->used->b), 3);
    }

    public function testPlayQg3()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('b', 'Qg5')));
    }

    public function testPlayRaInDefaultBoard()
    {
        $board = new Board;
        $squares = [];
        $letter = 'a';
        for($i=0; $i<8; $i++)
        {
            for($j=1; $j<=8; $j++)
            {
                $this->assertEquals(false, $board->play(Converter::toObject('w', 'Ra' . chr((ord('a') + $i)) . $j)));
            }
        }
    }

    public function testPlayRa6()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Ra6')));
    }

    public function testPlayRa6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new Queen(Symbol::COLOR_WHITE, 'd1'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Bishop(Symbol::COLOR_WHITE, 'f1'),
            new Knight(Symbol::COLOR_WHITE, 'g1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_WHITE, 'b2'),
            new Pawn(Symbol::COLOR_WHITE, 'c2'),
            new Pawn(Symbol::COLOR_WHITE, 'd2'),
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_BLACK, 'a8', RookType::CASTLING_LONG),
            new Knight(Symbol::COLOR_BLACK, 'b8'),
            new Bishop(Symbol::COLOR_BLACK, 'c8'),
            new Queen(Symbol::COLOR_BLACK, 'd8'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'a7'),
            new Pawn(Symbol::COLOR_BLACK, 'b7'),
            new Pawn(Symbol::COLOR_BLACK, 'c7'),
            new Pawn(Symbol::COLOR_BLACK, 'd7'),
            new Pawn(Symbol::COLOR_BLACK, 'e7'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ra6')));
    }

    public function testPlayRxa6()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('b', 'Rxa6')));
    }

    public function testPlayBxe5()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Bxe5')));
    }

    public function testPlayexd4()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'exd4')));
    }

    public function testPlayRxa6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Rxa6')));
    }

    public function testPlayh6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'h6')));
    }

    public function testPlayhxg6InCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Pawn(Symbol::COLOR_WHITE, 'g6'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'hxg6')));
    }

    public function testPlayNc3()
    {
        $board = new Board;
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Nc3')));
    }

    public function testPlayNc6()
    {
        $board = new Board;
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nc6')));
    }

    public function testPlayNf6()
    {
        $board = new Board;
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nf6')));
    }

    public function testPlayNxd2()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Nxd2')));
    }

    /**
     * TODO look at this test: make sure that Xxyn is equivalent to Xyn in all cases
     * whenever the destination square is empty.
     */
    public function testPlayNxc3()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Nxc3')));
    }

    public function testPlayNxc3InCustomBoard()
    {
        $pieces = [
            new Knight(Symbol::COLOR_WHITE, 'b1'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Pawn(Symbol::COLOR_WHITE, 'g6'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'c3'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Nxc3')));
    }

    public function testPlayShortCastling()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testPlayLongCastling()
    {
        $board = new Board;
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O-O')));
    }

    public function testPlayShortCastlingInCustomBoard()
    {
        $pieces = [
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new Knight(Symbol::COLOR_WHITE, 'b1'),
            new Bishop(Symbol::COLOR_WHITE, 'c1'),
            new Queen(Symbol::COLOR_WHITE, 'd1'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Bishop(Symbol::COLOR_WHITE, 'f1'),
            new Knight(Symbol::COLOR_WHITE, 'g1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'b2'),
            new Pawn(Symbol::COLOR_WHITE, 'c2'),
            new Pawn(Symbol::COLOR_WHITE, 'd2'),
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_BLACK, 'a8', RookType::CASTLING_LONG),
            new Knight(Symbol::COLOR_BLACK, 'b8'),
            new Bishop(Symbol::COLOR_BLACK, 'c8'),
            new Queen(Symbol::COLOR_BLACK, 'd8'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'a7'),
            new Pawn(Symbol::COLOR_BLACK, 'b7'),
            new Pawn(Symbol::COLOR_BLACK, 'c7'),
            new Pawn(Symbol::COLOR_BLACK, 'd7'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'O-O')));
    }

    public function testKingForbiddenMove()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Kf4')));
    }

    public function testCheckIsFixedKe4()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke4')));
    }

    public function testCheckIsNotFixedKf4()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Kf4')));
    }

    public function testCheckIsNotFixedKg4()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Kg4')));
    }

    public function testCheckIsFixedKg3()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg3')));
    }

    public function testCheckIsFixedKg2()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg2')));
    }

    public function testCheckIsNotFixedKf2()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Kf2')));
    }

    public function testCheckIsFixedKe2()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke2')));
    }

    public function testCheckIsFixedKe3()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke3')));
    }

    public function testCheckIsNotFixedRe7()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Re7')));
    }

    public function testCheckIsNotFixeda4()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'f3'), // in check!
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'a4')));
    }

    public function testThrowsExceptionPieceDoesNotExistOnTheBoard()
    {
        $this->expectException(\InvalidArgumentException::class);
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->play(Converter::toObject('w', 'f4'));
    }

    public function testKingLegalMove()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f5', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kg2')));
    }

    public function testKingLegalCapture()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'h2', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kxh2')));
    }

    public function testKingCannotCaptureRookDefendedByKnight()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f2', RookType::CASTLING_SHORT), // rook defended by knight
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'Kxf2')));
    }

    public function testKingCannCaptureRookNotDefended()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'a3'),
            new Pawn(Symbol::COLOR_WHITE, 'c3'),
            new Rook(Symbol::COLOR_WHITE, 'e6', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'g3'),
            new Pawn(Symbol::COLOR_BLACK, 'a6'),
            new Pawn(Symbol::COLOR_BLACK, 'b5'),
            new Pawn(Symbol::COLOR_BLACK, 'c4'),
            new Knight(Symbol::COLOR_BLACK, 'd3'),
            new Rook(Symbol::COLOR_BLACK, 'f3', RookType::CASTLING_SHORT), // rook not defended
            new King(Symbol::COLOR_BLACK, 'g5'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kxf3')));
    }

    public function testPlayGameAndCheckStatus()
    {
        $game = [
            'e4 e5',
            'f4 exf4',
            'd4 Nf6',
            'Nc3 Bb4',
            'Bxf4 Bxc3+'
        ];
        $board = new Board;
        foreach ($game as $entry)
        {
            $moves = explode(' ', $entry);
            $board->play(Converter::toObject(Symbol::COLOR_WHITE, $moves[0]));
            $board->play(Converter::toObject(Symbol::COLOR_BLACK, $moves[1]));
        }
        $example = (object) [
            'w' => [
                'a3',
                'a6',
                'b1',
                'b3',
                'b5',
                'c1',
                'c4',
                'c5',
                'd2',
                'd3',
                'd5',
                'd6',
                'e2',
                'e3',
                'e5',
                'f2',
                'f3',
                'f5',
                'g3',
                'g4',
                'g5',
                'h3',
                'h5',
                'h6'
            ],
            'b' => [
                'a5',
                'a6',
                'b4',
                'b6',
                'c6',
                'd2',
                'd5',
                'd6',
                'e6',
                'e7',
                'f8',
                'g4',
                'g6',
                'g8',
                'h5',
                'h6'
            ]
        ];
        $this->assertEquals($example, $board->getStatus()->control->space);
    }

    public function testCastlingShortInDefaultBoard()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $this->assertEquals(false, $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'O-O')));
    }

    public function testWhiteCastlesShortSicilianAfterNc6()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nc6'));
        $this->assertEquals(false, $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'O-O')));
    }

    public function testWhiteCastlesShortSicilianAfterNf6()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nf6'));
        $this->assertEquals(true, $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'O-O')));
    }

    public function testWhiteCastlesLongSicilianAfterNf6()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nf6'));
        $this->assertEquals(false, $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'O-O-O')));
    }

    public function testWhiteCastlesShortSicilianAfterNf6BoardStatus()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'c5'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nf6'));
        $this->assertEquals(true, $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'O-O')));
    }

    public function testCastlingThreateningf1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd4'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Bishop(Symbol::COLOR_BLACK, 'a6'), // bishop threatening f1
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testCastlingThreateningf1Andg1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Bishop(Symbol::COLOR_BLACK, 'a6'), // bishop threatening f1
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'c5'), // bishop threatening g1
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testCastlingThreateningg1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'c5'), // bishop threatening g1
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testCastlingWithThreatsRemoved()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'd6'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testCastlingThreateningc1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f4'), // bishop threatening c1
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O-O')));
    }

    public function testCastlingThreateningd1Andf1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'e3'), // knight threatening d1 and f1
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O-O')));
    }

    public function testCastlingThreateningb1Andf1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'd2'), // knight threatening b1 and f1
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O-O')));
    }

    public function testCastlingThreateningb1Andd1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'c3'), // knight threatening b1 and d1
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O-O')));
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testForbidCastlingAfterKf1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Kf1')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nf6')));
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Ke1')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nd7')));
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testForbidCastlingAfterRg1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Rg1')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nf6')));
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'Rh1')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'Nd7')));
        $this->assertEquals(false, $board->play(Converter::toObject('w', 'O-O')));
    }

    public function testForbidCastlingRuyLopez()
    {
        $board = new Board;
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'e4'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'e5'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nf3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nc6'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Bb5'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Nf6'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Ke2'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Bb4'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Ke1'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Ke7'));
        $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'Nc3'));
        $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'Ke8'));
        $this->assertEquals(false, $board->play(Converter::toObject(Symbol::COLOR_WHITE, 'O-O')));
        $this->assertEquals(false, $board->play(Converter::toObject(Symbol::COLOR_BLACK, 'O-O')));
    }

    public function testCheckCastlingStatusAfterMovingRh1()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'a2'),
            new Pawn(Symbol::COLOR_WHITE, 'd5'),
            new Pawn(Symbol::COLOR_WHITE, 'e4'),
            new Pawn(Symbol::COLOR_WHITE, 'f3'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new Rook(Symbol::COLOR_WHITE, 'a1', RookType::CASTLING_LONG),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Bishop(Symbol::COLOR_BLACK, 'f8'),
            new Knight(Symbol::COLOR_BLACK, 'g8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7')
        ];
        $board = new Board($pieces);
        $board->play(Converter::toObject('w', 'Rg1'));
        $board->play(Converter::toObject('b', 'Nf6'));
        $board->play(Converter::toObject('w', 'Rh1'));
        $board->play(Converter::toObject('b', 'Nd7'));
        $board->play(Converter::toObject('w', 'O-O')); // this won't be run
        $board->play(Converter::toObject('w', 'O-O-O')); // this will be run
        $whiteSquaresUsed = [
            'a2',
            'd5',
            'e4',
            'f3',
            'g2',
            'h2',
            'h1',
            'c1',
            'd1'
        ];
        $whiteSpace = [
            'd2', // rook
            'd3',
            'd4',
            'e1',
            'f1',
            'g1',
            'b3', // pawns
            'c6',
            'e6',
            'f5',
            'g4',
            'g3',
            'h3',
            'b1', // king
            'b2',
            'c2',
            'd2',
            'e1', // rook
            'f1',
            'g1'
        ];
        $whiteSpace = array_filter(array_unique($whiteSpace));
        sort($whiteSpace);
        $whiteAttack = [];
        $this->assertEquals($whiteSquaresUsed, $board->getStatus()->squares->used->w);
        $this->assertEquals($whiteSpace, $board->getStatus()->control->space->w);
        $this->assertEquals($whiteAttack, $board->getStatus()->control->attack->w);
    }

    public function testEnPassantf3()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'e4'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'f4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'exf3')));
    }

    public function testEnPassantf6()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'e5'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'e7'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h7'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $board->setTurn(Symbol::COLOR_BLACK);
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'f5')));
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'exf6')));
    }

    public function testEnPassanth3()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'e7'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g4'),
            new Pawn(Symbol::COLOR_BLACK, 'h7'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'h4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'gxh3')));
    }

    public function testEnPassantg3()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'e2'),
            new Pawn(Symbol::COLOR_WHITE, 'f2'),
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h2'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'e7'),
            new Pawn(Symbol::COLOR_BLACK, 'f7'),
            new Pawn(Symbol::COLOR_BLACK, 'g7'),
            new Pawn(Symbol::COLOR_BLACK, 'h4'),
            new King(Symbol::COLOR_BLACK, 'e8'),
            new Rook(Symbol::COLOR_BLACK, 'h8', RookType::CASTLING_SHORT)
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'g4')));
        $this->assertEquals(true, $board->play(Converter::toObject('b', 'hxg3')));
    }

    public function testPawnPromotion()
    {
        $pieces = [
            new Pawn(Symbol::COLOR_WHITE, 'g2'),
            new Pawn(Symbol::COLOR_WHITE, 'h7'),
            new King(Symbol::COLOR_WHITE, 'e1'),
            new Rook(Symbol::COLOR_WHITE, 'h1', RookType::CASTLING_SHORT),
            new Pawn(Symbol::COLOR_BLACK, 'c7'),
            new Pawn(Symbol::COLOR_BLACK, 'd7'),
            new Pawn(Symbol::COLOR_BLACK, 'e7'),
            new Bishop(Symbol::COLOR_BLACK, 'd6'),
            new King(Symbol::COLOR_BLACK, 'e8')
        ];
        $board = new Board($pieces);
        $this->assertEquals(true, $board->play(Converter::toObject('w', 'h8=Q')));
        // TODO check board status
    }
}
