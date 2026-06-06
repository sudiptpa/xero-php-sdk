<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Support;

use LogicException;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ModelTest extends TestCase
{
    public function test_it_hydrates_every_field_type(): void
    {
        $model = (new GoodModel())->fill([
            'Name' => 'Acme',
            'Amount' => '12.50',
            'Active' => 1,
            'Tags' => ['a', 'b'],
            'Child' => ['Name' => 'child'],
            'Policies' => [['Name' => 'p1'], ['Name' => 'p2']],
            'Data' => [['Name' => 'd1']],
            'Taxes' => [['Name' => 't1']],
            'Items' => [['Name' => 'i1']],
        ]);

        self::assertSame('Acme', $model->getName());
        self::assertSame(12.5, $model->getAmount());
        self::assertTrue($model->getActive());
        self::assertSame(['a', 'b'], $model->getTags());
        self::assertSame('child', $model->getChild()?->getName());
        self::assertCount(2, $model->getPolicies());
        self::assertSame('p1', $model->getPolicies()[0]->getName());
        self::assertCount(1, $model->getData());
        self::assertSame('t1', $model->getTaxes()[0]->getName());
        self::assertSame('i1', $model->getItems()[0]->getName());
    }

    public function test_it_skips_unknown_payload_keys(): void
    {
        $model = (new GoodModel())->fill(['Unmapped' => 'ignored']);

        self::assertNull($model->getName());
    }

    public function test_object_fields_ignore_non_array_values(): void
    {
        $model = (new GoodModel())->fill(['Child' => 'not-an-array']);

        self::assertNull($model->getChild());
    }

    public function test_many_fields_ignore_non_array_values(): void
    {
        $model = (new GoodModel())->fill(['Policies' => 'not-an-array']);

        self::assertSame([], $model->getPolicies());
    }

    public function test_it_throws_when_a_string_setter_is_missing(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Missing method [setValue] for field [Value].');

        (new BrokenString())->fill(['Value' => 'x']);
    }

    public function test_it_throws_when_a_number_setter_is_missing(): void
    {
        $this->expectException(LogicException::class);

        (new BrokenNumber())->fill(['Value' => 1]);
    }

    public function test_it_throws_when_a_boolean_setter_is_missing(): void
    {
        $this->expectException(LogicException::class);

        (new BrokenBoolean())->fill(['Value' => true]);
    }

    public function test_it_throws_when_an_array_setter_is_missing(): void
    {
        $this->expectException(LogicException::class);

        (new BrokenArray())->fill(['Value' => []]);
    }

    public function test_it_throws_when_an_object_setter_is_missing(): void
    {
        $this->expectException(LogicException::class);

        (new BrokenObjectSetter())->fill(['Value' => ['Name' => 'x']]);
    }

    public function test_it_throws_when_an_object_target_lacks_fill(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must define fill()');

        (new BrokenObjectFill())->fill(['Value' => ['Name' => 'x']]);
    }

    public function test_it_throws_when_a_many_adder_is_missing(): void
    {
        $this->expectException(LogicException::class);

        (new BrokenManyAdder())->fill(['Items' => [['Name' => 'x']]]);
    }

    public function test_it_throws_when_a_many_target_lacks_fill(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must define fill()');

        (new BrokenManyFill())->fill(['Items' => [['Name' => 'x']]]);
    }
}

final class ChildModel extends Model
{
    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Name' => Field::string()];
    }
}

/**
 * A plain class with no fill() method, used to trigger the hydrator's
 * "must define fill()" guard for object and many fields.
 */
final class NoFill
{
}

final class GoodModel extends Model
{
    private ?string $name = null;

    private int|float|null $amount = null;

    private ?bool $active = null;

    /** @var array<int, mixed> */
    private array $tags = [];

    private ?ChildModel $child = null;

    /** @var list<ChildModel> */
    private array $policies = [];

    /** @var list<ChildModel> */
    private array $data = [];

    /** @var list<ChildModel> */
    private array $taxes = [];

    /** @var list<ChildModel> */
    private array $items = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): int|float|null
    {
        return $this->amount;
    }

    public function setAmount(int|float|null $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return array<int, mixed>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array<int, mixed> $tags
     */
    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getChild(): ?ChildModel
    {
        return $this->child;
    }

    public function setChild(ChildModel $child): self
    {
        $this->child = $child;

        return $this;
    }

    /**
     * @return list<ChildModel>
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }

    public function addPolicy(ChildModel $policy): self
    {
        $this->policies[] = $policy;

        return $this;
    }

    /**
     * @return list<ChildModel>
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function addData(ChildModel $entry): self
    {
        $this->data[] = $entry;

        return $this;
    }

    /**
     * @return list<ChildModel>
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    public function addTax(ChildModel $tax): self
    {
        $this->taxes[] = $tax;

        return $this;
    }

    /**
     * @return list<ChildModel>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(ChildModel $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Name' => Field::string(),
            'Amount' => Field::number(),
            'Active' => Field::boolean(),
            'Tags' => Field::array(),
            'Child' => Field::object(ChildModel::class),
            'Policies' => Field::many(ChildModel::class),
            'Data' => Field::many(ChildModel::class),
            'Taxes' => Field::many(ChildModel::class),
            'Items' => Field::many(ChildModel::class),
        ];
    }
}

final class BrokenString extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::string()];
    }
}

final class BrokenNumber extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::number()];
    }
}

final class BrokenBoolean extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::boolean()];
    }
}

final class BrokenArray extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::array()];
    }
}

final class BrokenObjectSetter extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::object(ChildModel::class)];
    }
}

final class BrokenObjectFill extends Model
{
    public function setValue(object $value): self
    {
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Value' => Field::object(NoFill::class)];
    }
}

final class BrokenManyAdder extends Model
{
    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Items' => Field::many(ChildModel::class)->using('addItem')];
    }
}

final class BrokenManyFill extends Model
{
    public function addItem(object $item): self
    {
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return ['Items' => Field::many(NoFill::class)->using('addItem')];
    }
}
