<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\PayItem\Deduction;
use Sujip\Xero\Payroll\NZ\PayItem\EarningsRate;
use Sujip\Xero\Payroll\NZ\PayItem\Superannuation;
use Sujip\Xero\Xero;

final class PayItemsTest extends TestCase
{
    public function test_it_lists_finds_and_creates_deductions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'deductions' => [['deductionId' => 'deduction-1', 'deductionName' => 'Rent', 'deductionCategory' => 'NzOther', 'standardAmount' => 200]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'deduction' => ['deductionId' => 'deduction-1', 'deductionName' => 'Rent'],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'deduction' => ['deductionId' => 'deduction-2', 'deductionName' => 'KiwiSaver Voluntary'],
        ], JSON_THROW_ON_ERROR)));

        $deductions = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->deductions();

        $list = $deductions->get();
        $found = $deductions->find('deduction-1');
        $created = $deductions->create(
            (new Deduction())
                ->setDeductionName('KiwiSaver Voluntary')
                ->setDeductionCategory('KiwiSaverVoluntaryContributions')
                ->setLiabilityAccountId('account-1'),
            'deduction-key'
        );

        self::assertSame('/payroll.xro/2.0/Deductions', $transport->requests()[0]->path);
        self::assertSame(200.0, $list->first()?->getStandardAmount());

        self::assertSame('/payroll.xro/2.0/Deductions/deduction-1', $transport->requests()[1]->path);
        self::assertSame('Rent', $found?->getDeductionName());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Deductions', $createRequest->path);
        self::assertSame('deduction-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'deductionName' => 'KiwiSaver Voluntary',
            'deductionCategory' => 'KiwiSaverVoluntaryContributions',
            'liabilityAccountId' => 'account-1',
        ], $createRequest->json);
        self::assertSame('deduction-2', $created->getDeductionId());
    }

    public function test_find_returns_null_when_deduction_is_missing(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $deduction = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->deductions()->find('missing');

        self::assertNull($deduction);
    }

    public function test_it_lists_finds_and_creates_earnings_rates(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'earningsRates' => [['earningsRateID' => 'rate-1', 'name' => 'Ordinary Hours']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningsRate' => ['earningsRateID' => 'rate-1', 'name' => 'Ordinary Hours', 'ratePerUnit' => 25.5],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningsRate' => ['earningsRateID' => 'rate-2', 'name' => 'Overtime'],
        ], JSON_THROW_ON_ERROR)));

        $earningsRates = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->earningsRates();

        $list = $earningsRates->get();
        $found = $earningsRates->find('rate-1');
        $created = $earningsRates->create(
            (new EarningsRate())
                ->setName('Overtime')
                ->setEarningsType('OvertimeEarnings')
                ->setRateType('MultipleOfOrdinaryEarningsRate')
                ->setTypeOfUnits('Hours')
                ->setExpenseAccountID('account-1')
                ->setMultipleOfOrdinaryEarningsRate(1.5)
        );

        self::assertSame('/payroll.xro/2.0/EarningsRates', $transport->requests()[0]->path);
        self::assertSame('Ordinary Hours', $list->first()?->getName());

        self::assertSame('/payroll.xro/2.0/EarningsRates/rate-1', $transport->requests()[1]->path);
        self::assertSame(25.5, $found?->getRatePerUnit());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertArrayNotHasKey('Idempotency-Key', $createRequest->headers);
        self::assertSame([
            'name' => 'Overtime',
            'earningsType' => 'OvertimeEarnings',
            'rateType' => 'MultipleOfOrdinaryEarningsRate',
            'typeOfUnits' => 'Hours',
            'expenseAccountID' => 'account-1',
            'multipleOfOrdinaryEarningsRate' => 1.5,
        ], $createRequest->json);
        self::assertSame('rate-2', $created->getEarningsRateID());
    }

    public function test_it_lists_finds_and_creates_superannuations(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'benefits' => [['id' => 'super-1', 'name' => 'KiwiSaver', 'category' => 'KiwiSaver']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'benefit' => ['id' => 'super-1', 'name' => 'KiwiSaver', 'percentage' => 3],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'benefit' => ['id' => 'super-2', 'name' => 'Complying Fund'],
        ], JSON_THROW_ON_ERROR)));

        $superannuations = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->superannuations();

        $list = $superannuations->get();
        $found = $superannuations->find('super-1');
        $created = $superannuations->create(
            (new Superannuation())
                ->setName('Complying Fund')
                ->setCategory('ComplyingFund')
                ->setLiabilityAccountId('account-1')
                ->setExpenseAccountId('account-2')
                ->setCalculationTypeNZ('PercentageOfTaxableEarnings')
                ->setPercentage(3.0)
        );

        self::assertSame('/payroll.xro/2.0/Superannuations', $transport->requests()[0]->path);
        self::assertSame('KiwiSaver', $list->first()?->getName());

        self::assertSame('/payroll.xro/2.0/Superannuations/super-1', $transport->requests()[1]->path);
        self::assertSame(3.0, $found?->getPercentage());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Superannuations', $createRequest->path);
        self::assertSame([
            'name' => 'Complying Fund',
            'category' => 'ComplyingFund',
            'liabilityAccountId' => 'account-1',
            'expenseAccountId' => 'account-2',
            'calculationTypeNZ' => 'PercentageOfTaxableEarnings',
            'percentage' => 3.0,
        ], $createRequest->json);
        self::assertSame('super-2', $created->getId());
    }

    public function test_pay_item_resources_paginate_and_expose_scopes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"deductions": []}'));
        $transport->push(new Response(200, body: '{"earningsRates": []}'));
        $transport->push(new Response(200, body: '{"benefits": []}'));

        $nz = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->payroll()->nz();

        foreach (['deductions', 'earningsRates', 'superannuations'] as $index => $method) {
            $resource = $nz->{$method}();
            $page = $resource->paginate(page: 2, perPage: 50);

            self::assertSame(2, $transport->requests()[$index]->query['page']);
            self::assertSame(50, $transport->requests()[$index]->query['pageSize']);
            self::assertSame(2, $page->page);
            self::assertSame(['payroll.settings'], $resource->scopes()->broad);
            self::assertSame(['payroll.settings.read', 'payroll.settings'], $resource->scopes()->granular);
        }
    }

    public function test_deduction_model_hydrates_every_field(): void
    {
        $deduction = (new Deduction())->fill([
            'deductionId' => 'deduction-1',
            'deductionName' => 'Rent',
            'deductionCategory' => 'NzOther',
            'liabilityAccountId' => 'account-1',
            'currentRecord' => true,
            'standardAmount' => 200,
        ]);

        self::assertSame('deduction-1', $deduction->getDeductionId());
        self::assertSame('NzOther', $deduction->getDeductionCategory());
        self::assertSame('account-1', $deduction->getLiabilityAccountId());
        self::assertTrue($deduction->getCurrentRecord());
        self::assertSame(200.0, $deduction->getStandardAmount());
    }

    public function test_earnings_rate_model_hydrates_every_field(): void
    {
        $rate = (new EarningsRate())->fill([
            'earningsRateID' => 'rate-1',
            'name' => 'Ordinary Hours',
            'earningsType' => 'RegularEarnings',
            'rateType' => 'RatePerUnit',
            'typeOfUnits' => 'Hours',
            'currentRecord' => true,
            'expenseAccountID' => 'account-1',
            'ratePerUnit' => 25.5,
            'multipleOfOrdinaryEarningsRate' => 1.5,
            'fixedAmount' => 100,
        ]);

        self::assertSame('rate-1', $rate->getEarningsRateID());
        self::assertSame('RegularEarnings', $rate->getEarningsType());
        self::assertSame('RatePerUnit', $rate->getRateType());
        self::assertSame('Hours', $rate->getTypeOfUnits());
        self::assertTrue($rate->getCurrentRecord());
        self::assertSame('account-1', $rate->getExpenseAccountID());
        self::assertSame(25.5, $rate->getRatePerUnit());
        self::assertSame(1.5, $rate->getMultipleOfOrdinaryEarningsRate());
        self::assertSame(100.0, $rate->getFixedAmount());
    }

    public function test_superannuation_model_hydrates_every_field(): void
    {
        $superannuation = (new Superannuation())->fill([
            'id' => 'super-1',
            'name' => 'KiwiSaver',
            'category' => 'KiwiSaver',
            'liabilityAccountId' => 'account-1',
            'expenseAccountId' => 'account-2',
            'calculationTypeNZ' => 'FixedAmount',
            'standardAmount' => 100,
            'percentage' => 3,
            'companyMax' => 500,
        ]);

        self::assertSame('super-1', $superannuation->getId());
        self::assertSame('KiwiSaver', $superannuation->getCategory());
        self::assertSame('account-1', $superannuation->getLiabilityAccountId());
        self::assertSame('account-2', $superannuation->getExpenseAccountId());
        self::assertSame('FixedAmount', $superannuation->getCalculationTypeNZ());
        self::assertSame(100.0, $superannuation->getStandardAmount());
        self::assertSame(3.0, $superannuation->getPercentage());
        self::assertSame(500.0, $superannuation->getCompanyMax());
    }
}
