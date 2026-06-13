<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class CashValidationTest extends TestCase
{
    public function test_it_can_get_cash_validation(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            [
                'accountId' => '73151de8-3676-4887-a021-edec960dd537',
                'statementBalance' => [
                    'value' => 100,
                    'type' => 'DEBIT',
                ],
                'statementBalanceDate' => '2021-03-01',
                'bankStatement' => [
                    'statementLines' => [
                        'unreconciledAmountPos' => 4577,
                        'unreconciledAmountNeg' => -2367,
                        'unreconciledLines' => 8,
                        'avgDaysUnreconciledPos' => 112.265531,
                        'avgDaysUnreconciledNeg' => 149.298992,
                        'earliestUnreconciledTransaction' => '2019-03-01',
                        'latestUnreconciledTransaction' => '2021-03-01',
                        'deletedAmount' => 50,
                        'totalAmount' => 189,
                        'dataSource' => [
                            'directBankFeed' => 0,
                            'fileUpload' => 300,
                            'manual' => -188,
                            'directBankFeedPos' => 0,
                            'fileUploadPos' => 2223,
                            'manualPos' => 0,
                            'directBankFeedNeg' => 0,
                            'fileUploadNeg' => -1890,
                            'manualNeg' => -500,
                            'otherPos' => 0,
                            'otherNeg' => 0,
                            'other' => 100,
                        ],
                        'earliestReconciledTransaction' => '2019-03-01',
                        'latestReconciledTransaction' => '2020-03-01',
                        'reconciledAmountPos' => 0,
                        'reconciledAmountNeg' => -288,
                        'reconciledLines' => 3,
                        'totalAmountPos' => 2245,
                        'totalAmountNeg' => -1995,
                    ],
                    'currentStatement' => [
                        'startDate' => '2021-03-01',
                        'endDate' => '2021-03-01',
                        'startBalance' => 0,
                        'endBalance' => 0,
                        'importedDateTimeUtc' => '2021-03-09T05:22:14.3Z',
                        'importSourceType' => 'Manual',
                    ],
                ],
                'cashAccount' => [
                    'unreconciledAmountPos' => 1440,
                    'unreconciledAmountNeg' => -1000,
                    'startingBalance' => 0,
                    'accountBalance' => 0,
                    'balanceCurrency' => 'NZD',
                ],
            ],
        ], JSON_THROW_ON_ERROR)));

        $results = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->cashValidation()
            ->get(
                balanceDate: new DateTimeImmutable('2021-09-15'),
                asAtSystemDate: new DateTimeImmutable('2021-09-15'),
                beginDate: new DateTimeImmutable('2021-01-01'),
            );

        self::assertSame('/finance.xro/1.0/CashValidation', $transport->requests()[0]->path);
        self::assertSame('2021-09-15', $transport->requests()[0]->query['balanceDate']);
        self::assertSame('2021-09-15', $transport->requests()[0]->query['asAtSystemDate']);
        self::assertSame('2021-01-01', $transport->requests()[0]->query['beginDate']);

        $result = $results->first();
        self::assertNotNull($result);
        self::assertSame('73151de8-3676-4887-a021-edec960dd537', $result->getAccountId());
        self::assertSame('2021-03-01', $result->getStatementBalanceDate());

        $statementBalance = $result->getStatementBalance();
        self::assertNotNull($statementBalance);
        self::assertSame(100, $statementBalance->getValue());
        self::assertSame('DEBIT', $statementBalance->getType());

        $bankStatement = $result->getBankStatement();
        self::assertNotNull($bankStatement);

        $statementLines = $bankStatement->getStatementLines();
        self::assertNotNull($statementLines);
        self::assertSame(4577, $statementLines->getUnreconciledAmountPos());
        self::assertSame(8, $statementLines->getUnreconciledLines());
        self::assertSame(112.265531, $statementLines->getAvgDaysUnreconciledPos());

        $dataSource = $statementLines->getDataSource();
        self::assertNotNull($dataSource);
        self::assertSame(300, $dataSource->getFileUpload());
        self::assertSame(-1890, $dataSource->getFileUploadNeg());

        $currentStatement = $bankStatement->getCurrentStatement();
        self::assertNotNull($currentStatement);
        self::assertSame('2021-03-01', $currentStatement->getStartDate());
        self::assertSame('Manual', $currentStatement->getImportSourceType());

        $cashAccount = $result->getCashAccount();
        self::assertNotNull($cashAccount);
        self::assertSame(1440, $cashAccount->getUnreconciledAmountPos());
        self::assertSame('NZD', $cashAccount->getBalanceCurrency());
    }
}
