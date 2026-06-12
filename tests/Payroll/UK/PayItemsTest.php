<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\PayItem\Benefit;
use Sujip\Xero\Payroll\UK\PayItem\Deduction;
use Sujip\Xero\Payroll\UK\PayItem\EarningsRate;
use Sujip\Xero\Xero;

final class PayItemsTest extends TestCase
{
    public function test_it_lists_finds_and_creates_deductions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'deductions' => [['deductionId' => 'deduction-1', 'deductionName' => 'Salary Sacrifice']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'deduction' => ['deductionId' => 'deduction-1', 'deductionName' => 'Salary Sacrifice', 'percentage' => 5],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'deduction' => ['deductionId' => 'deduction-2', 'deductionName' => 'Student Loan'],
        ], JSON_THROW_ON_ERROR)));

        $deductions = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->deductions();

        $list = $deductions->get();
        $found = $deductions->find('deduction-1');
        $created = $deductions->create(
            (new Deduction())
                ->setDeductionName('Student Loan')
                ->setDeductionCategory('StudentLoanDeductions')
                ->setLiabilityAccountId('account-1')
                ->setCalculationType('FixedAmount'),
            'deduction-key'
        );

        self::assertSame('/payroll.xro/2.0/Deductions', $transport->requests()[0]->path);
        self::assertSame('Salary Sacrifice', $list->first()?->getDeductionName());

        self::assertSame('/payroll.xro/2.0/Deductions/deduction-1', $transport->requests()[1]->path);
        self::assertSame(5.0, $found?->getPercentage());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('deduction-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'deductionName' => 'Student Loan',
            'deductionCategory' => 'StudentLoanDeductions',
            'liabilityAccountId' => 'account-1',
            'calculationType' => 'FixedAmount',
        ], $createRequest->json);
        self::assertSame('deduction-2', $created->getDeductionId());
    }

    public function test_it_lists_finds_and_creates_earnings_rates(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'earningsRates' => [['earningsRateID' => 'rate-1', 'name' => 'Regular Hours']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningsRate' => [
                'earningsRateID' => 'rate-1',
                'name' => 'Regular Hours',
                'fixedAmount' => 100,
                'currentRecord' => true,
                'multipleOfOrdinaryEarningsRate' => 1.5,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningsRate' => ['earningsRateID' => 'rate-2', 'name' => 'Overtime'],
        ], JSON_THROW_ON_ERROR)));

        $earningsRates = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->earningsRates();

        $list = $earningsRates->get();
        $found = $earningsRates->find('rate-1');
        $created = $earningsRates->create(
            (new EarningsRate())
                ->setName('Overtime')
                ->setEarningsType('OvertimeEarnings')
                ->setRateType('RatePerUnit')
                ->setTypeOfUnits('Hours')
                ->setExpenseAccountID('account-1')
                ->setRatePerUnit(30.0)
        );

        self::assertSame('/payroll.xro/2.0/EarningsRates', $transport->requests()[0]->path);
        self::assertSame('Regular Hours', $list->first()?->getName());
        self::assertNotNull($found);
        self::assertSame(100.0, $found->getFixedAmount());
        self::assertTrue($found->getCurrentRecord());
        self::assertSame(1.5, $found->getMultipleOfOrdinaryEarningsRate());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertSame([
            'name' => 'Overtime',
            'earningsType' => 'OvertimeEarnings',
            'rateType' => 'RatePerUnit',
            'typeOfUnits' => 'Hours',
            'expenseAccountID' => 'account-1',
            'ratePerUnit' => 30.0,
        ], $createRequest->json);
        self::assertSame('rate-2', $created->getEarningsRateID());
    }

    public function test_it_lists_finds_and_creates_benefits(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'benefits' => [['id' => 'benefit-1', 'name' => 'Stakeholder Pension', 'category' => 'StakeholderPension']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'benefit' => ['id' => 'benefit-1', 'name' => 'Stakeholder Pension', 'percentage' => 4],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'benefit' => ['id' => 'benefit-2', 'name' => 'Other Benefit'],
        ], JSON_THROW_ON_ERROR)));

        $benefits = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->benefits();

        $list = $benefits->get();
        $found = $benefits->find('benefit-1');
        $created = $benefits->create(
            (new Benefit())
                ->setName('Other Benefit')
                ->setCategory('Other')
                ->setLiabilityAccountId('account-1')
                ->setExpenseAccountId('account-2')
                ->setCalculationType('FixedAmount')
                ->setStandardAmount(50.0)
        );

        self::assertSame('/payroll.xro/2.0/Benefits', $transport->requests()[0]->path);
        self::assertSame('Stakeholder Pension', $list->first()?->getName());
        self::assertSame(4.0, $found?->getPercentage());

        $createRequest = $transport->requests()[2];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Benefits', $createRequest->path);
        self::assertSame([
            'name' => 'Other Benefit',
            'category' => 'Other',
            'liabilityAccountId' => 'account-1',
            'expenseAccountId' => 'account-2',
            'standardAmount' => 50.0,
            'calculationType' => 'FixedAmount',
        ], $createRequest->json);
        self::assertSame('benefit-2', $created->getId());
    }

    public function test_it_lists_and_finds_earnings_orders(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'statutoryDeductions' => [['id' => 'order-1', 'name' => 'Attachment of Earnings']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'statutoryDeduction' => [
                'id' => 'order-1',
                'name' => 'Attachment of Earnings',
                'statutoryDeductionCategory' => 'AttachmentOfEarningsOrder',
                'liabilityAccountId' => 'account-1',
                'currentRecord' => true,
            ],
        ], JSON_THROW_ON_ERROR)));

        $earningsOrders = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->earningsOrders();

        $list = $earningsOrders->get();
        $found = $earningsOrders->find('order-1');

        self::assertSame('/payroll.xro/2.0/EarningsOrders', $transport->requests()[0]->path);
        self::assertSame('Attachment of Earnings', $list->first()?->getName());

        self::assertSame('/payroll.xro/2.0/EarningsOrders/order-1', $transport->requests()[1]->path);
        self::assertNotNull($found);
        self::assertSame('order-1', $found->getId());
        self::assertSame('AttachmentOfEarningsOrder', $found->getStatutoryDeductionCategory());
        self::assertSame('account-1', $found->getLiabilityAccountId());
        self::assertTrue($found->getCurrentRecord());
    }

    public function test_pay_item_resources_paginate_and_expose_scopes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"deductions": []}'));
        $transport->push(new Response(200, body: '{"earningsRates": []}'));
        $transport->push(new Response(200, body: '{"benefits": []}'));
        $transport->push(new Response(200, body: '{"statutoryDeductions": []}'));

        $uk = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->payroll()->uk();

        foreach (['deductions', 'earningsRates', 'benefits', 'earningsOrders'] as $index => $method) {
            $resource = $uk->{$method}();
            $page = $resource->paginate(page: 3, perPage: 25);

            self::assertSame(3, $transport->requests()[$index]->query['page']);
            self::assertSame(25, $transport->requests()[$index]->query['pageSize']);
            self::assertSame(3, $page->page);
            self::assertSame(['payroll.settings'], $resource->scopes()->broad);
            self::assertSame(['payroll.settings.read', 'payroll.settings'], $resource->scopes()->granular);
        }
    }

    public function test_uk_deduction_model_hydrates_every_field(): void
    {
        $deduction = (new Deduction())->fill([
            'deductionId' => 'deduction-1',
            'deductionName' => 'Salary Sacrifice',
            'deductionCategory' => 'SalarySacrifice',
            'liabilityAccountId' => 'account-1',
            'currentRecord' => true,
            'standardAmount' => 100,
            'reducesSuperLiability' => true,
            'reducesTaxLiability' => false,
            'calculationType' => 'PercentageOfGross',
            'percentage' => 5,
            'subjectToNIC' => true,
            'subjectToTax' => false,
            'isReducedByBasicRate' => true,
            'applyToPensionCalculations' => false,
            'isCalculatingOnQualifyingEarnings' => true,
            'isPension' => false,
        ]);

        self::assertSame('deduction-1', $deduction->getDeductionId());
        self::assertSame('SalarySacrifice', $deduction->getDeductionCategory());
        self::assertSame('account-1', $deduction->getLiabilityAccountId());
        self::assertTrue($deduction->getCurrentRecord());
        self::assertSame(100.0, $deduction->getStandardAmount());
        self::assertTrue($deduction->getReducesSuperLiability());
        self::assertFalse($deduction->getReducesTaxLiability());
        self::assertSame('PercentageOfGross', $deduction->getCalculationType());
        self::assertSame(5.0, $deduction->getPercentage());
        self::assertTrue($deduction->getSubjectToNIC());
        self::assertFalse($deduction->getSubjectToTax());
        self::assertTrue($deduction->getIsReducedByBasicRate());
        self::assertFalse($deduction->getApplyToPensionCalculations());
        self::assertTrue($deduction->getIsCalculatingOnQualifyingEarnings());
        self::assertFalse($deduction->getIsPension());
    }

    public function test_uk_benefit_model_hydrates_every_field(): void
    {
        $benefit = (new Benefit())->fill([
            'id' => 'benefit-1',
            'name' => 'Pension',
            'category' => 'StakeholderPension',
            'liabilityAccountId' => 'account-1',
            'expenseAccountId' => 'account-2',
            'standardAmount' => 75,
            'percentage' => 4,
            'calculationType' => 'PercentageOfGross',
            'currentRecord' => true,
            'subjectToNIC' => true,
            'subjectToPension' => false,
            'subjectToTax' => true,
            'isCalculatingOnQualifyingEarnings' => false,
            'showBalanceToEmployee' => true,
        ]);

        self::assertSame('benefit-1', $benefit->getId());
        self::assertSame('StakeholderPension', $benefit->getCategory());
        self::assertSame('account-1', $benefit->getLiabilityAccountId());
        self::assertSame('account-2', $benefit->getExpenseAccountId());
        self::assertSame(75.0, $benefit->getStandardAmount());
        self::assertSame(4.0, $benefit->getPercentage());
        self::assertSame('PercentageOfGross', $benefit->getCalculationType());
        self::assertTrue($benefit->getCurrentRecord());
        self::assertTrue($benefit->getSubjectToNIC());
        self::assertFalse($benefit->getSubjectToPension());
        self::assertTrue($benefit->getSubjectToTax());
        self::assertFalse($benefit->getIsCalculatingOnQualifyingEarnings());
        self::assertTrue($benefit->getShowBalanceToEmployee());
    }
}
