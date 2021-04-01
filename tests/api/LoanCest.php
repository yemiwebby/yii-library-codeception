<?php

use Codeception\Util\HttpCode;

class LoanCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    public function borrowBook(ApiTester $I) {

        $I->sendPost(
            'loans',
            [
                'book_id'   => 1,
                'member_id' => 1,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'id'                => 'integer',
                'book_id'           => 'string',
                'borrower_id'       => 'string',
                'borrowed_on'       => 'string',
                'to_be_returned_on' => 'string'
            ]
        );
    }

    public function tryToDoubleBorrowBook(ApiTester $I) {

        $I->sendPost(
            'loans',
            [
                'book_id'   => 1,
                'member_id' => 3,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->sendPost(
            'loans',
            [
                'book_id'   => 1,
                'member_id' => 3,
            ]
        );
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson(
            [
                'error' => 'This book is not available for loan'
            ]
        );
    }
}
